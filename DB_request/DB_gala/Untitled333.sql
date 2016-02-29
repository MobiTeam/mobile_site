grant select on ais_fzp.v_sp_c_pr to mobile;


create view v_sp_c_pr
as
Select FFIO,SUMMA from v_sp_vprikaz_print_2


Select * from v_sp_doplata_do_mrot


Select * from v_sp_doplata_do_mrot where PROCENT>0 and RN=1

Select * from sp_name_pay

Select * from sp_krit_pay

create table sp_krit_pay_new(
FNREC number,
NAME_KRIT VARCHAR2(512),
REQUIR_KRIT VARCHAR2(512),
FNREC_NAME_PAY number,
archive_krit number
)

drop sequence auto_sp_krit_pay_new
/
Create sequence auto_sp_krit_pay_new start with 9


CREATE trigger TR_SP_KRIT_PAY_NEW
  before insert on SP_KRIT_PAY_NEW
  for each row
begin
  select auto_sp_krit_pay_new.nextval into :NEW.FNREC from dual;
end;


Select * from v_pers_podr_sovm


Select * from sp_name_pay snp
inner join (Select NAME_KRIT,REQUIR_KRIT,FNREC_NAME_PAY from sp_krit_pay_new UNION Select NAME_KRIT,REQUIR_KRIT,FNREC_NAME_PAY from sp_krit_pay ) skpn on skpn.FNREC_NAME_PAY = snp.fnrec


create or replace view v_krit_name_all
as
Select snp.fnrec fnrec_pay,snp.name_pay name_pay,skpn.FNREC fnrec_krit,skpn.name_krit name_krit, skpn.REQUIR_KRIT REQUIR_KRIT, count(*) over(partition by snp.fnrec) cnt, row_number () over (partition by snp.fnrec order by snp.fnrec) RN
 from sp_name_pay snp
inner join (Select FNREC,NAME_KRIT,REQUIR_KRIT,FNREC_NAME_PAY from sp_krit_pay_new UNION Select FNREC,NAME_KRIT,REQUIR_KRIT,FNREC_NAME_PAY from sp_krit_pay ) skpn on skpn.FNREC_NAME_PAY = snp.fnrec
where snp.fnrec <> 3
    order by 1,3


Select * from mv_sp_appointments_all




create table sp_krit_appointments(
FNREC number,
APPOINT VARCHAR2(64),
RDATE DATE,
Crit_nrec varchar2(1024)
)

drop sequence auto_sp_krit_appointments
/
Create sequence auto_sp_krit_appointments

/
CREATE trigger TR_sp_krit_appointments
  before insert on sp_krit_appointments
  for each row
begin
  select auto_sp_krit_appointments.nextval into :NEW.FNREC from dual;
end;

Select * from sp_krit_appointments

Create or replace view v_sp_krit_appoinments
as
Select msaaa.FCAPPOINT,msaaa.ffio,msaaa.vid,msaaa.fperson,msaaa.fstaffstr,msaaa.faculty,msaaa.kafedra,
       msaaa.dol,msaaa.podr_gl_nrec,msaaa.nrec_kaf,msaaa.rdate,ska.fnrec krit_appoint_nrec,ska.crit_nrec,vkna.fnrec_pay,vkna.name_pay,vkna.fnrec_krit,vkna.name_krit,vkna.requir_krit,ska.ball,
        count(*) over(partition by msaaa.FCAPPOINT) cnt,count(*) over(partition by vkna.name_pay) cnt_pay
 from mv_sp_appointments_all_all msaaa
left outer join sp_krit_appointments ska on ska.FCAPPOINT=msaaa.fcappoint
left outer join v_krit_name_all vkna on vkna.fnrec_krit =ska.crit_nrec
order by FFIO,FCAPPOINT,FNREC_PAY

Select NAME_KRIT from v_krit_name_all

Select * from sp_krit_appointments

Select * from v_krit_name_all
where 

Select * from v_sp_krit_appoinments

Select * from v_sp_krit_appoinments where  lower(FFIO) like lower('%якимчук%')

Select * from mv_select_person

Select FNREC_KRIT from v_krit_name_all
Select NAME_KRIT from v_krit_name_all where lower(NAME_KRIT) like  ('сложность')


Select * from SP_ADD_APPOINT_ALL


Select * from v_sp_krit_appoinments where  FCAPPOINT='800100000001B35D'

Select SUM(BALL) as APSUM from v_sp_krit_appoinments where  FCAPPOINT='800100000001B35D'

Select * from sp_add_fondrektora


Select * from mv_sp_rukovoditeli


select * from v_sp_krit_appoinments
