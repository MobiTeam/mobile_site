--Расписание групп

Select gl.grup,gl.course,gl.pair,gl.vid,gl.aud,gl.korp,gl.discipline,gl.teacher,gl.datezan,gl.subgrup,tm.oid  from gala_site.timetable gl
INNER JOIN gala_rasp."Group" tm on tm."Name"=gl.grup 
Where  (trunc(sysdate,'D')-10)<=gl.datezan 
--and gl.grup='1521б'
----------------------------------------------
 grant select on mv_cisu_timetable_all to mobile;
------------------------------------------------------------------Расписание все
create materialized view mv_cisu_timetable_all
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
REFRESH COMPLETE START WITH SYSDATE NEXT SYSDATE + 1/24  


as
Select tm.oid teac_OID , tm.fio teac_FIO,ch."Name" teac_caf,gl.discipline,gl.grup gr_num,gl.subgrup,gl.course gr_course,fc."Name" gr_ins,gl.datezan,to_char(gl.datezan,'Day') dayweek,gl.pair,gl.vid,gl.aud,gl.korp from gala_rasp."Lecturer" tm
INNER JOIN gala_site.timetable gl on gl.teacher=tm.fio
INNER JOIN gala_rasp."Faculty" fc on fc.OID=gl.faculty
INNER JOIN gala_rasp."Chair" ch on ch.OID=tm."Chair"
--INNER JOIN gala_rasp."Group" gr on gr."Name"=gl.grup
Where  (trunc(sysdate,'D')-14)<=gl.datezan 
and fc.OID <>'21'
order by gl.datezan



/
Drop materialized view mv_cisu_timetable
----------------------------------------------------------------------------------------------------------------------------

Select * from gala_rasp."Faculty"

Select * from gala_rasp."Chair"

Select * from gala_rasp."Lecturer"

Select * from gala_rasp."Group"

Select * from gala_site.timetable gl
Where  (trunc(sysdate,'D')-14)<=gl.datezan 

Select sysdate from dual
