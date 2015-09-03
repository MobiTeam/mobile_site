----------------------Основное назначение преподавателя---------------------------------
create or replace view v_teach_appoint_all
as
Select FIO,PROF institute,FNAME post,FRATE rate,PRIZN,FBUD budget,FTARIF tarif,FCATEGORY category,DATEREG,FSEX sex,
FBORNDATE borndate,STAVKA,FNAIKAT naikat
 from mv_teach_appoint
    where instr(
        upper(replace(replace(FIO,'',''),' ','')),
        upper(replace(replace('Бурлуцкий Владимир','.',''),' ','')),1)>=1
         
----------------------------------Долги за коттеджи------------------------------------------------

Select * from v_teac_kott
    where instr(
        upper(replace(replace(FIO,'',''),' ','')),
        upper(replace(replace('Бурлуцкий Владимир','.',''),' ','')),1)>=1


--------------------------Долги за комнаты--------------------------------------------------------

Select * from v_teac_room
    where instr(
        upper(replace(replace(FIO,'',''),' ','')),
        upper(replace(replace('Бурлуцкий Владимир','.',''),' ','')),1)>=1

---------------------------------------Сотрудники по кафедре----------------------------------------
Select * from v_teac_caf
    where prof='Кафедра иностранных языков'

-----------------------------------Телефоны и кабинеты преподавателей-------------------------------
Select * from v_teac_tel
