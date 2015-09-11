
-------------------------------------------сделать грант в мобайл--------------------------------------
grant select on galreport.mv_mobile_prikaz to mobile;


Select * from mv_mobile_prikaz


create materialized view mv_mobile_prikaz
  PCTFREE     10
  MAXTRANS    255
  TABLESPACE  users
  STORAGE   (
    INITIAL     65536
    MINEXTENTS  1
    MAXEXTENTS  2147483645
  )
LOGGING
NOPARALLEL
BUILD IMMEDIATE 
REFRESH COMPLETE START WITH TO_DATE('12-5-2015 5:00 PM','DD-MM-YYYY HH12:MI PM') NEXT SYSDATE + 6/24  
as
select "Вид", "ФИО", "Номер приказа", "Дата приказа", "Распорядительное действие", "Категория", "Статус",
       "Краткое содержание", rnb
  from (
select decode(P.fcSovm, '8000000000000000', decode(A.fLprizn,0,'Осн','Внутр'),'Внеш') "Вид",
       P.fFio "ФИО",

       TD.fDocNmb "Номер приказа",
       to_oradate(TD.fDocDate) "Дата приказа",
       T.fnOper "Распорядительное действие",       
       K.fNaiKat "Категория",
       decode(TD.fwStatus, 0,'НЕ утверждён', 1,'Утверждён', 2,'Отменён', '---') "Статус",
       TD.fDocText||' ['||
       case when T.fCodOper = 1 then 'приём по '||decode(P.fcSovm, '8000000000000000','основному месту работы с ', 'внешнему совместительству с ')||to_oradate(A.fappointDate) 
            when T.fCodOper = 4 then 'приём по '||decode(P.fcSovm, '8000000000000000','внутреннему совместительству с ', 'внешнему совместительству с ')||to_oradate(A.fappointDate)
            when T.fCodOper = 5 then 'перемещение по '||decode(A.fLprizn, 0,'основному назначению', 'внутреннему совместительству')||
                                     case when A.fDepartment <> A2.fDepartment then decode(CD.fSeqNmb, 1, ' В подразделение "', ' ИЗ подразделения "')|| V2.fName ||'"' end ||
                                     case when A.fPost <> A2.fPost then decode(CD.fSeqNmb, 1, ' НА должность "', ' С должности "') ||D2.fName ||'" ('||replace(A2.fRate,',','0.')||'ст.)' end
            when T.fCodOper = 6 then KO.fnOtpus||' по '||decode(A.fLprizn, 0,'основному назначению на ', 'внутреннему совместительству на ')||OT.fDuration||'дн. с '||to_oradate(OT.fFactYearBeg)||' по '||to_oradate(OT.fFactYearEnd)
            when T.fCodOper = 8 then decode(A.fLprizn, 0,'увольнение с ','отмена совместительства с ') || decode(P.fDisDate, 0,to_oradate(P.fDisDatePr), to_oradate(P.fDisDate))
            when T.fCodOper = 9 then CR.fName ||': '||R.fSum||decode(CR.fcParent, '80000000000001F5','%', '80000000000001F4','руб.', '')||
                                     decode(R.fFromDate, 0,'', ' c '||to_char(to_oradate(R.fFromDate),'DD.MM.YYYY'))||
                                     decode(R.fToDate, 0,'', ' по '||to_char(to_oradate(R.fToDate),'DD.MM.YYYY'))
       end||']' "Краткое содержание",
       row_number() over (partition by PD.fNrec, CD.fPerson order by PD.fNrec, CD.fPerson, CD.fSeqNmb) rnb

  from TitleDoc TD inner join PartDoc         PD on PD.fcDoc       = TD.fNrec
                   inner join ContDoc         CD on CD.fcPart      = PD.fNrec
                   inner join TypePr           T on CD.fTypeOper   = T.fCodOper     
                   inner join Appointments     A on CD.fcStr       = A.fNrec
                   inner join Persons          P on A.fPerson      = P.fNrec
                   inner join Catalogs         D on A.fPost        = D.fNrec 
                   inner join KlKatego         K on A.fEmpCategory = K.fNrec
                   inner join V$DerevoFilials  V on A.fDepartment  = V.fNrec
              left outer join ContDoc        CD2 on CD2.fcPart     = CD.fcPart and CD.fSeqNmb <> CD2.fSeqNmb
              left outer join Appointments    A2 on CD2.fcStr      = A2.fNrec 
              left outer join Catalogs        D2 on A2.fPost       = D2.fNrec 
              left outer join V$DerevoFilials V2 on A2.fDepartment = V2.fNrec
              left outer join Vacations       OT on CD.fObjNrec    = OT.fNrec
              left outer join KlOtpusk        KO on OT.fVacType    = KO.fNrec
              left outer join Raise            R on R.fcrDop       = CD.fNrec
              left outer join catalogs        CR on R.fRaiseType   = CR.fNrec
 where to_char(to_oradate(TD.fDocDate),'YYYY') = to_char(sysdate,'YYYY')
 --and CD.fSeqNmb = 1
   and (CD.fSeqNmb = 1 or (CD.fSeqNmb = 2 and A.fDepartment <> A2.fDepartment))
   and P.fIsemployee in ('С','У')
--   and (TD.fDocNmb like '7/%' or TD.fDocNmb like '8/%')
   and T.fCodOper < 10000
  -- and A.fDepartment in (select* from THE (select cast(gala_site.in_list(:PODR) as gala_site.rightsTB) from dual) a)
) 
where rnb = 1
UNION ALL
select decode(P.fcSovm, '8000000000000000', decode(A.fLprizn,0,'Осн','Внутр'),'Внеш') "Вид",
       P.fFio "ФИО",

       PR.fNoDoc "Номер приказа",
       to_oradate(PR.fdDoc) "Дата приказа",
       'Приказ на командировку' "Распорядительное действие",       
       K.fNaikat "Категория",
       decode(PR.fStatus, 0,'НЕ утверждён', 1,'Утверждён', 3,'Отменён', '---') "Статус",
       'Командировка ' || short_fio(P.fFio) ||' ('||PR.fMesto||' на '||PR.fKolDay||'дн.'||
       decode(PR.fdStart, 0,'', ' с ' ||to_char(to_oradate(PR.fdStart),'DD.MM.YYYY'))||
       decode(PR.fdEnd,   0,'', ' по '||to_char(to_oradate(PR.fdEnd),'DD.MM.YYYY')) "Краткое содержание",
       1 rnb
       
from Prikaz PR inner join SpPrikaz        S on S.fcPrikaz      = PR.fNrec
               inner join Lschet          L on L.fNrec         = S.fcLsch
               inner join Appointments    A on A.fcAddNrec2    = L.fNrec
               inner join Persons         P on S.fcPersons     = P.fNrec               
               inner join Catalogs        D on A.fPost         = D.fNrec
               inner join KlKatego        K on A.fEmpCategory  = K.fNrec
               inner join V$Derevofilials V on A.fDepartment   = V.fNrec
          left outer join KatState        R on PR.fcState      = R.fNrec
          left outer join KatCity         G on PR.fcCity       = G.fNrec
where  PR.fStatus = 1
  and  to_char(to_oradate(PR.fdDoc),'YYYY') = to_char(sysdate,'YYYY')
  and (A.fAppointDate = 0 or trunc(to_oradate(A.fAppointDate)) <= to_oradate(PR.fdStart))
  and (A.fDisMissDate = 0 or trunc(to_oradate(A.fDisMissDate)) >= to_oradate(PR.fdStart))
 -- and  V.fNrec in (select* from THE (select cast(gala_site.in_list(:PODR) as gala_site.rightsTB) from dual) a)
order by  "Дата приказа", "Номер приказа"


