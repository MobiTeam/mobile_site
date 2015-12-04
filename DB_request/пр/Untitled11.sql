------------------Còðóêòóðûíå ïîäðàçäåëåíèÿ
Create or replace view V_FHD_PODR
as
select 
       D.fNrec podr_fnrec, 
       D."Èíñòèòóò" podr


  from         
                      (
                       select VSS.Podr_gl_Nrec fNrec, 
                              VSS."Èíñòèòóò"

                         from MV_SP_StaffStruct VSS
                       group by VSS.Podr_gl_Nrec, VSS."Èíñòèòóò"                        
                       order by VSS."Èíñòèòóò"
                       ) D

      LEFT OUTER JOIN V_SP_Val_Podr SVD on SVD.fNrec_Podr = D.fNrec

order by D."Èíñòèòóò"

---------------------------------------------
create table FHD_PODR
as
Select * from V_FHD_PODR

--------------------------------------------------vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv---------


Create TABLE FHD_DIRECTORY
(
NREC NUMBER primary key,
NAME_DIRECTORY varchar2(4000),
TYPE_DIRECTORY varchar2(50)
)
/
drop sequence AUTO_FHD_DIRECTORY

----
/
Create sequence AUTO_FHD_DIRECTORY
/
CREATE trigger TR_FHD_DIRECTORY
  before insert on FHD_DIRECTORY
  for each row
begin
  select AUTO_FHD_DIRECTORY.nextval into :NEW.NREC from dual;
end;

----------------------------------------------------------------------------------------------------------
CREATE TABLE FHD_PLAN
(
NREC NUMBER primary key,
NREC_PODR varchar2(16),
NREC_DIRECTORY NUMBER,
DATE_OPERATION DATE,
TYPE_DIRECTORY varchar2(512)
)
/
drop sequence AUTO_FHD_PLAN
/
Create sequence AUTO_FHD_PLAN
/
CREATE or replace trigger TR_FHD_PLAN
  before insert on FHD_PLAN
  for each row
begin
  select AUTO_FHD_PLAN.nextval into :NEW.NREC from dual;
end;



-------------------------------vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv-----------------------

merge into FHD_PLAN using dual on (NREC_PODR = '80010000000294A0' and NREC_DIRECTORY='2' and YEAR=TO_CHAR(sysdate,'YYYY'))
                when NOT matched then
                    INSERT (
                        NREC_PODR,
                        NREC_DIRECTORY,
                        M_04,
                        YEAR)
                            values (
                            '80010000000294A0',
                            '2',
                            '534543',
                            TO_CHAR(sysdate,'YYYY'))
                when matched then
                    UPDATE SET
                        M_04='65464577764'

----------------------------------------------------------------

Select  fp.podr_fnrec,fp.podr name_podr,f.TYPE_DIRECTORY,SUM(f.SUMMA)
    from FHD_PLAN f
    right outer join FHD_PODR fp on fp.podr_fnrec=f.nrec_podr
    GROUP BY f.NREC_PODR,f.TYPE_DIRECTORY,fp.podr,fp.podr_fnrec
    ORDER BY fp.podr, f.type_directory



-----------------------------------------------------
create or replace view V_FHD_RESULT
as

Select t.PODR_FNREC,
       decode(GROUPING(t.name_podr),1,'ÈÒÎÃÎ',t.name_podr) name_podr,
       SUM(t.INCOME) income ,SUM(t.OUTCOME) outcome
  from (Select  fp.podr_fnrec,fp.podr name_podr,
                DECODE(f.TYPE_DIRECTORY,'1',f.summa,0) income,
                DECODE(f.TYPE_DIRECTORY,'2',f.summa,0) outcome            
          from FHD_PODR fp left outer join FHD_PLAN f on f.nrec_podr=fp.podr_fnrec
        ) t  
GROUP BY rollup((t.PODR_FNREC,t.name_podr))
ORDER BY t.name_podr

----------------------------------------------------------------------------------

