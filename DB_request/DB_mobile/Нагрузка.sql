--create or replace view V_BK_NAGRUZKA as
select 
distinct TT.TEAC_FIO,
--DECODE(UC.fcfaculty, '80000000000001D7', UC.fcchair, UC.fcfaculty) fnrec_vinst,
       DECODE(UC.fcfaculty, '80000000000001D7', CVKF.fname, CVFC.fname)   fname_vinst,
 --    UC.fcchair                       fnrec_vkaf,
       CVKF.fname                       fname_vkaf,
       replace(CSP.fcode,'.','')        fcode,
       CSP.fname                        fname,
       UC.fwformed                      fforma,
       CLV.fcode                        flevel,
       USG.fyearent                     fyear,
       UC2.fterm                        fterm,
--     USG.fnrec                        fnrec_sg,
       USG.fname                        fname_sg,
       UTL.fwyeared                     fyear_plan,
       UDL.fwcourse                     fcourse,
       UDL.fsemester                    fsemestr,
       decode(UDL.fwseason, 1, 2, 1)    fsezon,
--     DECODE(CFC.fnrec, '80000000000001D7', CKF.fnrec, CFC.fnrec) fnrec_inst,
       DECODE(CFC.fnrec, '80000000000001D7', CKF.fname, CFC.fname) fname_inst,
--     CKF.fnrec                        fnrec_kaf,
       CKF.fname                        fname_kaf,
--     UDLC.fcdiscipline                fnrec_discip,
       NVL(UDL.fsdiscipname, UD.fname)  fname_discip,
       UTW.fname                        ftype_load,
       UCG.fnumstud                     fcount_stud_fact,  -- "фактическое" кол-во человек
       UCG.fnumstudload                 fcount_stud_grup,  -- планируемое кол-во человек в группе
--     SUM(UCG.fnumstudload) over (partition by UCG.fccurr, UDLC.fnrec) fcount_stud_plan,  -- планируемое кол-во человек на потоке
--     UDLC.fistudcount                 fcount_stud_load,  -- кол-во человек из этого потока дл€ которых расчитана нагрузка
--     UDL.fistudcount                  fcount_stud_load_all,  -- общее кол-во человек дл€ которых расчитана нагрузка
--     UDL.fwcurrgrcount                fcount_grup1,  -- общее кол-во групп дл€ которых расчитана нагрузка
       COUNT(*) over (partition by UCG.fccurr, UDLC.fnrec) fcount_grup2,  -- кол-во групп из этого потока дл€ которых расчитана нагрузка
       UDL.fdload                       fload
/*       ROUND( case when UDL.fwcurrgrcount = 1 then UDL.fdload
                   else case when UDL.fistudcount = 0 then 0
                             else case when COUNT(*) over (partition by UCG.fccurr, UDLC.fnrec) = 1 then UDLC.fistudcount / UDL.fistudcount * UDL.fdload
                                       else case when UDLC.fistudcount < SUM(UCG.fnumstudload) over (partition by UCG.fccurr, UDLC.fnrec) then UDLC.fistudcount / COUNT(*) over (partition by UCG.fccurr, UDLC.fnrec) / UDL.fistudcount * UDL.fdload
                                                 else UCG.fnumstudload / UDL.fistudcount * UDL.fdload end end end end, 2) fload_norm */
                                             
  from U_DiscipLoadCurr UDLC inner join U_Curr_Dis       UCD  on UCD.fcdis  = UDLC.fcdiscipline
                             inner join U_ComponentDis   UCDM on UCDM.fnrec = UCD.fccomponent
                             inner join U_CyclesDis      UCYD on UCYD.fnrec = UCD.fccycle
                             inner join U_Curriculum     UC   on UC.fnrec   = UDLC.fccurr and
                                                                 UC.fnrec   = UCD.fccurr
                             inner join U_Curr_Group     UCG  on UCG.fccurr = UC.fnrec
                             inner join U_StudGroup      USG  on USG.fnrec  = UCG.fcstgr
                             inner join Catalogs         CSP  on CSP.fnrec  = UC.fcspeciality
                             inner join Catalogs         CLV  on CLV.fnrec  = UC.fcqualification
                             inner join Catalogs         CVKF on CVKF.fnrec = UC.fcchair
                             inner join U_Discipline     UD   on UD.fnrec   = UDLC.fcdiscipline
                             inner join U_DisciplineLoad UDL  on UDL.fnrec  = UDLC.fcdisciploadid
                             inner join U_TypeWork       UTW  on UTW.fnrec  = UDL.fctypework
                             inner join U_TeachingLoad   UTL  on UTL.fnrec  = UDL.fcloadid
                             inner join Catalogs         CKF  on CKF.fnrec  = UTL.fcchair
                             inner join Catalogs         CVFC on CVFC.fnrec = UC.fcfaculty
                             inner join Catalogs         CFC  on CFC.fnrec  = CKF.fcparent
                             inner join U_Curriculum     UC2  on UC2.fnrec  = UC.fcparent
                                            
                             
                             
                             inner join mv_cisu_timetable_all TT on CKF.fname = TT.TEAC_CAF 
                             and NVL(UDL.fsdiscipname, UD.fname) = TT.DISCIPLINE
                             and TT.GR_NUM = USG.fname
                             
                             
                             
 where     UC.fwtype = 2
       and UC.fstatus <> 2
       and UTL.fwyeared + UDL.fwseason = extract(year from sysdate) + 1
       --and UDL.fwseason = 2
     --  and USG.fname like '%1521б%'
       and TT.TEAC_FIO like 'Ѕурлуцкий ¬.¬.'

