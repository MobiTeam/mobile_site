Select * from bg_pps_tarif

Create sequence AUTO_BG_PPS_TARIF start with 12
/
Create trigger TR_BG_PPS_TARIF
  before insert on bg_pps_tarif
  for each row
begin
  select AUTO_BG_PPS_TARIF.nextval into :NEW.FNREC from dual;
end;


Select * from bg_shedules
/
drop sequence AUTO_bg_shedules
/
Create sequence AUTO_bg_shedules
/
drop trigger TR_bg_shedules
/
Create trigger TR_bg_shedules
  before insert on bg_shedules
  for each row
begin
  select AUTO_bg_shedules.nextval into :NEW.FNREC from dual;
end;


Select * from bg_shedules_detail
/
drop sequence AUTO_bg_shedules_detail
/
Create sequence AUTO_bg_shedules_detail
/
drop trigger TR_bg_shedules_detail
/
Create trigger TR_bg_shedules_detail
  before insert on bg_shedules_detail
  for each row
begin
  select AUTO_bg_shedules_detail.nextval into :NEW.FNREC from dual;
end;


select SIGN_FIO from V_SP_VPRIKAZ_PRINT group by SIGN_FIO order by SIGN_FIO

create table SP_SIGNATURE(
POST VARCHAR2(512),
FIO VARCHAR2(512)
)

Select * from mv_select_person


select * from bg_shedules_app
/
drop sequence AUTO_bg_shedules_app
/
Create sequence AUTO_bg_shedules_app
/
drop trigger TR_bg_shedules_app
/
Create trigger TR_bg_shedules_app
  before insert on bg_shedules_app
  for each row
begin
  select AUTO_bg_shedules_app.nextval into :NEW.FNREC from dual;
end;

Select * from bg_shedules_persons

Create sequence AUTO_bg_shedules_persons
/
create trigger tr_bg_shedules_persons
    before insert on bg_shedules_persons
    for each row
begin
    Select  AUTO_bg_shedules_persons.nextval into :NEW.FNREC from dual;
end;        




Select * from mv_select_person

select * from V_FHD_RESULT

select PODR, PODR_GL_NREC, LV from MV_SP_RUKOVODITELI


Select NAME_KRIT from v_krit_name_all where lower(NAME_KRIT) like ('%Сложность%')



