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

-----------------------------------�������� � �������� ��������������-------------------------------
Select * from v_teac_tel
