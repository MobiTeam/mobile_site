

---------------------------------------Таблица авторизации------------V-----------COMPLETE---------------------------
Create table RC_AUTORIZATION(
ID number,
login varchar2(256),
pass varchar2(256),
mail varchar2(256),
telephone_number varchar2(20),
name_company varchar2(512),
description_company varchar2(1024)
)

CREATE sequence RC_AUTORIZATION_SEQ
/
CREATE trigger RC_AUTORIZATION_TR
  before insert on RC_AUTORIZATION
  for each row
begin
  select RC_AUTORIZATION_SEQ.nextval into :NEW.id from dual;
end;
/

----------------------------------------------------Таблица для оставленных заявок--------------------------------

Create table RC_STATEMENT(
ID number,
ID_USER number,
specialization varchar2(2048),
course varchar(64),
Subject varchar(4000),
Mark varchar(4000)
)
/
CREATE sequence RC_STATEMENT_SEQ
/
CREATE trigger RC_STATEMENT_TR
  before insert on RC_STATEMENT
  for each row
begin
  select RC_AUTORIZATION_SEQ.nextval into :NEW.id from dual;
end;
/

----------------------------------Отправка сообщений администратору-------------COMPLETE---------------------------------
Create table RC_message_admin(
ID number,
ID_USER varchar2(128),
text varchar2(4000),
date_send date

)
/
CREATE sequence RC_message_admin_SEQ
/
CREATE trigger RC_message_admin_TR
  before insert on RC_message_admin
  for each row
begin
  select RC_message_admin_SEQ.nextval into :NEW.ID from dual;
end;
/

-----------------------------------------Таблица настроек---------------------------------------------------------
Create table RC_USER_SETTINGS(
ID number,
ID_USER varchar2(128),
SETTING varchar(128)
)
/
create sequence RC_USER_SETTING_SEQ
/
CREATE trigger RC_USER_SETTING_TR
    before insert on RC_USER_SETTINGS
    for each ROW
begin
    Select rc_message_admin_seq.NEXTVAL into :NEW.ID from dual;
end;
/    

Select * from mv_select_person

--------------------------------------------------------------------------------       
  

