grant select on ais_fzp.v_sp_c_pr to mobile;


create view v_sp_c_pr
as
Select FFIO,SUMMA from v_sp_vprikaz_print_2


Select * from v_sp_doplata_do_mrot


Select * from v_sp_doplata_do_mrot where PROCENT>0 and RN=1
