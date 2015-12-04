
---------------------------------------------Студенты--------------------------------
create or replace synonym v_stud_marks for budget.v_cisu_stud_marks
/
create or replace synonym v_stud_education for budget.v_cisu_stud_education---- Переделать
/
create or replace synonym v_stud_awards for budget.v_cisu_stud_awards
/
create or replace synonym v_stud_dol for budget.v_cisu_stud_dol
/
create or replace synonym v_stud_group for budget.v_cisu_stud_group
/
create or replace synonym v_stud_appoint2 for budget.v_cisu_stud_appoint2
/
create or replace synonym mv_stud_appoint for budget.mv_cisu_stud_appoint
--------------------------------------------Преподаватели-----------------------------

/
create or replace synonym v_teac_tel for budget.v_cisu_teac_tel
/
create or replace synonym v_teac_caf for budget.v_cisu_teac_caf

---------------------------------------
/
create or replace synonym v_teac_contact for gala_site.contact;
/
create or replace synonym v_teac_history_app for budget.v_cisu_teac_history_app;
/
create or replace synonym v_teac_holiday for budget.v_cisu_teac_holiday;
/
create or replace synonym v_teac_nagruzka for galreport.v_mobile_nagruzka;
--------------------------------------------------

create or replace synonym v_teac_room for galreport.dol_rab
/
create or replace synonym v_teac_kott for galreport.dol_kott
/
create or replace synonym v_stud_dol for galreport.dol_stud
/
create or replace synonym v_stud_education for galreport.dol
-----------------------------------------------------------
Create or replace synonym v_teac_stimulpr for budget.v_cisu_teac_stimulpr

------------------------------------------------------------
Create or replace synonym mv_teac_prikaz for galreport.mv_mobile_prikaz


