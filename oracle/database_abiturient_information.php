<?php

    require('database_connect_PDO.php');
	require_once('../auth/ad_functions.php');

	modifyPost();
	$Nrec_speciality = '800100000000030A';

	  $query=$conn->prepare("select row_number() over (partition by fNrec order by 
         case when Status = 'Зачислен'     and Lgota        = 'Да' then 1
              when Status = 'Зачислен'     and Cel_RF_Yes   =  1   then 2
              when Status = 'Зачислен'                             then 3
              when Status = 'Рекомендован' and Lgota        = 'Да' then 4
              when Status = 'Рекомендован' and Cel_RF_Yes   =  1   then 5 
              when Status = 'Рекомендован' and RF_Yes       =  1   then 6
              when Status = 'Рекомендован' and Cel_HMAO_Yes =  1   then 7
              when Status = 'Рекомендован'                         then 8
              when Status = 'Абитуриент' or Status = 'Оформляемый' then 9 else 9 end,
         case when (Status = 'Зачислен' or Status = 'Рекомендован') and (Lgota = 'Да' or Cel_RF_Yes = 1) then fsfio else to_char(decode(fwMark,0,1,fwMark)-1000) end, fsFio) as  \"rownum\",       --№п/п 
       cast(fsFio AS VARCHAR2(256)) fsFio ,        --ФИО 
       cast(fwPriority AS VARCHAR2(256)) fwPriority,   --Приоритет
       cast(Lgota    AS VARCHAR2(256)) Lgota ,        --Льгота
       cast(Celevoe  AS VARCHAR2(256)) Celevoe,      --Целевое
       case when (Status  = 'Зачислен' or Status = 'Рекомендован') and (Lgota = 'Да' or Cel_RF_Yes = 1) then ' ' else to_char(fwMark) end fwMark,   --Коли-во баллов
       cast(Status		 AS VARCHAR2(256)) Status		,       --Статус
       cast(Docs		 AS VARCHAR2(256)) Docs		    ,         --Подлинник аттестата
       cast(Plan_Name	 AS VARCHAR2(256)) Plan_Name	,    --Специальность
       cast(Only_VB		 AS VARCHAR2(256)) Only_VB		,      --Только на ВБ (для заочников)
       cast(fwFormEd	 AS VARCHAR2(256)) fwFormEd	    ,     --Форма обучения 0-Очка, 1-Заочка   
       cast(Cel_RF_Yes	 AS VARCHAR2(256)) Cel_RF_Yes	,   --Рекомендован, зачислен по целевому РФ  
       cast(Cel_HMAO_Yes AS VARCHAR2(256)) Cel_HMAO_Yes , --Рекомендован, зачислен по целевому ХМАО  
       cast(HMAO_Yes	 AS VARCHAR2(256)) HMAO_Yes	    ,     --Рекомендован, зачислен по ХМАО  
       cast(RF_Yes		 AS VARCHAR2(256)) RF_Yes		,       --Рекомендован на Бюджет РФ 
       cast(Spisok_Dis	 AS VARCHAR2(256)) Spisok_Dis	,   --Список дисциплин по плану в одну строчку через '\'
       cast(Spisok_Marks AS VARCHAR2(256)) Spisok_Marks , 
       case when lower(Spisok_Dis) like '%физика%' then to_char(summa+7990) ||',00' else summa end summa,        --стипендия в зависимости от баллов
       decode(Sogl, null, '-', '+') Sogl, --согласие о зачислении
       case when  fwFormEd = 1 then ''
            when (Status = 'Зачислен'    or Status = 'Рекомендован') and Lgota = 'Да'     then 'Бюджет РФ; вне конкурса'
            when (Status = 'Зачислен'    or Status = 'Рекомендован') and Cel_RF_Yes = 1   then 'Бюджет РФ; целевое' 
            when (Status = 'Зачислен'    or Status = 'Рекомендован') and RF_Yes = 1       then 'Бюджет РФ'
            when (Status = 'Зачислен'    or Status = 'Рекомендован') and Cel_HMAO_Yes = 1 then 'Целевая региональная подготовка'--'Целевой ХМАО'
            when (Status = 'Зачислен'    or Status = 'Рекомендован') and HMAO_Yes = 1 then 'Региональная подготовка' --'ХМАО'
            when (Status = 'Зачислен'    or Status = 'Рекомендован') and Only_VB = 1      then 'С оплатой стоимости обучения'
            when (Status = 'Абитуриент')                                                  then ''
            else ' ' end Rekomend 
