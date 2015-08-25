--СТУДЕНТЫ

-----------------------------------------------------------------------------Назначение студента
--переделать академ AO_OTPUSK
create materialized view mv_cisu_stud_appoint
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
select P.fNrec fPersons, P.fFio, P.fStrTabN fTabNmb, P.fSex, A.fVacation||' курс' fCourse,
       to_oradate(P.fBornDate) fBornDate, to_oradate(P.fAppDate) zach, 
       F.fName fak, C.fName||' ('||C.fCode||')' spec, 
       G.fName grup, decode(K.fCode, 'Целевой', 'Целевой', substr(K.fCode,1,4)) bud,
       AO.AO_Otpusk, AO.AO_Prikaz      
from Persons P inner join Appointments     A on A.fPerson      = P.fNrec
               inner join U_StudGroup      G on A.fcCat1       = G.fNrec 
               inner join StaffStruct      S on A.fStaffStr    = S.fNrec
               inner join Catalogs         F on S.fPrivPension = F.fNrec -- Факультет
               inner join U_Specialization C on S.fcDop2       = C.fNrec -- Специализация
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
  --and G.fNrec in (select* from THE (select cast(gala_site.in_list(:PODR) as gala_site.rightsTB) from dual) a)
order by  F.fName, C.fName||' ('||C.fCode||')', G.fName, fFio

------------------------------------------------------------------------Общежития
select * from Dol_stud
where lower(substr(fio,1,length(replace('Якимчук Александр Васильевич','.',''))))=lower(replace('Якимчук Александр Васильевич','.',''))
 
-----------------------------------------------------------------------Обучение 
select * from Dol 
where lower(substr(fio,1,length(replace(:ffio,'.',''))))=lower(replace(:ffio,'.',''))

-----------------------------------------------------------------Список студентов по группе

select ffio,fsdepcode from U_student 
where FSDEPCODE='1521б'
and to_oradate(fappdate)<=sysdate 
and (to_oradate(fdisdate)>sysdate or fdisdate=0) order by ffio

--------------------------------------------------------------СТИПЕНДИИ

select  FFIO,fnVidOpl, to_char(M_1), to_char(M_2),to_char(M_3),to_char(M_4),to_char(M_5),to_char(M_6),to_char(M_7),to_char(M_8),to_char(M_9), to_char(M_10), to_char(M_11), to_char(M_12), to_char(M_13)
 from(
select US.fFio, US.fsFaculty, US.fsPost, US.fsDepcode, US.fsFinsourceName, fVidOpl, decode(GROUPING(fnVidOpl), 1, 'ИТОГО', fnVidOpl) fnVidOpl,
       sum(decode(fMes,  1, fSumma, 0)) M_1,  sum(decode(fMes,  2, fSumma, 0)) M_2,  sum(decode(fMes,  3, fSumma, 0)) M_3,
       sum(decode(fMes,  4, fSumma, 0)) M_4,  sum(decode(fMes,  5, fSumma, 0)) M_5,  sum(decode(fMes,  6, fSumma, 0)) M_6,
       sum(decode(fMes,  7, fSumma, 0)) M_7,  sum(decode(fMes,  8, fSumma, 0)) M_8,  sum(decode(fMes,  9, fSumma, 0)) M_9,
       sum(decode(fMes, 10, fSumma, 0)) M_10, sum(decode(fMes, 11, fSumma, 0)) M_11, sum(decode(fMes, 12, fSumma, 0)) M_12,
       sum(fSumma) M_13
  from (
        select SVO.fVidOpl, K.fnVidOpl,  SVO.fMes, replace(SVO.fSumma,'.',',') fSumma, SVO.ftPerson
          from SumVidOp SVO inner join Persons      P on SVO.ftPerson = P.fNrec
                            inner join U_Student    U on U.fcPersons  = P.fNrec
                            inner join KlVidOpl     K on SVO.fVidOpl  = K.fVidOplP
         where SVO.fSumma <> 0
           and SVO.fYearK = '2015'
          and lower(substr(P.ffio,1,length(replace('Якимчук Александр Васильевич','.',''))))=lower(replace('Якимчук Александр Васильевич','.',''))

        ) S, U_Student US
 where S.ftPerson = US.fcPersons
group by rollup((US.fFio, US.fsFaculty, US.fsPost, US.fsDepcode, US.fsFinsourceName, fVidOpl, fnVidOpl)))



-----------------------------------------------------------------------------------------------Оценки-------------------------

select D.fFio, D.Dis, D.TypeWork,D.FSEMESTER semestr,D.FNAME,
       decode(D.TypeCode, '005',O.Zach, O.fwMark) fwMark
