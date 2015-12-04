

-------------------------------------------------
create or replace view V_FHD_PLAN_ALL
as
Select  row_number() over(ORDER BY fh.nrec_directory) num,fd.name_directory,fh.nrec_directory,fh.date_operation,fh.type_directory, sum(fh.SUMMA) summa from FHD_PLAN fh
    inner join FHD_DIRECTORY fd on fh.nrec_directory=fd.nrec
group by fh.nrec_directory,fd.name_directory,fh.date_operation,fh.type_directory
order by fh.nrec_directory



Select  row_number() over(ORDER BY fh.nrec_directory) num,fd.name_directory,fh.nrec_directory,fh.date_operation,fh.type_directory, sum(fh.SUMMA) summa from FHD_PLAN fh
    inner join FHD_DIRECTORY fd on fh.nrec_directory=fd.nrec
group by fh.nrec_directory,fd.name_directory,fh.date_operation,fh.type_directory
order by fh.nrec_directory



Select * from v_fhd_plan_all


-------------
Select * from mv_select_person where podr_gl_nrec='8001000000001AC2'

--------------

Select * from mv_rc_discipline
