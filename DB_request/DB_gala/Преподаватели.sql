--�������������
grant select on mv_cisu_timetable to mobile;

grant select on gala_rasp."Chair" to mobile;
/

grant select on budget.v_cisu_teac_history_app to mobile;
/
grant select on budget.v_cisu_teac_holiday to mobile;


------------------- ������� ������
grant select on Budget.v_cisu_stud_dol to mobile;
/
grant select on Budget.v_cisu_stud_education to mobile;
/
grant select on budget.v_cisu_teac_kott to mobile;
/
grant select on budget.v_cisu_teac_room to mobile;
-----------------------------------------------------
/

grant select on budget.v_cisu_teac_stimulpr to mobile;


----------------------------------------------------------------------------------C����� �������������(�������� ���������� � �������������)
create materialized view mv_cisu_teach_appoint
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

select RowNum rn, P.fStrTabn tab, P.fFio fio, V.path prof, A.fRate, A.fCategory, to_oradate(A.fAppointDate) datereg,P.fSex,to_oradate(P.fBornDate) fBornDate,
       D.fName, NVL(B.fName,'�� ������') fBud, S.fCategory stavka,
       S.fcInf3, A.fcRef3, K.fNaiKat, 
       A.fLprizn, case when P.fcSovm = '8000000000000001'                     then '������� ����������������'
                       when A.fLprizn = 0                                     then '�������� ����� ������'
                       when A.fLprizn = 3 and A.fKindApp = '80010000000286EC' then '���������� ����������'
                       when A.fLprizn = 3                                     then '���������� ����������������' end prizn,
       decode( NVL(T.fTarif, 0), 0, s.fTaxRate, NVL(T.fTarif, 0) ) ftarif
  from Persons P inner join Appointments    A on A.fPerson      = P.fNrec
                 inner join StaffStruct     S on A.fStaffStr    = S.fNrec
                 inner join Catalogs        D on A.fPost        = D.fNrec
                 inner join V$DerevoFilials V on A.fDepartment  = V.fNrec
            left outer join Catalogs        B on A.fcRef3       = B.fNrec
            left outer join KlKatego        K on A.fEmpCategory = K.fNrec
            left outer join TarStav         T on A.fTariff      = T.fNrec
            left outer join Catalogs        H on A.fKindApp     = H.fNrec  
 where (A.fDisMissDate = 0 or trunc(to_oradate(A.fDisMissDate)) >= trunc(sysdate))
   and (A.fAppointDate = 0 or trunc(to_oradate(A.fAppointDate)) <= trunc(sysdate))
   and  A.fLprizn in (0,3)
   --and  P.fFio$up like '��������� �������� ������������' 
