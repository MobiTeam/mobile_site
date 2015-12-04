-------------------------------------------------------------Таблица администраторов
create table BG_ACCESS (
ID number,
NREC varchar2(32),
FIO varchar2(512)
)
/
Create sequence AUTO_BG_ACCESS
/
Create trigger TR_BG_ACCESS
  before insert on BG_ACCESS
  for each row
begin
  select AUTO_BG_ACCESS.nextval into :NEW.ID from dual;
end;

------------------------------------------------------------Таблица Институтов
drop table BG_INSTITUTE
/
Create table BG_INSTITUTE(
ID number,
NREC_INST varchar2(24),
NAME_INST varchar2(1024)
)
/
drop sequence AUTO_BG_INSTITUTE
/
Create sequence AUTO_BG_INSTITUTE
/
drop trigger TR_BG_INSTITUTE
/
Create trigger TR_BG_INSTITUTE
  before insert on BG_INSTITUTE
  for each row
begin
  select AUTO_BG_INSTITUTE.nextval into :NEW.ID from dual;
end;


----------------------
Select * from v_derevofilials 
    where UPPER(FSDOPINF) in ('Ф','К')
        and k_kur_sort=2
        and STAROE=0
        and FDATOK=0
        
  
----------------------------------------------------Добавление всех институтов и кафедр в таблицу институтов
INSERT INTO bg_institute (NREC_INST,NAME_INST)
(Select FNREC,FNAME from v_derevofilials 
    where UPPER(FSDOPINF) in ('Ф','К')
        and k_kur_sort=2
        and STAROE=0
        and FDATOK=0
)
---------------------------------------------------------Таблица делегирований
drop table bg_delegate
/
Create table BG_DELEGATE(
ID number,
NREC_INST varchar2(24),
NAME_INST varchar2(1024),
NREC_DELEGATE varchar2(24),
FIO_DELEGATE varchar2(1024),
DATE_FROM date,
DATE_TO date
)
/
drop sequence AUTO_BG_DELEGATE
/
Create sequence AUTO_BG_DELEGATE
/
drop trigger TR_BG_DELEGATE
/
Create trigger TR_BG_DELEGATE
  before insert on BG_DELEGATE
  for each row
begin
  select AUTO_BG_DELEGATE.nextval into :NEW.ID from dual;
end;
----------------------------------------------------------Существующие делегированные
Select * from BG_DELEGATE
    where DATE_TO is null or DATE_TO>=sysdate
---------------------------------------------------------Связь всех институтов с уже делегированными
Create or replace view V_BG_DELEGATE
as
Select Distinct ins.nrec_inst,ins.name_inst,ins.LV,dl.nrec_delegate,dl.fio_delegate,dl.date_from,dl.date_to from BG_DELEGATE dl
right outer join BG_INSTITUTE ins on dl.nrec_inst=ins.nrec_inst
and dl.DATE_TO is null or dl.DATE_TO>=sysdate
--------------------------------------------
Select * from V_BG_DELEGATE
--------------------------------------------
Select * from mv_select_person

---------------------Проставить институтам уровень 1 , кафедрам уровень 0
UPDATE bg_institute 
SET  LV='1'
where NAME_INST like ('%ИНСТИТУТ%')
---------------------------------------
Select ins.nrec_inst,ins.name_inst,ins.LV,dl.nrec_delegate,dl.fio_delegate,dl.date_from,dl.date_to from BG_DELEGATE dl
right outer join BG_INSTITUTE ins on dl.nrec_inst=ins.nrec_inst
and dl.DATE_TO is null or dl.DATE_TO>=sysdate
------------------------------------------------------------Соединение зав кафедр---------

INSERT INTO bg_delegate(NREC_INST,NAME_INST,NREC_DELEGATE,FIO_DELEGATE,DATE_FROM)
Select distinct ruk.PODR,ins.name_inst,ruk.FPERSON,per.FFIO,sysdate from v_hd_rukovoditeli ruk
    Inner join bg_institute ins on ins.NREC_INST=ruk.PODR
    Inner join mv_select_person per on per.fperson = ruk.fperson
    
    Select * from mv_select_person

