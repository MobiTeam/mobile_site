Create or replace view v_teac_stimul
as
Select cc.fio fio,   
--Substr(a.kod, 1, 1) kod,

sum(case when status_p<>0 then ball_itog_p else case when status_k<>0  then ball_itog_k else case when status_z<>0 then ball_itog_z end end end) ball,
((Select BALL from pps_money where status=1 and data_<>' ')* sum(case when status_p<>0 then ball_itog_p else case when status_k<>0  then ball_itog_k else case when status_z<>0 then ball_itog_z end end end)) summa

from 
(select u.login login, u.fio fio, u.inst inst, u.kaf kaf, u.status_uch status_uch
from pps_rpersons u left outer join pps_reiting r on r.login=u.login 
where u.status_uch=1 and u.period=(Select to_char(sysdate,'YYYY')-1 from dual)
group by u.login, u.fio, u.inst, u.kaf, u.status_uch
) cc left outer join
(SELECT r.id id, r.login login, r.kaf rkaf, k.id kid, k.kod kod, k.krit krit, k.doc doc, k.doc_name doc_name, k.ball ball, k.status status, r.ball_itog ball_itog,
r.ball_itog_z ball_itog_z, r.data_z data_z, r.login_z login_z, r.status_z status_z,  
r.ball_itog_k ball_itog_k, r.data_k data_k, r.login_k login_k, r.status_k status_k,  
r.ball_itog_p ball_itog_p, r.data_p data_p, r.login_p login_p, r.status_p status_p, r.period period  
FROM pps_reiting r, pps_krit k
where k.id=r.id_krit and r.period=(Select to_char(sysdate,'YYYY')-1 from dual) order by k.id
) a on (cc.login=a.login  )
group by  cc.fio
order by cc.fio



Select * from v_teac_stimul

///------------
CREATE OR REPLACE TRIGGER bi_user_settings
 AFTER INSERT ON USERS
 FOR EACH ROW
begin
    insert into settings (ID_USER)
    values (:new.ID);
end;
/
-----------------------------------




