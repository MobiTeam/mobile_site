Select DISTINCT to_char(gr."Name") number_group from gala_rasp."Group" gr
MINUS
select   Distinct USG.Fname number_group
 from U_List UL inner join U_Marks      UM on UM.fcList = UL.fNrec
                inner join U_StudGroup USG on UL.fcStGr = USG.fNrec
                inner join U_Discipline      UD   on UL.fcDis       = UD.fNrec
                inner join Catalogs      C on UM.fcMark = C.fNrec
                inner join U_TypeWork        UTW  on UL.fcTypeWork = UTW.fNrec
where 
to_oradate(UM.FATL_LASTDATE)>to_date('01.09.2012','DD.MM.YYYY')
and USG.Fname in (Select "Name" from gala_rasp."Group")
  and UTW.Fname<>'Зачёты'

Select * from mv_rc_discipline

Select * from MV_PERSON_OTPUSKA where PODR_GL_NREC = '8001000000029331'

Select * from V_HOLPRINT

Select  p.ffio,h.date_beg,to_date(h.date_end)-TO_DATE(h.date_beg)+1 as kol, h.priznak as ligot,h.summa,h.amount_dep as child,p.vid,p.fdepartment,CO,OWNER,p.podr_gl_nrec,p.fcpodr,h.amount_day
from holiday h
inner join mv_person_otpuska p on h.fperson=p.fperson and h.co=p.co_fnrec

select * from MV_PERSON_OTPUSKA

Select * from MV_Select_person where FPERSON='select FNREC,FFIO,FPERSON,PODR_GL_NREC,FDEPARTMENT,CO_FNREC,FBPICK,FCPODR,LV from mv_select_person'

Select * from SP_ACCESS



select FNREC,FFIO,FPERSON,PODR_GL_NREC,FDEPARTMENT,CO_FNREC,FBPICK,FCPODR,LV from mv_select_person
    where instr(
        upper(replace(replace(FFIO,'.',''),' ','')),
        upper(replace(replace('БОНДАРЕНКО Ала Николаевна','.',''),' ','')),
        1
        )=1
        AND FLPrizn=0
        
        Select * from MV_SP_RUKOVODITELI
        
        Select * from holiday


Select * from v_sp_rukovoditeli

Select * from mv_select_person where PODR_GL_NREC in '8001000000001AC7'


Select * from mv_person_otpuska

select * from MV_SELECT_PERSON where FPERSON in ('80010000000002C4','8001000000009D2C','8000000000000058','800100000000BDA0','800100000000B054','8001000000001D8E','800100000000A615','8001000000009C73','800100000000BDAE','800100000000B67A','800100000000A4D0','800100000000B223','800100000000B52F','800100000000B5B6') and PODR_GL_NREC in ('8001000000001AC7')
UNION
select * from MV_SELECT_PERSON where FPERSON in ('8000000000000058')
ORDER by 6


create or replace view V_HOLPRINT

Select  p.ffio,h.date_beg,to_date(h.date_end)-TO_DATE(h.date_beg)+1 as kol, h.priznak as ligot,h.summa,h.amount_dep as child,p.vid,p.fdepartment,CO,OWNER,p.podr_gl_nrec,p.fcpodr,h.amount_day
from holiday h
inner join mv_select_person p on h.fperson=p.fperson and h.CO=p.co_fnrec

Select * from holiday

Select * from MV_Select_person

select * from MV_SELECT_PERSON where FNREC='800100000001E755'

-------------------------------
select * from MV_SELECT_PERSON where FNREC in (".$fpers.") 
                    and FCPODR in (".$podrazdelenie.") 
                    UNION
                    select * from MV_SELECT_PERSON where FPERSON in (".$nc.")
                    
                    create or replace view V_HOLPRINT
                    as
                    Select P.fFio, decode(P.fcSovm, '8000000000000000', decode(A.fLprizn, 0,'Осн', 'Внутр'), 'Внеш') Vid, V.path fDepartment, V.Podr_Gl_Nrec, V.fNrec fcPodr,
       H.Date_Beg, to_date(H.Date_End) - to_date(H.Date_Beg) + 1 kol, 
       H.Priznak ligot, H.Summa, H.Amount_Dep child, 
       H.Amount_Day, H.CO, H.Owner,H.fappoint
from HoliDay H left outer join Appointments    A on H.fAppoint    = A.fNrec 
               left outer join Persons         P on A.fPerson     = P.fNrec
               left outer join V$DerevoFilials V on A.fDepartment = V.fNrec
               
               
               Select * from v_sp_department
               
            Select * from v_hd_rukovoditeli

            Select * from hd_delegation
            
            Select * from v_hd_department
            
            
            create or replace view v_hd_info as
            Select dep.*,NVL(ruk.fname,'') ruk_post,NVL(ruk.FFIO,'') ruk_fio from v_hd_department dep
            left outer join v_hd_rukovoditeli ruk on ruk.podr = dep.fnrec
            where dep.LV <>'1'
            
            
            
            Select (sysdate+28) datea from dual         
           
           Select * from MV_PERSON_OTPUSKA
           
           
           Create table HD_CLOSED
           as
           Select distinct a.PODR_GL_NREC, a.PODR, a.LV,po.fdepartment from v_hd_rukovoditeli a
            Inner join mv_person_otpuska po on po.fcpodr=a.PODR and a.podr_gl_nrec=po.podr_gl_nrec
            
            Select * from HD_CLOSED
           
           
            Select * from v_person_otpuska
   
