grant select on mv_cisu_teach_appoint to mobile;
grant select on gala_rasp."Chair" to mobile;




drop sequence auto_fzp_val_podr
/
create sequence auto_FZP_VAL_PODR


select SIGN_FIO from V_SP_VPRIKAZ_PRINT group by SIGN_FIO

select * from V_SP_VPRIKAZ_PRINT where SIGN_FIO='Проректор по общим вопросам ШАВЫРИН А.А.'


select to_char(RDATE,'MM') from SP_REPDATE

Select SYSDATE+1/24 from dual

Select To_Char(SysDate,'Day') from dual
