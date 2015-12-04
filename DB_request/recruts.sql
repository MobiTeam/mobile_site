
---------------------------------------------------------Институт+кафедра+группа-------------------------------------
create materialized view MV_RC_FACULTY
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
REFRESH COMPLETE START WITH TO_DATE('19-9-2015 5:00 PM','DD-MM-YYYY HH12:MI PM') NEXT SYSDATE + 6/24    
as
Select FAC."Name" faculty,fac."Abbr" faculty_abbr,CHA."Name" chair,CHA."Abbr" chair_abbr,GR."Name" group_name,S."Name" specialization,SP."Name" Specification,GR."Course" Course,GR."Amount" amount_stud  
from 
    gala_rasp."Faculty" FAC
    INNER JOIN gala_rasp."Chair" CHA on Cha."Faculty" = FAC.OID
    INNER JOIN gala_rasp."Group" GR on Gr."Chair"=Cha.oid
    INNER JOIN gala_rasp."Speciality" SP on Gr."Speciality" = SP.OID
    left outer JOIN gala_rasp."Specialization" S on Gr."Specialization"= S.OID
        where 
        FAC."TempFlag"<>'0'
        and CHA."TempFlag"<>'0'
        and GR."TempFlag"<>'0'

---------------------------------------------------------------------------------------------------------------------
Select * from gala_rasp."Chair"

Select * from gala_rasp."Faculty"

Select * from gala_rasp."Group"

Select * from gala_rasp."Speciality"

Select * from gala_rasp."Specialization"

Grant select on gala_rasp."Speciality" to budget;
/
Grant select on gala_rasp."Specialization" to budget;
----------------------------------------Дисциплины котоыре сдавались-----------------------------------
create materialized view MV_RC_DISCIPLINE
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
REFRESH COMPLETE START WITH TO_DATE('19-9-2015 5:00 PM','DD-MM-YYYY HH12:MI PM') NEXT SYSDATE + 6/24  
as
select   Distinct UD.fName Discipline,Ct.fname faculty,Ct2.fname chair,Ct3.fname,USG.Fname number_group
 from U_List UL inner join U_Marks      UM on UM.fcList = UL.fNrec
                inner join U_StudGroup USG on UL.fcStGr = USG.fNrec
                inner join U_Discipline      UD   on UL.fcDis       = UD.fNrec
                inner join Catalogs      C on UM.fcMark = C.fNrec
                inner join Catalogs      Ct on Ct.FNREC=USG.FCFACULTY
                Inner join Catalogs     Ct2 on  Ct2.FNREC=USG.FCCHAIR
                Inner join Catalogs     ct3 on   ct3.fnrec=USG.FCSPEC
                inner join U_TypeWork        UTW  on UL.fcTypeWork = UTW.fNrec
where 
to_oradate(UM.FATL_LASTDATE)>to_date('01.09.2012','DD.MM.YYYY')
and USG.Fname in (Select "Name" from gala_rasp."Group")
  and UTW.Fname<>'Зачёты'

----------------------------------------------Оценки по группе-----------------------------------------------------------------------

select distinct UM.fsFio FIO ,USG.Fname number_group,UD.fName Dis,C.fName Zach,UL.fwSemestr Semestr,UTW.Fname typework,
          UM.fwMark, K.fsDepCode
 from U_List UL inner join U_Marks      UM on UM.fcList = UL.fNrec
                inner join U_StudGroup USG on UL.fcStGr = USG.fNrec
                inner join U_Discipline      UD   on UL.fcDis       = UD.fNrec
                inner join Catalogs      C on UM.fcMark = C.fNrec

                inner join U_TypeWork        UTW  on UL.fcTypeWork = UTW.fNrec
                inner join (select UPPER(ffio) ffio,FSDEPCODE 
                            from U_student 
                            where (fdisdate = 0 or trunc(to_oradate(fdisdate)) >= trunc(sysdate,'MM'))
                              and (fappdate = 0 or trunc(to_oradate(fappdate)) <= trunc(sysdate,'MM'))
                           ) K on upper(UM.fsFio) = K.ffio
                              and USG.fname = K.fsDepCode                        
where USG.Fname  like '%1521%'
   and UTW.Fname <> 'Зачёты'
order by UL.fwSemestr ASC


   
--------------------------------------------Выборка по предметам------------------------------------------
create materialized view MV_RC_marks_all
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
REFRESH COMPLETE START WITH TO_DATE('19-9-2015 5:00 PM','DD-MM-YYYY HH12:MI PM') NEXT SYSDATE + 6/24  
as