order by flprizn
------------------------------------------------------------------------------------------�������� � �� ����� ��������(������� ����������)
create or replace view v_cisu_teac_tel
as
SELECT ffio$UP fio, c1.fName dol, t.korp, t.kab, com.faddr phone, trim(com.femail) email, com.fnrec id, t.fcparent korp_id, t.fnrec aud_id
FROM persons p inner join appointments a on a.fperson = p.fnrec 
               inner join catalogs c1 on a.fpost = c1.fnrec
          left outer join communications com on com.fperson = p.fnrec
         LEFT OUTER join (select fnrec, 
                                  fname, 
                                  fCode, fcparent,
                                  sys_connect_by_path(fname,'\') as path, 
                                  substr(fname, 0, instr(fname,'/')-1) korp, 
                                  substr(fname, instr(fname,'/')+1) kab
                           from catalogs 
                           start with fnrec='800100000000173C' 
                           connect by prior fnrec=fcparent) t on t.fnrec = com.fCOMTYPE
 where (A.fDisMissDate = 0 or trunc(to_oradate(A.fDisMissDate)) >= trunc(sysdate))
   and (A.fAppointDate = 0 or trunc(to_oradate(A.fAppointDate)) <= trunc(sysdate))
   and  A.fLprizn = 0       
   
   and  p.ffio$UP LIKE '��������� �������� ������������' 
   
---------------------------------------------------------------------------���������� �� �������-------------------------
select rownum rn, tab, fio, prof, frate, fcategory, datereg, fname, fbud, stavka, fcinf3, fcref3, fnaikat, decode(flprizn,0,'��������','��������� ����������������') prizn,t.ftarif 
       from tarstav t INNER JOIN
            (select 
                    p.ftabnmb tab, p.ffio$up fio, c.fname prof, a.frate, a.fcategory, to_oradate(a.fappointdate) datereg, c1.fname, decode(c2.fname,NULL,'�� ����������',c2.fname) as fbud, s.fcategory stavka, s.fcinf3, a.fcref3, k.fnaikat, a.flprizn,a.ftariff 
                    from 
                         persons p, appointments a, catalogs c1, catalogs c2, klkatego k, staffstruct s,
                         (select 
                         fname, 
                         fnrec 
                     from catalogs 
              where fmainlink='80000000000001D7' 
                  and (fdatok=0 or sysdate between trunc(to_oradate(fdatn)) 
                  and trunc(to_oradate(fdatok))) 
                  start with fnrec='80000000000001D7' 
                  connect by prior fnrec=fcparent) c 
              where (A.fDisMissDate = 0 or trunc(to_oradate(A.fDisMissDate)) >= trunc(sysdate))
                and (A.fAppointDate = 0 or trunc(to_oradate(A.fAppointDate)) <= trunc(sysdate))
                and a.fperson=p.fnrec 
                and c.fnrec=a.fdepartment 
                and s.fempcategory=k.fnrec(+) 
                and c1.fnrec=a.fpost 
                and a.fcref3=c2.fnrec(+) 
                and a.fstaffstr=s.fnrec
            ) ON    t.fnrec=ftariff
                WHERE flprizn=0 
                --  and prof='������� ����������� ������'
                   ORDER BY fio   
---------------------------------------------------------------��������--�������-���� ����������
select * from Dol_kott 
    where instr(
        upper(replace(replace(FIO,'',''),' ','')),
        upper(replace(replace('��������� ��������','.',''),' ','')),1)>=1

---------------------------------------------------------------��������� �������
select * from Dol_rab 
    where instr(
        upper(replace(replace(FIO,'',''),' ','')),
        upper(replace(replace('��������� ��������','.',''),' ','')),1)>=1

 
 -------------------------------------------------------������� ����������------------------------------------------------------------------
 create or replace view V_CISU_TEAC_HISTORY_APP
 as
select RowNum rn, P.fStrTabn tab, P.fFio fio, V.path prof, A.fRate, A.fCategory, to_oradate(A.fAppointDate) datereg,P.fSex,to_oradate(P.fBornDate) fBornDate,
       D.fName, NVL(B.fName,'�� ������') fBud, S.fCategory stavka,
       S.fcInf3, A.fcRef3, K.fNaiKat, 
       A.fLprizn, case when P.fcSovm = '8000000000000001'                     then '������� ����������������'
                       when A.fLprizn = 0                                     then '�������� ����� ������'
                       when A.fLprizn = 3 and A.fKindApp = '80010000000286EC' then '���������� ����������'
                       when A.fLprizn = 3                                     then '���������� ����������������' end prizn,
       decode( NVL(T.fTarif, 0), 0, s.fTaxRate, NVL(T.fTarif, 0) ) ftarif
  from Persons P inner join Appointments    A on A.fPerson      = P.fNrec
                 inner join StaffStruct     S on A.fStaffStr    = S.fNrec
                 inner join Catalogs        D on A.fPost        = D.fNrec
                 inner join V$DerevoFilials V on A.fDepartment  = V.fNrec
            left outer join Catalogs        B on A.fcRef3       = B.fNrec
            left outer join KlKatego        K on A.fEmpCategory = K.fNrec
            left outer join TarStav         T on A.fTariff      = T.fNrec
            left outer join Catalogs        H on A.fKindApp     = H.fNrec  
 where 
 (A.fAppointDate = 0 or trunc(to_oradate(A.fAppointDate)) <= trunc(sysdate))
   and  A.fLprizn in (0,3)
 order by flprizn
 
 ---������ ��� ��� ������
 Select * from Persons
 where instr(
       upper(replace(replace(FFIO,'.',''),' ','')),
       upper(replace(replace('�������','.',''),' ','')),1)>=1
       and FDISDATE
 -----------------------------------------------------������ ����������------------------------------------------------------------
Create or replace view V_CISU_TEAC_HOLIDAY
as
Select FFIO,VID,FNOTPUS type_otp,FDOCDATE,FFOUNDATION,FFACTYEARBEG,FFACTYEAREND,FDURATION,COUNTDAY,FACTDAYSAVE,DIF_DAY from V_HD_VACATIONS
order by FFIO,FDOCDATE
where instr(
       upper(replace(replace(FFIO,'.',''),' ','')),
       upper(replace(replace('�������','.',''),' ','')),1)>=1

  

--------------------------------------------------��������------------------------------------------------------------------------

create or replace view v_cisu_teac_stimulpr
as
Select FFIO,CFIN_NAME,SUMMA from V_SP_VPRIKAZ_PRINT
where instr(
       upper(replace(replace(FFIO,'.',''),' ','')),
       upper(replace(replace('����������','.',''),' ','')),1)>=1
       

----------------------------------------------------����������� ��������---------------------------------------------------------


--------------------------------------------------------------������ �� ������-------------------------------------------  

Select * from mv_cisu_timetable_all
