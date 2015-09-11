select c.fLongName c_fname,                    --КАФЕДРА
       C.fname Kaf,
           mod(udl.fsemester+1,2)+1 sezon, --Сезон
           ud.fname ud_fname,              --Дисциплина
           b.ffacultativ,                  --Признак факультатива
           b.sg_fname,                     --Группа
           udl.fwcourse,                   --КУРС
           udl.fistudcount,                --Кол-во студентов
           udl.fwcurrgrcount,
       sum(decode(utw.fname,'Лекции', udl.fdload,'Обзорные лекции', udl.fdload,0)) fdload_lk,
       sum(decode(utw.fname,'Практические (семинарские занятия)', udl.fdload,0)) fdload_prk,
       sum(decode(utw.fname,'Лабораторные работы', udl.fdsize,0)) fdsize_lb,
       sum(decode(utw.fname,'Лабораторные работы', udl.fdload,0)) fdload_lb,
       sum(decode(utw.fname,'Зачёты', udl.fdload,0)) fdload_zach,
       sum(decode(utw.fname,'Дифференцированный зачет', udl.fdload,0)) fdload_dzach,
       sum(decode(utw.fname,'Экзамены', udl.fdload,0)) fdload_ekzam,
       sum(decode(utw.fname,'Курсовая работа', udl.fdload,0)) fdload_kr,
       sum(decode(utw.fname,'Курсовой проект', udl.fdload,0)) fdload_kp,
       sum(decode(utw.fname,'Контрольные работы', udl.fdload,0)) fdload_ktr,
       sum(decode(utw.fname,'Расчетно-графическая работа', udl.fdload,0)) fdload_rgr,
       sum(decode(utw.fname,'Контроль самостоятельной работы', udl.fdload,0)) fdload_KSR,
       sum(decode(utw.fname,'Консультации текущие', udl.fdload,0)) fdload_kons_tek,
       sum(decode(utw.fname,'Консультации перед экзаменом', udl.fdload,0)) fdload_kons_ekz,
       sum(decode(utw.fname,'Учебные практики (О)', udl.fdload,'Учебные практики (ЗО)', udl.fdload,0)) fdload_uprk,
       sum(decode(utw.fname,'Практики (О)', udl.fdload,'Практики (ЗО)', udl.fdload, 'Практика (М)', udl.fdload,0)) fdload_pprk,
       sum(decode(utw.fname,'Выполнение ВКР', udl.fdload,0)) fdload_vkr1,
       sum(decode(utw.fname,'Рецензирование ВКР', to_number(udl.fdload),0)) fdload_vkr2,
       sum(decode(utw.fname,'Допуск к ВКР', to_number(udl.fdload),0)) fdload_kons_vkr3,
       sum(decode(utw.fname,'Государстенная аттестация (экзамен)', udl.fdload,0)) fdload_ga1,
       sum(decode(utw.fname,'Государственная аттестация (защита)', udl.fdload,0)) fdload_ga2,
       sum(udl.fdload) itog

from u_disciplineload udl, U_TeachingLoad utl,
     u_discipline ud, u_typework utw, 
     (select distinct fcdiscipline, fcdisciploadid from u_disciploadcurr) udlc,
     catalogs c,

    (select a.fnrec, a.fwformed, a.fvibor ffacultativ,
            max(case when marker='1' then a.sg_fnrec else null end)||
            max(case when marker='2' then ' '||a.sg_fnrec else null end)||
            max(case when marker='3' then ' '||a.sg_fnrec else null end)||
            max(case when marker='4' then ' '||a.sg_fnrec else null end)||
            max(case when marker='5' then ' '||a.sg_fnrec else null end)||
            max(case when marker='6' then ' '||a.sg_fnrec else null end)||
            max(case when marker='7' then ' '||a.sg_fnrec else null end)||
            max(case when marker='8' then ' '||a.sg_fnrec else null end)||
            max(case when marker='9' then ' '||a.sg_fnrec else null end) sg_fnrec,
            max(case when marker='1' then a.fname else null end)||
            max(case when marker='2' then ' '||a.fname else null end)||
            max(case when marker='3' then ' '||a.fname else null end)||
            max(case when marker='4' then ' '||a.fname else null end)||
            max(case when marker='5' then ' '||a.fname else null end)||
            max(case when marker='6' then ' '||a.fname else null end)||
            max(case when marker='7' then ' '||a.fname else null end)||
            max(case when marker='8' then ' '||a.fname else null end)||
            max(case when marker='9' then ' '||a.fname else null end) sg_fname
     from 
      (
       select 
                  decode(ucyd.fabbr,'ФТД','Ф','ПР','П','ГА','Г',' ') fvibor, 
                  udlc.fcdisciploadid fnrec, uc.fwformed, usg.fnrec sg_fnrec,
                  usg.fname, row_number() over (partition by udlc.fcdisciploadid order by usg.fname) marker 
       from u_curriculum uc,
            u_curr_dis ucd,
            U_CyclesDis ucyd,
            U_ComponentDis ucmd,
            u_curr_group ucg,
            u_studgroup usg,
            u_disciploadcurr udlc
       where ucmd.fnrec=ucd.fccomponent and ucg.fccurr=uc.fnrec and ucg.fcstgr=usg.fnrec and uc.fnrec=udlc.fccurr and ucd.fccurr=uc.fnrec and ucyd.fnrec=ucd.fccycle and udlc.fcdiscipline=ucd.fcdis
      ) a
     group by a.fnrec, a.fwformed, a.fvibor
         ) b
--     galreport.v$load_group b
where
          udl.fnrec=b.fnrec
      and udl.fcLoadID=utl.fnrec
      and udlc.fcdisciploadid=udl.fnrec
      and udlc.fcdiscipline=ud.fnrec
      and udl.fctypework=utw.fnrec
      and utl.fcchair=c.fnrec
     -- and utl.fwYearEd=:GOD                 --ГОД РАСЧЕТА НАГРУЗКИ
   --   and mod(udl.fsemester+1,2)+1 like decode(:SEMESTR, 9, '%', :SEMESTR)       --СЕЗОН 1-ОСЕНЬ, 2-ВЕСНА
    --and b.sg_fnrec like '%'||(select* from THE (select cast(gala_site.in_list(:PODR) as gala_site.rightsTB) from dual) a)||'%'
   --   and b.sg_fnrec like '%'||:PODR||'%'

group by utl.fwYearEd, c.fLongName, C.fname,
       b.sg_fname, b.ffacultativ, ud.fname, 
       udl.fwcurrgrcount, udl.fistudcount,
       udl.fwcourse, udl.fsemester, b.fwformed, udl.fwcurrgrcount
order by mod(udl.fsemester+1,2)+1, b.sg_fname, ud.fname

