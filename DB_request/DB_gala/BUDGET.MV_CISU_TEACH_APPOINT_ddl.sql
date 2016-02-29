-- Start of DDL Script for Materialized View BUDGET.MV_CISU_TEACH_APPOINT
-- Generated 26.02.2016 17:29:18 from BUDGET@GALASERV

CREATE MATERIALIZED VIEW mv_cisu_teach_appoint
  PCTFREE     10
  MAXTRANS    255
  TABLESPACE  users
  STORAGE   (
    INITIAL     65536
    NEXT        1048576
    MINEXTENTS  1
    MAXEXTENTS  2147483645
  )
LOGGING
NOPARALLEL
BUILD IMMEDIATE 
REFRESH COMPLETE START WITH TO_DATE('27-02-2016 02:31 PM','DD-MM-YYYY HH12:MI PM') NEXT SYSDATE + 24/24
AS
select RowNum rn, P.fStrTabn tab, P.fFio$up fio, V.path prof, A.fRate, A.fCategory, to_oradate(A.fAppointDate) datereg,P.fSex,to_oradate(P.fBornDate) fBornDate,
       D.fName, NVL(B.fName,'Не указан') fBud, S.fCategory stavka,
       S.fcInf3, A.fcRef3, K.fNaiKat, 
       A.fLprizn, case when P.fcSovm = '8000000000000001'                     then 'Внешнее совместительство'
                       when A.fLprizn = 0                                     then 'Основное место работы'
                       when A.fLprizn = 3 and A.fKindApp = '80010000000286EC' then 'Совмещение должностей'
                       when A.fLprizn = 3                                     then 'Внутреннее совместительство' end prizn,
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
/

-- Grants for Materialized View
GRANT SELECT ON mv_cisu_teach_appoint TO mobile
/

-- End of DDL Script for Materialized View BUDGET.MV_CISU_TEACH_APPOINT

