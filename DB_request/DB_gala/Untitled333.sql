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
inner join (Select NAME_KRIT,REQUIR_KRIT,FNREC_NAME_PAY from sp_krit_pay,sp_krit_pay_new) skpn on skpn.FNREC_NAME_PAY = snp.fnrec





