----------------------�������� ���������� �������������---------------------------------
create or replace view v_teach_appoint_all
as
Select FIO,PROF institute,FNAME post,FRATE rate,PRIZN,FBUD budget,FTARIF tarif,FCATEGORY category,DATEREG,FSEX sex,
FBORNDATE borndate,STAVKA,FNAIKAT naikat
 from mv_teach_appoint
    where instr(
        upper(replace(replace(FIO,'',''),' ','')),
        upper(replace(replace('��������� ��������','.',''),' ','')),1)>=1
         
----------------------------------����� �� ��������------------------------------------------------

Select * from v_teac_kott
    where instr(
        upper(replace(replace(FIO,'',''),' ','')),
        upper(replace(replace('��������� ��������','.',''),' ','')),1)>=1


--------------------------����� �� �������--------------------------------------------------------

Select * from v_teac_room
    where instr(
        upper(replace(replace(FIO,'',''),' ','')),
        upper(replace(replace('��������� ��������','.',''),' ','')),1)>=1

---------------------------------------���������� �� �������----------------------------------------
Select * from v_teac_caf
    where prof='������� ����������� ������'

-----------------------------------����������-------------------------------
Select * from v_teac_contact
    where instr(
        upper(replace(replace(FIO,'',''),' ','')),
        upper(replace(replace('���������','.',''),' ','')),1)>=1
        and rownum =1
        
------------------------------------------------������� �����������---------------------------------
Select  * from v_teac_holiday 
where instr(
        upper(replace(replace(FFIO,'',''),' ','')),
        upper(replace(replace('��������� ��������','.',''),' ','')),1)>=1
        
-----------------------------------------------------�������� �������������---------------------------
Select * from v_teac_nagruzka
where instr(
        upper(replace(replace(FFIO,'',''),' ','')),
        upper(replace(replace('�������� �','.',''),' ','')),1)>=1
        
---------------------------------------------------------------------------


Create or replace view V_info_timetable
as
Select * from info_timetable



Create table info_timetable
as
Select Distinct TEAC_FIO info from v_timetable
/
Insert into info_timetable(info)
Select Distinct GR_NUM info from v_timetable
/
Insert into info_timetable(info)
Select Distinct (aud||' '||korp) info from v_timetable


Select * from v_info_timetable

Select DISTINCT VID from v_timetable_all




