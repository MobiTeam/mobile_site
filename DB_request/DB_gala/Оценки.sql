
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
     and US.fFio = 'Якимчук Александр Васильевич'
     and USG.Fname  = '1521б'
 -- and to_char(UCC.fYearEd) = to_char(:GOD) ---ГОД
 -- and UCS.fwSeason        = :SEMESTR --СЕМЕСТР
  --and trunc(to_oradate(UCS.fdBeg)) <= sysdate
 --and trunc(to_oradate(UCS.fdEnd)) >= trunc('01.09.2012') дата
--order by UCS.fSemester, UCDC.fCode desc, UD.fName
) D
left outer join 
--inner join

---Доделать
(select   UL.fwSemestr,UTW.Fname,
         UM.fsFio, UM.fwMark, C.fName Zach,UD.fName Dis
 from U_List UL inner join U_Marks      UM on UM.fcList = UL.fNrec
                inner join U_StudGroup USG on UL.fcStGr = USG.fNrec
                inner join U_Discipline      UD   on UL.fcDis       = UD.fNrec
                inner join Catalogs      C on UM.fcMark = C.fNrec
                inner join U_TypeWork        UTW  on UL.fcTypeWork = UTW.fNrec
             where UM.fsFio = 'Якимчук Александр Васильевич'
 ) O 
 
     on D.fcDis      = O.fcDis
     and D.fcStGr     = O.fcStGr
     and D.fcTypeWork = O.fcTypeWork
     and D.fcPersons  = O.fcPersons 
     and D.fSemester  = O.fwSemestr
    -- where O.fwMark is not null
    order by 1, 3, 2
    
-------------------------------ОЦЕНКИ--------------------------
    
create or replace view v_cisu_stud_marks
as


select   UM.fsFio FIO ,UD.fName Dis,USG.Fname gr_name,C.fName Zach,UL.fwSemestr Semestr,UTW.Fname typework,
          UM.fwMark
 from U_List UL inner join U_Marks      UM on UM.fcList = UL.fNrec
                inner join U_StudGroup USG on UL.fcStGr = USG.fNrec
                inner join U_Discipline      UD   on UL.fcDis       = UD.fNrec
                inner join Catalogs      C on UM.fcMark = C.fNrec
                inner join U_TypeWork        UTW  on UL.fcTypeWork = UTW.fNrec

        order by UL.fwSemestr ASC
        
        
        
---------------------------------------Средний балл группы----------------------------------------------------------------------

select   UM.fsFio FIO ,USG.Fname number_group,UD.fName Dis,USG.Fname gr_name,C.fName Zach,UL.fwSemestr Semestr,UTW.Fname typework,
          UM.fwMark
 from U_List UL inner join U_Marks      UM on UM.fcList = UL.fNrec
                inner join U_StudGroup USG on UL.fcStGr = USG.fNrec
                inner join U_Discipline      UD   on UL.fcDis       = UD.fNrec
                inner join Catalogs      C on UM.fcMark = C.fNrec
                inner join U_TypeWork        UTW  on UL.fcTypeWork = UTW.fNrec
where USG.Fname  = '1121б'
and UPPER(UM.fsfio) in (select UPPER(ffio) from U_student 
Where   
FSDEPCODE like '%1121б%' and
 (fdisdate = 0 or trunc(to_oradate(fdisdate)) >= trunc(sysdate))
  and (fappdate = 0 or trunc(to_oradate(fappdate)) <= trunc(sysdate)))
  and UTW.Fname<>'Зачёты'
        order by UL.fwSemestr ASC
