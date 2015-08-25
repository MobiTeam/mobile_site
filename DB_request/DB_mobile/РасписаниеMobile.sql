create view v_timetable_all
as
Select mt.*,tp.time_start start_pair,tp.time_finish finish_pair from mv_timetable_all mt
inner join time_pair tp on mt.pair=tp.id_pair



CREATE TABLE time_pair (
    id NUMBER primary key,
    id_pair NUMBER,
    time_start varchar2(10),
    time_finish varchar2(10))
    /
    CREATE sequence time_pair_SEQ
/
CREATE trigger BI_time_pair
  before insert on time_pair
  for each row
begin
  select time_pair_SEQ.nextval into :NEW.id from dual;
end;
    
    constraint LOGS_PK PRIMARY KEY (id))
    
    
Select * from (Select * from NEWS order by ID desc)
Where rownum<50