select distinct UM.fsFio FIO ,USG.Fname number_group,Q.fcode flevel, 
          UD.fName Dis,UTW.Fname typework,UCC.FWFORMED,
          LISTAGG (UL.fwSemestr, ',') WITHIN GROUP (Order by UL.fwSemestr) fwSemestr,
          round(sum(UM.fwMark)/count(UD.fName),2) AVG_Mark, K.fsDepCode        
 from U_List UL inner join U_Marks          UM    on UM.fcList = UL.fNrec
                inner join U_StudGroup      USG   on UL.fcStGr = USG.fNrec
                inner join U_Discipline     UD    on UL.fcDis  = UD.fNrec
                inner join Catalogs         C     on UM.fcMark = C.fNrec
                inner join U_TypeWork       UTW   on UL.fcTypeWork = UTW.fNrec
                inner join Persons          P     on UM.fcpersons = P.fNrec
                inner join Appointments     A     on A.fPerson = P.fNrec 
                inner join StaffStruct      S     on A.fStaffStr = S.fNrec
                inner join U_CurriCulum     UCC   on S.fcStr = UCC.fNrec
                inner join Catalogs         Q     on S.fcInf1 = Q.fNrec
                inner join (select UPPER(ffio) ffio,FSDEPCODE 
                            from U_student 
                            where (fdisdate = 0 or trunc(to_oradate(fdisdate)) >= trunc(sysdate,'MM'))
                              and (fappdate = 0 or trunc(to_oradate(fappdate)) <= trunc(sysdate,'MM'))
                           ) K on upper(UM.fsFio) = K.ffio
                              and USG.fname = K.fsDepCode                        
where (A.fDisMissDate = 0 or trunc(to_oradate(A.fDisMissDate)) >= trunc(sysdate))
  and (A.fAppointDate = 0 or trunc(to_oradate(A.fAppointDate)) <= trunc(sysdate))
  and (UCC.fYearEd + ucc.fTerm) >= to_char(sysdate,'YYYY')
  and USG.fyearent>='2012'
--and USG.Fname  like '%1521%'  
  and UTW.Fname <> 'Зачёты' 
  and UCC.FWFORMED<>1
  and Q.fcode <>91
   group by UM.fsFio ,USG.Fname,UD.fName,UTW.Fname, K.fsDepCode, Q.fcode,UCC.FWFORMED

  ----------------------------------------------------------------------

select distinct UM.fsFio FIO ,USG.Fname number_group,Q.fcode flevel, 
          UD.fName Dis,UTW.Fname typework,UCC.FWFORMED,
          LISTAGG (UL.fwSemestr, ',') WITHIN GROUP (Order by UL.fwSemestr) fwSemestr,
          round(sum(UM.fwMark)/count(UD.fName),2) AVG_Mark, K.fsDepCode        
 from U_List UL inner join U_Marks          UM    on UM.fcList = UL.fNrec
                inner join U_StudGroup      USG   on UL.fcStGr = USG.fNrec
                inner join U_Discipline     UD    on UL.fcDis  = UD.fNrec
                inner join Catalogs         C     on UM.fcMark = C.fNrec
                inner join U_TypeWork       UTW   on UL.fcTypeWork = UTW.fNrec
                inner join Persons          P     on UM.fcpersons = P.fNrec
                inner join Appointments     A     on A.fPerson = P.fNrec 
                inner join StaffStruct      S     on A.fStaffStr = S.fNrec
                inner join U_CurriCulum     UCC   on S.fcStr = UCC.fNrec
                inner join Catalogs         Q     on S.fcInf1 = Q.fNrec
                
                inner join (select UPPER(ffio) ffio,FSDEPCODE 
                            from U_student 
                            where (fdisdate = 0 or trunc(to_oradate(fdisdate)) >= trunc(sysdate,'MM'))
                              and (fappdate = 0 or trunc(to_oradate(fappdate)) <= trunc(sysdate,'MM'))
                           ) K on upper(UM.fsFio) = K.ffio
                              and USG.fname = K.fsDepCode                        
where (A.fDisMissDate = 0 or trunc(to_oradate(A.fDisMissDate)) >= trunc(sysdate))
  and (A.fAppointDate = 0 or trunc(to_oradate(A.fAppointDate)) <= trunc(sysdate))
  and (UCC.fYearEd + ucc.fTerm) >= to_char(sysdate,'YYYY')
  and USG.fyearent>='2012'
--and USG.Fname  like '%1521%'  
  and UTW.Fname <> 'Зачёты' 
  and UCC.FWFORMED<>1
  and Q.fcode <>91
   group by UM.fsFio ,USG.Fname,UD.fName,UTW.Fname, K.fsDepCode, Q.fcode,UCC.FWFORMED

Select * from mv_rc_discipline

-------------------------------------------------------------------------
select distinct NUMBER_GROUP
from(
select NUMBER_GROUP, DISCIPLINE ,
       sum(decode(DISCIPLINE, 'Дискретная математика', 1, 'Базы данных', 1, 0)) over (partition by NUMBER_GROUP) cnt
from MV_RC_DISCIPLINE )
where cnt=2




select FIO,NUMBER_GROUP,FLEVEL,DIS,TYPEWORK,FWSEMESTR,AVG_MARK from MV_RC_MARKS_ALL 
        where NUMBER_GROUP in (select distinct NUMBER_GROUP
                                from(select NUMBER_GROUP, DISCIPLINE ,
                                        sum(decode(DISCIPLINE, 'Дискретная математика', 1, 'Базы данных', 1, 0))
                                        over (partition by NUMBER_GROUP) cnt
                                     from MV_RC_DISCIPLINE)
                                where cnt=2) 
        and DIS in ('Дискретная математика', 'Базы данных')
        group by FIO,NUMBER_GROUP,FLEVEL,DIS,TYPEWORK,FWSEMESTR,AVG_MARK
        order by FIO,DIS
        
        
        -------------------------------------------------------------------------
        
Create table RC_comment(
    dol VARCHAR2(1024),
    skill VARCHAR2(1024)
        )
        
        Select * from RC_comment

