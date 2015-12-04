create or replace synonym pps_krit for reit.krit;
/
create or replace synonym pps_reiting for reit.reiting;
/
create or replace synonym pps_rpersons for reit.rpersons;
/
create or replace synonym pps_money for reit.money;


----------------------Основное назначение преподавателя---------------------------------
create or replace view v_teach_appoint_all
as
Select FIO,PROF institute,FNAME post,FRATE rate,PRIZN,FBUD budget,FTARIF tarif,FCATEGORY category,DATEREG,FSEX sex,
FBORNDATE borndate,STAVKA,FNAIKAT naikat
 from mv_teach_appoint
    where instr(
        upper(replace(replace(FIO,'',''),' ','')),
        upper(replace(replace('Нехорошев','.',''),' ','')),1)>=1
         
----------------------------------Долги за коттеджи-------------------------ДАТЬ GRANT с  GALREPORT-----------------------

Select * from v_teac_kott
    where instr(
        upper(replace(replace(FIO,'',''),' ','')),
        upper(replace(replace('Бурлуцкий Владимир','.',''),' ','')),1)>=1


--------------------------Долги за комнаты---------------------------------ДАТЬ GRANT с  GALREPORT-----------------------

Select * from v_teac_room
    where instr(
        upper(replace(replace(FIO,'',''),' ','')),
        upper(replace(replace('Бурлуцкий Владимир','.',''),' ','')),1)>=1

---------------------------------------Сотрудники по кафедре----------------------------------------
Select * from v_teac_caf
where instr (
        upper(replace(replace(prof,'',''),' ','')),
        upper(replace(replace('иностранных','.',''),' ','')),1)>=1


-----------------------------------Справочник-------------------------------
Select * from v_teac_contact
    where instr(
        upper(replace(replace(FIO,'',''),' ','')),
        upper(replace(replace('Сабанцева','.',''),' ','')),1)>=1
        and rownum =1
        
------------------------------------------------Отпуска сотрудников---------------------------------
Select  * from v_teac_holiday 
where instr(
        upper(replace(replace(FFIO,'',''),' ','')),
        upper(replace(replace('Бурлуцкий Владимир','.',''),' ','')),1)>=1
        
-----------------------------------------------------Нагрузка преподавателя---------------------------
Select * from v_teac_nagruzka
where instr(
        upper(replace(replace(FFIO,'',''),' ','')),
        upper(replace(replace('Славский В','.',''),' ','')),1)>=1
        


---------------------------------------------Надбавки-------------------------------------------------

Select * from v_teac_stimul

Select * from v_teac_stimulpr

------------------------------------------------------------------------------------------------------

Select * from v_timetable_all
    where trunc(to_date(datezan)) >= trunc(TO_DATE('09.11.2015','DD.MM.YYYY'))
    and trunc(to_date(datezan)) <=trunc(TO_DATE('09.11.2015','DD.MM.YYYY'))+6