create or replace view V_FHD_RESULT
as
Select t.PODR_FNREC,t.name_podr,
        SUM(t.INCOME) income ,SUM(t.OUTCOME) outcome
  from (Select  fp.podr_fnrec,fp.podr name_podr,
                DECODE(f.TYPE_DIRECTORY,'1',f.summa,0) income,
                DECODE(f.TYPE_DIRECTORY,'2',f.summa,0) outcome            
          from FHD_PODR fp left outer join FHD_PLAN f on f.nrec_podr=fp.podr_fnrec
        ) t  
GROUP BY t.PODR_FNREC,t.name_podr
ORDER BY t.name_podr

------------------------------------------------------------------------------------

Select * from fhd_plan f
where
    f.DATE_OPERATION=TO_DATE('11.2015','mm.yyyy')
------------------------------------------------------------------------------------

Select TO_DATE('01.2015','MM.YYYY') from dual

-----------------------------------------

CREATE TABLE FHD_ACCESS
(
ID number,
NREC_PERS varchar2(16)
)


Create sequence AUTO_FHD_ACCESS
/
CREATE or replace trigger TR_FHD_ACCESS
  before insert on FHD_ACCESS
  for each row
begin
  select AUTO_FHD_ACCESS.nextval into :NEW.ID from dual;
end;
----------------------------------------------------------------
Select * from mv_select_person
-------------------------------

drop sequence AUTO_FHD_DIRECTORY
/
Create sequence AUTO_FHD_DIRECTORY
/
drop sequence AUTO_FHD_PLAN
/
Create sequence AUTO_FHD_PLAN
/
---------------------------------------------------------------
Select sum(SUMM_DOL) summa,PODR_GL_NREC from v_fzp_podr
group by PODR_GL_NREC
----------------------------------

Insert into FHD_PLAN (NREC_PODR,NREC_DIRECTORY,DATE_OPERATION,TYPE_DIRECTORY,SUMMA)

-------------------------------------------------------------
select PODR_GL_NREC, 1, to_date('01.'||decode(LENGTH(to_char(rn)), 2,rn,'0'||rn)||'.'||extract(year from sysdate), 'DD.MM.YYYY') date_o, '2', sum_dol
from (  select (sum(fz.SUMM_DOL)+SUM(sp.summa)) sum_dol, fz.PODR_GL_NREC,sp.fnrec
          from v_fzp_podr fz
          left outer join v_sp_podr sp on sp.fnrec=fz.podr_gl_nrec 
      group by fz.PODR_GL_NREC,sp.fnrec,sp.fsv_summa)
       cross join (select rownum rn from dual connect by level < 13)


insert into FHD_PLAN (NREC_PODR, NREC_DIRECTORY, DATE_OPERATION, TYPE_DIRECTORY, SUMMA) select PODR_GL_NREC, 1, to_date('01.'||decode(LENGTH(to_char(rn)), 2,rn,'0'||rn)||'.'||extract(year from sysdate), 'DD.MM.YYYY') date_o, '2', sum_dol
from (  select (sum(fz.SUMM_DOL)+SUM(sp.summa)) sum_dol, fz.PODR_GL_NREC,sp.fnrec
          from v_fzp_podr fz
          left outer join v_sp_podr sp on sp.fnrec=fz.podr_gl_nrec 
      group by fz.PODR_GL_NREC,sp.fnrec,sp.fsv_summa)
       cross join (select rownum rn from dual connect by level < 13)




commit

select * from FHD_PLAN

select * from V_SP_PODR


--------------------------------------------------------
select PODR_GL_NREC, 1, to_date('01.'||decode(LENGTH(to_char(rn)), 2,rn,'0'||rn)||'.'||extract(year from sysdate), 'DD.MM.YYYY') date_o, '2', sum_dol
from (  select sum(SUMM_DOL) sum_dol, PODR_GL_NREC
          from v_fzp_podr
      group by PODR_GL_NREC) cross join (select rownum rn from dual connect by level < 13)
      
      
      --------------------------------------------
      
  Select * from mv_person_otpuska where fperson='800100000000014D'
  --------------------------------