from (
select distinct UA.fsFio,  UP.fNrec
       ,least(UAP.fwPriority, ABS(UAP.fwPriority-30)) fwPriority,
       NVL(URC.Lgota, 'Нет') Lgota,
       decode(UAPF_RF.Cel_RF, NULL,NVL(UAPF_HMAO1.Cel_HMAO, ''), 
              UAPF_RF.Cel_RF||decode(UAPF_HMAO1.Cel_HMAO, NULL,'', ', '||UAPF_HMAO1.Cel_HMAO)) Celevoe,
       NVL(O.fwMark,0) fwMark,
       decode(UA.fwStatus, 0,'Оформляемый',
                           3, decode(UP.fwFormEd, 0, 'Абитуриент', 'Абитуриент'), 
                           1,'Выбыл', 
                           4,'Рекомендован'||decode(UAP.fwResult, 2,' по другой специальности', ''), 
                           2,'Зачислен'   ||decode(UAP.fwResult,  2,' по другой специальности', '')
              ) Status,
       NVL(replace(T.Docs,1,'+'),'-') Docs,
       UCC.fName Plan_Name, UAPF.Only_VB, UP.fwFormEd, Cel_RF_Yes, Cel_HMAO_Yes, RF_Yes, HMAO_Yes,
       VUPD.Spisok_Dis||decode(UA.\"FDADDFLD[1]\",0,'',UA.\"FDADDFLD[1]\") Spisok_Dis, VUPD.Spisok_Marks, GRF.summa, --Sogl.fcode Sogl
       listagg(Sogl.fcode, '; ') within group (order by Sogl.fcode)  Sogl
  from U_Abiturient UA inner join U_Abiturient_Plan UAP on UAP.fcAbiturient   =  UA.fNrec
                       inner join U_Plan             UP on UAP.fcPlan         =  UP.fNrec --and UP.fwFormEd = 0
                       inner join U_CurriCulum      UCC on UP.fcU_CurriCulum  = UCC.fNrec 
                       inner join Catalogs            Q on UP.fcqualification =   Q.fNrec        
                       
                  left outer join (select UAPF.fCu_Plan, UAPF.fcAbiturient, 
                                          case when min(UAPF.fcFinSource) = max(UAPF.fcFinSource) and min(UAPF.fcFinSource) = '800100000000090D'
                                               then 'ДА' else '' end Only_VB
                                     from U_Abit_Plan_Fin UAPF, U_Abiturient UA, U_Plan UP
                                    where UAPF.fcAbiturient = UA.fNrec
                                      and UAPF.fCu_Plan     = UP.fNrec
                                      and UAPF.fcFinSource in ('800100000000090C','800100000000091B', case when UP.fwFormEd = 0 then '999' else '800100000000090D' end)
                                      and UAPF.fwPlanResult = 1
                                   group by UAPF.fCu_Plan, UAPF.fcAbiturient) UAPF  on UAPF.fCu_Plan     = UAP.fcPlan 
                                                                                   and UAPF.fcAbiturient = UAP.fcAbiturient
                  --Есть ли у абитуриента заявление на Целевое РФ
                  left outer join (select distinct UAPF.fCu_Plan, UAPF.fcAbiturient, 'РФ' Cel_RF, UAPF.fwResult Cel_RF_Yes
                                     from U_Abit_Plan_Fin UAPF, U_Abiturient UA
                                    where UAPF.fcAbiturient = UA.fNrec
                                      and UAPF.fcFinSource = '800100000000091B' --Целевое РФ
                                      and UAPF.fwPlanResult = 1) UAPF_RF  on UAPF_RF.fCu_Plan     = UAP.fcPlan 
                                                                         and UAPF_RF.fcAbiturient = UAP.fcAbiturient
                 --Есть ли у абитуриента заявление просто на РФ                                             
                  left outer join (select distinct UAPF.fCu_Plan, UAPF.fcAbiturient, 'РФ' RF, UAPF.fwResult RF_Yes
                                     from U_Abit_Plan_Fin UAPF, U_Abiturient UA
                                    where UAPF.fcAbiturient = UA.fNrec
                                      and UAPF.fcFinSource = '800100000000090C' --Бюджет РФ
                                      and UAPF.fwPlanResult = 1) UAPF_RF_P  on UAPF_RF_P.fCu_Plan     = UAP.fcPlan 
                                                                           and UAPF_RF_P.fcAbiturient = UAP.fcAbiturient
                  left outer join (select distinct UAPF.fCu_Plan, UAPF.fcAbiturient, 'ХМАО' HMAO, UAPF.fwResult HMAO_Yes
                                     from U_Abit_Plan_Fin UAPF, U_Abiturient UA, SpKau S
                                    where UAPF.fcAbiturient = UA.fNrec
                                      and UAPF.fcFinsource  = S.fNrec
                                      and S.fCode = 'ХМАО-'||to_char(to_date(to_char(sysdate,'YYYY'),'YYYY'),'yy') --Celevoe HMAO
                                      and UAPF.fwPlanResult = 1) UAPF_HMAO  on UAPF_HMAO.fCu_Plan     = UAP.fcPlan 
                                                                           and UAPF_HMAO.fcAbiturient = UAP.fcAbiturient
                  left outer join (select distinct UAPF.fCu_Plan, UAPF.fcAbiturient, 'Целевой ХМАО' Cel_HMAO, UAPF.fwResult Cel_HMAO_Yes
                                     from U_Abit_Plan_Fin UAPF, U_Abiturient UA, SpKau S
                                    where UAPF.fcAbiturient = UA.fNrec
                                      and UAPF.fcFinsource  = S.fNrec
                                      and S.fCode = 'Целевой ХМАО' --Celevoe HMAO
                                      and UAPF.fwPlanResult = 1) UAPF_HMAO1  on UAPF_HMAO1.fCu_Plan     = UAP.fcPlan 
                                                                           and UAPF_HMAO1.fcAbiturient = UAP.fcAbiturient
                  left outer join (select distinct UAP.fcAbiturient, 1 Docs 
                                     from U_APassports UAP 
                                    where UAP.fDocName = '8001000000002BA4'
                                      and UAP.fAuthentiCity = 1) T on T.fcAbiturient = UA.fNrec                    
                  left outer join (select UAM.fcAbiturient, UAPD.fCu_Plan, sum(UAM.fwMark) fwMark
                                     from U_Abit_Plan_Dis UAPD, V_U_Abit_Marks UAM
                                    where UAPD.fwNeed = 0
                                      and UAM.fcAbiturient = UAPD.fcAbiturient
                                      and UAM.fcDis        = UAPD.fcDiscipline 
                                   group by UAM.fcAbiturient, UAPD.fCu_Plan) O  on O.fcAbiturient = UA.fNrec
                                                                              and O.fCu_Plan     = UP.fNrec
                   -- вычисляем стипендию РФ
                   left outer join grantRF GRF on GRF.fyear = to_char(sysdate,'YYYY') and Q.fcode = GRF.flevel AND UP.fwFormEd=0 and o.fwmark between GRF.b_ball and GRF.e_ball 
                                               and GRF.FIN = case when not UAPF_RF_P.RF_Yes    is null then 0
                                                                  when not UAPF_HMAO.HMAO_Yes  is null then 2
                                                             end -- пока берем только бюджет РФ
                   
                   --согласие о зачислении
                   left outer join (select UAPF.fcu_Plan, UAPF.fcAbiturient, decode(UAPF.fwResult, 1,'<b>'|| UAPF.fwPriority||'-'||K.fCode ||'</b>', 
                                       UAPF.fwPriority||'-'||K.fCode          ) fCode 
                                    from U_Abit_Plan_Fin UAPF, SpKau K
                                     where UAPF.fcFinsource  =  K.fNrec
                                        --   and UAPF.fcFinSource  <> '800100000000091B' -- Целевой не берём - это в другом столбце
                                             
                                              and UAPF.ffilialno =  1
                                    order by 1 )  Sogl on   Sogl.fcAbiturient = UA.fnrec and   Sogl.fcu_Plan  = :fNrec_Plan                                                      
               
                --Сдал все экзамены
                  left outer join (select distinct UAPD.fCu_Plan, UAPD.fcAbiturient--, UAM.fwMark, UPD.fMinMark
                                     from U_Abit_Plan_Dis UAPD inner join U_Plan_Discipline UPD  on UAPD.fCu_Plan     = UPD.fCu_Plan
                                                                                                and UAPD.fcDiscipline = UPD.fcDiscipline
                                                          left outer join V_U_Abit_Marks    UAM  on UAM.fcDis         = UAPD.fcDiscipline
                                                                                                and UAM.fcAbiturient  = UAPD.fcAbiturient
                                    where NVL(UAM.fwMark, 0) < UPD.fMinMark
                                   ) Oe  on Oe.fCu_Plan     = UP.fNrec
                                        and Oe.fcAbiturient = UA.fNrec 
                                        
                  left outer join (select distinct URC.fcAbiturient, 'Да' Lgota
                                     from U_ReceiveCategory URC
                                    where URC.fcCategory_Name <> '8000000000000000'
                                      and URC.fwCategory = 3) URC  on URC.fcAbiturient  = UA.fNrec
                                                                  and UAP.fwPriority    = 1 
                                                                  and UAP.\"FWADDFLD[1]\" = 1
                                                                  and UAP.\"FWADDFLD[2]\" = 1
                  left outer join (
select X.fcU_Plan, X.fcAbiturient, substr(X.path,2) Spisok_Dis, substr(X.path_Mark,2) Spisok_Marks
  from (select Z.fcU_Plan, Z.fcAbiturient, Z.path, Z.lv, Z.path_Mark,
               count(*) over (partition by Z.fcAbiturient) cnt
          from (select Z_UAPD.fcU_Plan, Z_UAPD.fcAbiturient, Z_UAPD.fName, rn, Z_UAPD.fwMark,
                       sys_connect_by_path(Z_UAPD.fName||'-'||Z_UAPD.fwMark,', ') as path, level as lv,
                       sys_connect_by_path(Z_UAPD.fwMark,'\') as path_Mark              
                  from (select UAPD.fcU_Plan, UAPD.fcAbiturient, C.fName, NVL(UAM.fwMark,UAPD.fwMark) fwMark,
                               row_number() over (partition by UAPD.fcU_Plan, UAPD.fcAbiturient order by C.fName) rn,
                               rank() over (partition by UAPD.fcU_Plan order by UAPD.fcAbiturient) rank,
                               row_number() over (partition by UAPD.fcU_Plan, UAPD.fcAbiturient order by C.fName) +
                               rank() over (partition by UAPD.fcU_Plan order by UAPD.fcAbiturient)*100 rank_
                          from U_Abit_Plan_Dis UAPD inner join Catalogs         C on UAPD.fcDiscipline = C.fNrec
                                               left outer join V_U_Abit_Marks UAM  on UAM.fcAbiturient = UAPD.fcAbiturient
                                                                                  and UAM.fcDis        = UAPD.fcDiscipline 
                         where UAPD.fwNeed = 0
                           and UAPD.fcU_Plan = :fNrec_Plan
                        order by UAPD.fcU_Plan, UAPD.fcAbiturient 
                        ) Z_UAPD
                start with rn = 1
                connect by prior Z_UAPD.rank_+1 = Z_UAPD.rank_
                order by Z_UAPD.fcU_Plan, Z_UAPD.fcAbiturient
                ) Z
        ) X
where X.lv = X.cnt
) VUPD on VUPD.fcAbiturient = UA.fNrec
where to_char(to_oradate(UA.fdRegDate),'YYYY') = to_char(sysdate,'YYYY')
   and UA.fwStatus   <> 1 --Ne vibil
--   and decode(UA.fwStatus, 4,2, UA.fwStatus) <> decode(UP.fwFormEd, 0,2, 666)
   and UA.fwDopInfo2 =  0 --Ne zabral documenti
-- and UP.fwFormEd = 1
   and UP.fNrec = :fNrec_Plan --'8001000000000103'--
--   and not (T.Docs <> 1 and fwFormEd = 0) --
   and not exists (select distinct VAPN.fCu_Plan, VAPN.fcAbiturient
                     from V_Abit_Plan_NeSdal VAPN
                    where VAPN.fCu_Plan     = UP.fNrec
                      and VAPN.fcAbiturient = UA.fNrec) --Нет двоек по экзаменам
group by UA.fsFio,  UP.fNrec, UAP.fwPriority, URC.Lgota, UAPF_RF.Cel_RF, UAPF_HMAO1.Cel_HMAO, O.fwMark, UA.fwStatus, UP.fwFormEd, UAP.fwResult, T.Docs,
       UCC.fName , UAPF.Only_VB, UP.fwFormEd, Cel_RF_Yes, Cel_HMAO_Yes, RF_Yes, HMAO_Yes,
       VUPD.Spisok_Dis, UA.\"FDADDFLD[1]\", VUPD.Spisok_Marks, GRF.summa
)
order by --NVL(O.fwMark,0) desc, NVL(T.Docs,0) desc, UA.fsFio
         case when fwFormEd = 1                                    then 0
              when Status = 'Зачислен'     and Lgota        = 'Да' then 1
              when Status = 'Зачислен'     and Cel_RF_Yes   =  1   then 2
              when Status = 'Зачислен'                             then 3
              when Status = 'Рекомендован' and Lgota        = 'Да' then 4
              when Status = 'Рекомендован' and Cel_RF_Yes   =  1   then 5 
              when Status = 'Рекомендован' and RF_Yes       =  1   then 6
              when Status = 'Рекомендован' and Cel_HMAO_Yes =  1   then 7
              when Status = 'Рекомендован'                         then 8
              when Status = 'Абитуриент' or Status = 'Оформляемый' then 9 else 9 end,
         case when (Status = 'Зачислен' or Status = 'Рекомендован') and (Lgota = 'Да' or Cel_RF_Yes = 1) then fsfio else to_char(decode(fwMark,0,1,fwMark)-1000) end, fsFio");


	$query->execute(array('fNrec_Plan' => $Nrec_speciality));


	while ($row = $query->fetch()) {
		echo($row['FSFIO'])."<br>";	

	}
?>