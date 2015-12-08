----------------------Стипендия студента
create materialized view MV_STUD_AWARDS
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
REFRESH COMPLETE START WITH TO_DATE('12-8-2015 5:00 PM','DD-MM-YYYY HH12:MI PM') NEXT SYSDATE + 6/24  
as
Select * from V_STUD_AWARDS

    Select * from MV_STUD_AWARDS
            where instr(
        upper(replace(replace(FFIO,'.',''),' ','')),
        upper(replace(replace('Якимчук Александр','.',''),' ','')),1)>=1
        
        
------------------------------Люди по кафедре/Институту и их контакты
Select * from v_teac_contact
where instr (
        upper(replace(replace(FIO,'',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1
        
 ------------------------------Долги за общежития------------------------
Select * from V_STUD_DOL 
    where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1
        
----------------------------Долги за обучение----------------------------
Select * from V_STUD_EDUCATION
    where instr(
    upper(replace(replace(FIO,'.',''),' ','')),
    upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1
    
---------------------------Долги за коттеджи----------------------------
Select * from v_teac_kott
        where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1 
        
---------------------------Долги за комнату---------------------   
Select * from v_teac_room
        where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1
        
--------------------------Полное назначение студента----------------------
Select * from v_stud_appoint_all ap  
where instr(
        upper(replace(replace(ap.FFIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1
    and ap.grup like '%\'".$GRUP."\'%' 
    
-------------------------Полное назначение преподавателя-------------------
Select * from V_TEACH_APPOINT_ALL 
        where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('Бурлуцкий Владимир','.',''),' ','')),1)>=1
----------------------Студенты в группе--------------------------
Select * from v_stud_group
        where FSDEPCODE like '%1121%'
----------------------Отпуск преподавателя--------------------------

Select * from Mv_teac_holiday 
        where instr(
        upper(replace(replace(FFIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1
-----------------------Сотрудники по кафедре---------------------
Select * from v_teac_caf
where instr (
        upper(replace(replace(prof,'',''),' ','')),
        upper(replace(replace('".$cafidra."','.',''),' ','')),1)>=1
----------------------Оценки студента--------------------------   
Select * from v_stud_marks
where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('Якимчук','.',''),' ','')),1)>=1 
-------------------------Нагрузки преподавателя-----------------------  
Select * from v_teac_nagruzka
        where instr(
        upper(replace(replace(FFIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1 
-------------------------Стимулирующие пр персонала-----------------------   
Select * from v_teac_stimulpr

--------------------Надбавки ППС------------
Select * from v_teac_stimul
------------------------------------------------   
    
