Select * from mv_select_person where FPERSON='800100000000A653'


Select FPERSON,FFIO,FDEPARTMENT from mv_select_person where PODR_GL_NREC in ('8001000000029331','80010000000294A0','8001000000002DF9','8001000000002E01','80010000000290E2','8001000000001AC2','8001000000001ACE','800100000002967E')


Select FPERSON from mv_select_person where PODR_GL_NREC in ('80010000000294A0')

Select mm.ffio,sp.* from sp_val_appoint sp
inner join MV_SELECT_PERSON mm on mm.fperson=sp.fnrec_persons
 where FNREC_PERSONS in (Select FPERSON from mv_select_person where PODR_GL_NREC in ('8001000000029331','80010000000294A0','8001000000002DF9','8001000000002E01','80010000000290E2','8001000000001AC2','8001000000001ACE','800100000002967E'))  and TO_CHAR(DATE_CHANGE,'MM')='08'


Select * from sp_val_appoint where TO_CHAR(DATE_CHANGE,'MM')='08'


Select FFIO,FPERSON from mv_select_person where FPERSON in (Select FNREC_PERSONS from sp_val_appoint where FNREC_PERSONS in (Select FPERSON from mv_select_person where PODR_GL_NREC in ('8001000000029331','80010000000294A0','8001000000002DF9','8001000000002E01','80010000000290E2','8001000000001AC2','8001000000001ACE','800100000002967E'))  and TO_CHAR(DATE_CHANGE,'MM')='08')



