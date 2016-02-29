-- Start of DDL Script for Materialized View BUDGET.MV_CISU_STUD_APPOINT
-- Generated 26.02.2016 17:29:48 from BUDGET@GALASERV

CREATE MATERIALIZED VIEW mv_cisu_stud_appoint
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
select P.fNrec fPersons, P.fFio, P.fStrTabN fTabNmb, P.fSex, A.fVacation||' курс' fCourse,
       to_oradate(P.fBornDate) fBornDate, to_oradate(P.fAppDate) zach, 
       F.fName fak, C.fName||' ('||C.fCode||')' spec, 
       G.fName grup, decode(K.fCode, 'Целевой', 'Целевой', substr(K.fCode,1,4)) bud  
from Persons P inner join Appointments     A on A.fPerson      = P.fNrec
               inner join U_StudGroup      G on A.fcCat1       = G.fNrec 
               inner join StaffStruct      S on A.fStaffStr    = S.fNrec
               inner join Catalogs         F on S.fPrivPension = F.fNrec -- Факультет
               inner join u_curriculum      cur on s.fcstr    = cur.fNrec
               inner join U_Specialization C on cur.FCSPECIALIZATION = C.fNrec
 
               inner join Catalogs         Q on S.fcInf1       = Q.fNrec -- Квалификация
               inner join SpKau            K on S.fcNewSpr1    = K.fNrec -- Бюджет
          left outer join (select distinct V.fAppoint, 
                                  'с '||to_char(to_oradate(V.fFactYearBeg),'DD.MM.YYYY')||' по '||to_char(to_oradate(V.fFactYearEnd),'DD.MM.YYYY') AO_Otpusk,
                                  'Приказ №'||V.fFoundation||' от '||to_char(to_oradate(V.fDocDate),'DD.MM.YYYY') AO_Prikaz
                             from Vacations V, (select V1.fAppoint, max(V1.fFactYearEnd) fFactYearEnd  
                                                from Vacations V1
                                                where V1.fVacType = '8001000000000011'
                                                  and to_oradate(V1.fFactYearBeg)<= sysdate
                                                group by V1.fAppoint) M
                            where V.fVacType     = '8001000000000011'
                              and M.fAppoint     = V.fAppoint
                              and M.fFactYearEnd = V.fFactYearEnd) AO on AO.fAppoint = A.fNrec
             left outer join (select L.fcPersons, L.fcAddr, A.fsAddress1 Stud_Living, A.fsBlock, A.fsFlat
                             from U_Living L, Addressn A
                            where L.fcAddr    = A.fNrec
                              and A.fObjType  = '11'
                              and L.fcPersons = A.fcPerson) UL on UL.fcPersons = P.fNrec
where P.fIsemployee  = 'Ю'
  and A.fLprizn      = 0
  and (A.fDisMissDate = 0 or trunc(to_oradate(A.fDisMissDate)) >= trunc(sysdate))
  and (A.fAppointDate = 0 or trunc(to_oradate(A.fAppointDate)) <= trunc(sysdate))


/

-- Grants for Materialized View
GRANT SELECT ON mv_cisu_stud_appoint TO mobile
/

-- End of DDL Script for Materialized View BUDGET.MV_CISU_STUD_APPOINT