from (
select USG.fName, UD.fName Dis, UTW.fName TypeWork, UTW.fCode TypeCode, US.fFio,
       trunc(to_oradate(UCS.fdBeg)) fdBeg, trunc(to_oradate(UCS.fdEnd)) fdEnd, UCS.fSemester,
       UCD.fcDis, UCDC.fcTypeWork, UCG.fcStGr, US.fcPersons
from U_StudGroup USG inner join U_Curr_Group      UCG  on UCG.fcStGr      = USG.fNrec
                     inner join U_CurriCulum      UCC  on UCG.fcCurr      = UCC.fNrec
                     inner join U_Curr_Dis        UCD  on UCD.fcCurr      = UCG.fcCurr
                     inner join U_Curr_DisContent UCDC on UCDC.fcCurr_Dis = UCD.fNrec                     
                     inner join U_Discipline      UD   on UCD.fcDis       = UD.fNrec
                     inner join U_Curr_Semester   UCS  on UCDC.fcSemester = UCS.fNrec
                     inner join U_TypeWork        UTW  on UCDC.fcTypeWork = UTW.fNrec
                     inner join (select distinct UM.fcPersons, UL.fcCur, P.fFio
                                   from U_List UL, U_Marks UM, U_StudGroup USG, Persons P
                                  where UM.fcList    = UL.fNrec
                                    and UL.fcStGr    = USG.fNrec
                                    and UM.fcPersons = P.fNrec) US on US.fcCur = UCC.fNrec                      
where utw.fwtype in (4,5,14,8)
  and UCC.fwType = 2
 -- and to_char(UCC.fYearEd) = to_char(:GOD) ---ГОД
 -- and UCS.fwSeason        = :SEMESTR --СЕМЕСТР
  --and trunc(to_oradate(UCS.fdBeg)) <= sysdate
 --and trunc(to_oradate(UCS.fdEnd)) >= trunc('01.09.2012') дата
  --and USG.Fname  = '1521б'
--order by UCS.fSemester, UCDC.fCode desc, UD.fName
) D
left outer join 
--inner join
(select UL.fcDis, UL.fcStGr, UL.fwSemestr, UL.fcTypeWork,
        UM.fcPersons, UM.fsFio, UM.fwMark, C.fName Zach
 from U_List UL inner join U_Marks      UM on UM.fcList = UL.fNrec
                inner join U_StudGroup USG on UL.fcStGr = USG.fNrec
           left outer join Catalogs      C on UM.fcMark = C.fNrec
 ) O  on D.fcDis      = O.fcDis
     and D.fcStGr     = O.fcStGr
     and D.fcTypeWork = O.fcTypeWork
     and D.fcPersons  = O.fcPersons 
     and D.fSemester  = O.fwSemestr
    -- where O.fwMark is not null
order by 1, 3, 2

--------------------------------------------------------------------------------------------------------------------------------
select distinct 
       '???????? ??????????????? ???????????<>'||
       '???????? ?  ??????????? ??????????????? ??????&<>'||
       '?? '||UCS.fwSeason|| ' ??????? '||
       to_char(to_oradate(UCK.fdBeg),'YYYY') || '-' || 
       to_char(to_oradate(UCK.fdEnd),'YYYY') || ' ???????? ???? <>'||
       F.fName||'<>/>'||
       US.fName s1
from U_StudGroup USG inner join U_Curr_Group      UCG  on UCG.fcStGr      = USG.fNrec
                     inner join U_CurriCulum      UCC  on UCG.fcCurr      = UCC.fNrec
                     inner join U_Curr_Dis        UCD  on UCD.fcCurr      = UCG.fcCurr
                     inner join U_Curr_DisContent UCDC on UCDC.fcCurr_dis = UCD.fNrec                     
                     inner join U_Discipline      UD   on UCD.fcDis       = UD.fNrec
                     inner join U_Curr_Semester   UCS  on UCDC.fcSemester = UCS.fNrec
                     inner join U_TypeWork        UTW  on UCDC.fcTypeWork = UTW.fNrec
                     inner join Catalogs          F    on USG.fcFaculty   = F.fNrec
                     inner join U_Curr_Course     UCK  on UCS.fcCurr_Course = UCK.fNrec
                     inner join U_Specialization  US   on UCC.fcSpecialization = US.fNrec
where utw.fwtype in (4,5,14,8)
  and UCC.fwType = 2
 -- and to_char(UCC.fYearEd) = to_char(:GOD)
 -- and UCS.fwSeason         = :SEMESTR
--  and trunc(to_oradate(UCS.fdBeg)) <= trunc(:VDATE)
--  and trunc(to_oradate(UCS.fdEnd)) >= trunc(:VDATE)
 -- and UCC.fcSpecialization like case when :PODR like '%e%' then substr(:PODR,1,16)  else '%' end
union all
select 'Сводная ведомость успеваемости' s1
from dual
order by 1 desc
