create synonym mv_stud_appoint for budget.mv_cisu_stud_appoint


create synonym mv_timetable_all for budget.mv_cisu_timetable_all

----------Таблицы с авторизационными данными
------------ Таблица пользователей----------------------------------------------------------------------
CREATE TABLE users (
    id NUMBER,
    login VARCHAR2(1024),
    pass VARCHAR2(1024),
    id_usergroup NUMBER,
    constraint USERS_PK PRIMARY KEY (id))
    /
CREATE sequence USERS_SEQ
/
CREATE trigger BI_USERS
  before insert on USERS
  for each row
begin
  select USERS_SEQ.nextval into :NEW.id from dual;
end;
/


/
ALTER TABLE users ADD CONSTRAINT users_fk0 FOREIGN KEY (id_usergroup) REFERENCES usergroup(id);

---------------------------------------------------------------ДЕЙСТВИЯ------------------------------
CREATE TABLE actions (
    id NUMBER,
    name_action VARCHAR2(4000),
    constraint ACTIONS_PK PRIMARY KEY (id))
    /
CREATE sequence ACTIONS_SEQ
/
CREATE trigger BI_ACTIONS
  before insert on ACTIONS
  for each row
begin
  select ACTIONS_SEQ.nextval into :NEW.id from dual;
end;
/


/
------------------------------------------------------------------ЛОГИ--------------------
CREATE TABLE logs (
    id NUMBER,
    id_action NUMBER,
    id_user NUMBER,
    date_action DATE,
    constraint LOGS_PK PRIMARY KEY (id))
    /
CREATE sequence LOGS_SEQ
/
CREATE trigger BI_LOGS
  before insert on LOGS
  for each row
begin
  select LOGS_SEQ.nextval into :NEW.id from dual;
end;
/


/
ALTER TABLE logs ADD CONSTRAINT logs_fk0 FOREIGN KEY (id_action) REFERENCES actions(id);
ALTER TABLE logs ADD CONSTRAINT logs_fk1 FOREIGN KEY (id_user) REFERENCES users(id);
-----------------------------------------------------------------------------Настройки пользователя--------------------
CREATE TABLE user_settings (
    id NUMBER,
    id_user NUMBER,
    id_function NUMBER,
    constraint USER_SETTINGS_PK PRIMARY KEY (id))
    /
CREATE sequence USER_SETTINGS_SEQ
/
CREATE trigger BI_USER_SETTINGS
  before insert on USER_SETTINGS
  for each row
begin
  select USER_SETTINGS_SEQ.nextval into :NEW.id from dual;
end;
/


/
ALTER TABLE user_settings ADD CONSTRAINT user_settings_fk0 FOREIGN KEY (id_user) REFERENCES users(id);
ALTER TABLE user_settings ADD CONSTRAINT user_settings_fk1 FOREIGN KEY (id_function) REFERENCES functions(id);
--------------------------------------------------------------ФУНКЦИИ----------------------------------------
CREATE TABLE functions (
    id NUMBER,
    name VARCHAR2(4000),
    constraint FUNCTIONS_PK PRIMARY KEY (id))
    /
CREATE sequence FUNCTIONS_SEQ
/
CREATE trigger BI_FUNCTIONS
  before insert on FUNCTIONS
  for each row
begin
  select FUNCTIONS_SEQ.nextval into :NEW.id from dual;
end;
/

/
---------------------------------------------------------------------РОЛЬ-----------------------------------
CREATE TABLE usergroup (
    id NUMBER,
    usergroup_name VARCHAR2(4000),
    constraint USERGROUP_PK PRIMARY KEY (id))
    /
CREATE sequence USERGROUP_SEQ
/
CREATE trigger BI_USERGROUP
  before insert on USERGROUP
  for each row
begin
  select USERGROUP_SEQ.nextval into :NEW.id from dual;
end;
/


