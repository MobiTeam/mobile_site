----------------------��������� ��������
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
        upper(replace(replace('������� ���������','.',''),' ','')),1)>=1
        
        
------------------------------���� �� �������/��������� � �� ��������
Select * from v_teac_contact
where instr (
        upper(replace(replace(FIO,'',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1
        
 ------------------------------����� �� ���������------------------------
Select * from V_STUD_DOL 
    where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1
        
----------------------------����� �� ��������----------------------------
Select * from V_STUD_EDUCATION
    where instr(
    upper(replace(replace(FIO,'.',''),' ','')),
    upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1
    
---------------------------����� �� ��������----------------------------
Select * from v_teac_kott
        where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1 
        
---------------------------����� �� �������---------------------   
Select * from v_teac_room
        where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1
        
--------------------------������ ���������� ��������----------------------
Select * from v_stud_appoint_all ap  
where instr(
        upper(replace(replace(ap.FFIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1
    and ap.grup like '%\'".$GRUP."\'%' 
    
-------------------------������ ���������� �������������-------------------
Select * from V_TEACH_APPOINT_ALL 
        where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('��������� ��������','.',''),' ','')),1)>=1
----------------------�������� � ������--------------------------
Select * from v_stud_group
        where FSDEPCODE like '%1121%'
----------------------������ �������������--------------------------

Select * from Mv_teac_holiday 
        where instr(
        upper(replace(replace(FFIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1
-----------------------���������� �� �������---------------------
Select * from v_teac_caf
where instr (
        upper(replace(replace(prof,'',''),' ','')),
        upper(replace(replace('".$cafidra."','.',''),' ','')),1)>=1
----------------------������ ��������--------------------------   
Select * from v_stud_marks
where instr(
        upper(replace(replace(FIO,'.',''),' ','')),
        upper(replace(replace('�������','.',''),' ','')),1)>=1 
-------------------------�������� �������������-----------------------  
Select * from v_teac_nagruzka
        where instr(
        upper(replace(replace(FFIO,'.',''),' ','')),
        upper(replace(replace('".$FFIO."','.',''),' ','')),1)>=1 
-------------------------������������� �� ���������-----------------------   
Select * from v_teac_stimulpr

--------------------�������� ���------------
Select * from v_teac_stimul
------------------------------------------------   
    