Select * from persons p 
    left outer join appointments a on a.fperson=p.fnrec
    where a.fnrec='80000000000002F9'
--------------------------------------------------------------------------
  
  Select * from persons where FNREC='8000000000000356'
  ----------------------------------------------------------
Select * from holiday where fperson='800100000000014D'

------------------------------------------------------
Select * from holiday where fappoint='800100000001C206'
    --------------Äîäåëàòü
 Select fcaddnrec2  from appointments where fnrec='800100000001C206'  
 
 800100000001C206
 800100000001B960
 800100000001B9A3
 800100000001B991
             800100000001F534
 800100000001B98C
            800100000001F532
 800100000001C5DA
      800100000000A51E    800100000001B65A
 800100000001C5DE   
 800100000001DDE3
 800100000001C47C
 800100000001DDE2
 
 
        800100000001F4CA --------????
        80000000000002F9 800100000001F4CA --(app)--óäàëèòü
        800100000001FE99 ------ïåðåâåëè 16ãî
        8000000000000653  8001000000017C53
  

  --------------oooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooo
  
  Select * from Holiday h
        left outer join appointments ap on ap.fnrec=h.fappoint
-----wwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww
  Select p.ffio,ap.fnrec,h.fperson,h.fappoint from Holiday h
        left outer join mv_person_otpuska ap on ap.fnrec=h.fappoint
        left outer join persons p on p.fnrec=ap.fperson

------------vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvÏÅÐÅÍÀÇÍÀ×ÅÍÈÅ APPOINT ïîñëå ïåðåíîñàvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv

UPDATE HOLIDAY x set
    x.fappoint = (  Select an.fnrec from appointments ap 
                    inner join appointments an on an.fperson=ap.fperson and an.flprizn=ap.flprizn and an.fdepartment=ap.fdepartment and an.fdismissdate='0'
                     where ap.fdismissdate<>'0'
                     and ap.fnrec=x.fappoint )
      where     
      x.fappoint in (Select ap.fnrec from appointments ap 
                    inner join appointments an on an.fperson=ap.fperson and an.flprizn=ap.flprizn and an.fdepartment=ap.fdepartment and an.fdismissdate='0'
                     where ap.fdismissdate<>'0'
                     and ap.fnrec=x.fappoint)            
    
  -----------vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvÁÅÇ ÏÎÄÐÀÇÄÅËÅÍÈßvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv   
  
  
  UPDATE HOLIDAY x set
    x.fappoint = (  Select an.fnrec from appointments ap 
                    inner join appointments an on an.fperson=ap.fperson and an.flprizn=ap.flprizn  and an.fdismissdate='0'
                     where ap.fdismissdate<>'0'
                     and ap.fnrec=x.fappoint )
      where     
      x.fappoint in (Select ap.fnrec from appointments ap 
                    inner join appointments an on an.fperson=ap.fperson and an.flprizn=ap.flprizn  and an.fdismissdate='0'
                     where ap.fdismissdate<>'0'
                     and ap.fnrec=x.fappoint)  
  -----------------------------------------------------------------------------------------------------------   
                
  
  Select * from appointments ap 
                    inner join appointments an on an.fperson=ap.fperson and an.flprizn=ap.flprizn and an.fdepartment=ap.fdepartment and an.fdismissdate='0'
                     where ap.fdismissdate<>'0'
  
  
       Select * from mv_person_otpuska 
       where fperson='8000000000000159'
       
    create table HOLIDAY_20151113
    as 
    Select * from HOLIDAY   
      
    Delete from HOLIDAY where NREC in (
  Select NREC from(     
   Select h.*,row_number() over (partition by h.fappoint,h.date_beg order by h.fappoint,h.date_beg,h.nrec desc) rn,
   count(*) over (partition by h.fappoint,h.date_beg) cnt
     from Holiday h
    ) where rn>1)


Select Distinct FAPPOINT from v_holprint_full

Select * from mv_person_otpuska order by FFIO

Select * from HOLIDAY where fperson='8001000000009BDB'
