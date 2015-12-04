create synonym costs for budget.costs
------------
CREATE TABLE users (
    "id" INT,
    "login" TEXT,
    "password" TEXT,
    "id_usergroup" INT,
    constraint CISU_USERS_PK PRIMARY KEY ("id")
CREATE sequence "CISU_USERS_SEQ"
/
CREATE trigger "BI_CISU_USERS"
  before insert on "CISU_USERS"
  for each row
begin
  select "CISU_USERS_SEQ".nextval into :NEW."id" from dual;
end;
/

)
/
ALTER TABLE "cisu_users" ADD CONSTRAINT "cisu_users_fk0" FOREIGN KEY ("id_usergroup") REFERENCES cisu_usergroup("id");
------------
CREATE TABLE "cisu_actions" (
    "id" INT,
    "name_action" TEXT,
    constraint CISU_ACTIONS_PK PRIMARY KEY ("id")
CREATE sequence "CISU_ACTIONS_SEQ"
/
CREATE trigger "BI_CISU_ACTIONS"
  before insert on "CISU_ACTIONS"
  for each row
begin
  select "CISU_ACTIONS_SEQ".nextval into :NEW."id" from dual;
end;
/

)
/
-----------
CREATE TABLE "cisu_logs" (
    "id" INT,
    "id_action" INT,
    "id_user" INT,
    "date_action" DATE,
    constraint CISU_LOGS_PK PRIMARY KEY ("id")
CREATE sequence "CISU_LOGS_SEQ"
/
CREATE trigger "BI_CISU_LOGS"
  before insert on "CISU_LOGS"
  for each row
begin
  select "CISU_LOGS_SEQ".nextval into :NEW."id" from dual;
end;
/

)
/
ALTER TABLE "cisu_logs" ADD CONSTRAINT "cisu_logs_fk0" FOREIGN KEY ("id_action") REFERENCES cisu_actions("id");
ALTER TABLE "cisu_logs" ADD CONSTRAINT "cisu_logs_fk1" FOREIGN KEY ("id_user") REFERENCES cisu_users("id");
------------
CREATE TABLE "cisu_user_settings" (
    "id" INT,
    "id_user" INT,
    "id_function" INT,
    constraint CISU_USER_SETTINGS_PK PRIMARY KEY ("id")
CREATE sequence "CISU_USER_SETTINGS_SEQ"
/
CREATE trigger "BI_CISU_USER_SETTINGS"
  before insert on "CISU_USER_SETTINGS"
  for each row
begin
  select "CISU_USER_SETTINGS_SEQ".nextval into :NEW."id" from dual;
end;
/

)
/
ALTER TABLE "cisu_user_settings" ADD CONSTRAINT "cisu_user_settings_fk0" FOREIGN KEY ("id_user") REFERENCES cisu_users("id");
ALTER TABLE "cisu_user_settings" ADD CONSTRAINT "cisu_user_settings_fk1" FOREIGN KEY ("id_function") REFERENCES cisu_functions("id");
------------
CREATE TABLE "cisu_functions" (
    "id" INT,
    "name" TEXT,
    constraint CISU_FUNCTIONS_PK PRIMARY KEY ("id")
CREATE sequence "CISU_FUNCTIONS_SEQ"
/
CREATE trigger "BI_CISU_FUNCTIONS"
  before insert on "CISU_FUNCTIONS"
  for each row
begin
  select "CISU_FUNCTIONS_SEQ".nextval into :NEW."id" from dual;
end;
/
)
/
-------------------
CREATE TABLE "cisu_usergroup" (
    "id" INT,
    "usergroup_name" VARCHAR2,
    constraint CISU_USERGROUP_PK PRIMARY KEY ("id")
CREATE sequence "CISU_USERGROUP_SEQ"
/
CREATE trigger "BI_CISU_USERGROUP"
  before insert on "CISU_USERGROUP"
  for each row
begin
  select "CISU_USERGROUP_SEQ".nextval into :NEW."id" from dual;
end;
/

)


