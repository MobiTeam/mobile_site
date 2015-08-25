--СТУДЕНТЫ

-----------------------------------------------------------------------------
select P.fNrec fPersons, P.fFio, P.fStrTabN fTabNmb, P.fSex, A.fVacation||' курс' fCourse,
       to_oradate(P.fBornDate) fBornDate, to_oradate(P.fAppDate) zach, 
       F.fName fak, C.fName||' ('||C.fCode||')' spec, 
       G.fName grup, decode(K.fCode, 'Целевой', 'Целевой', substr(K.fCode,1,4)) bud,
       AO.AO_Otpusk, AO.AO_Prikaz, UL.Stud_Living, UL.fsBlock, UL.fsFlat      
from Persons P inner join Appointments     A on A.fPerson      = P.fNrec
               inner join U_StudGroup      G on A.fcCat1       = G.fNrec 
               inner join StaffStruct      S on A.fStaffStr    = S.fNrec
               inner join Catalogs         F on S.fPrivPension = F.fNrec -- ?????????
               inner join U_Specialization C on S.fcDop2       = C.fNrec -- ?????????????
               inner join Catalogs         Q on S.fcInf1       = Q.fNrec -- ????????????
               inner join SpKau            K on S.fcNewSpr1    = K.fNrec -- ??????
          left outer join (select distinct V.fAppoint, 
                                  'с '||to_char(to_oradate(V.fFactYearBeg),'DD.MM.YYYY')||' ?? '||to_char(to_oradate(V.fFactYearEnd),'DD.MM.YYYY') AO_Otpusk,
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
 -- and G.fNrec in (select* from THE (select cast(gala_site.in_list(:PODR) as gala_site.rightsTB) from dual) a)
order by  F.fName, C.fName||' ('||C.fCode||')', G.fName, fFio
