---------НОВОСТИ------------------------------------------------------------

drop trigger LOG_NEWS

CREATE or replace trigger LOG_NEWS
  after insert on news
  for each row
begin
  Insert into logs (ID_ACTION, ID_USER, DATE_ACTION, LOG_COMMENT)
  VALUES (1,9129393664, sysdate,'Добавлена: '||:new.NAME_NEWS);
end;




---------------------------------------------------------------------------
DROP table NEWS
/
Create table NEWS(
ID number,
NAME_NEWS varchar2(4000),
DATE_NEWS DATE,
TEXT_NEWS VARCHAR2(4000),
TEXT_NEWS2 VARCHAR2(4000),
TEXT_NEWS3 VARCHAR2(4000),
TEXT_NEWS4 VARCHAR2(4000),
IMG_NEWS VARCHAR2(4000),
PREV_NEWS VARCHAR2(4000),
PREV_IMG_NEWS VARCHAR2(4000),
SOURCE_NEWS VARCHAR2(4000)
)
----------------------------------------------------------------------------------
truncate table bad_news_links
/
truncate table logs
/
truncate table news
/
Drop sequence NEWS_SEQ
/
Create sequence NEWS_SEQ
/
/
Drop sequence bad_news_links_seq
/
Create sequence bad_news_links_seq
/
Drop sequence continue_news_links_seq
/
Create sequence continue_news_links_seq
/
drop sequence logs_seq
/
create sequence logs_seq




------------------------------------------------------------------------------------------
CREATE trigger BI_NEWS
  before insert on NEWS
  for each row
begin
  select NEWS_SEQ.nextval into :NEW.id from dual;
end;

-------------------------------------- объединение новостей
CREATE VIEW NEWS_INFO AS
SELECT id,NAME_NEWS,DATE_NEWS, TEXT_NEWS ||TEXT_NEWS2 || TEXT_NEWS3 || TEXT_NEWS4 AS TEXT_NEWS,IMG_NEWS,PREV_NEWS,PREV_IMG_NEWS,SOURCE_NEWS
FROM NEWS

CREATE TRIGGER NEWS_I
instead OF INSERT ON NEWS_INFO
FOR each ROW
BEGIN
  INSERT INTO NEWS ( TEXT_NEWS, TEXT_NEWS2, TEXT_NEWS3,TEXT_NEWS4)
  VALUES (substr(:NEW.NEWS,0,4000), substr(:NEW.NEWS, 4000,4000), substr(:NEW.NEWS, 8000,4000), substr(:NEW.NEWS, 12000,4000));
END;

------------------------------------------------------------
Create or replace procedure INSERT_NEWS
(

NAME_NEWS NEWS.name_news%TYPE,
DATE_NEWS NEWS.date_news%TYPE,
TEXT_NEWS NEWS.TEXT_NEWS%TYPE,
TEXT_NEWS2 NEWS.TEXT_NEWS2%TYPE,
TEXT_NEWS3 NEWS.TEXT_NEWS3%TYPE,
TEXT_NEWS4 NEWS.TEXT_NEWS4%TYPE,
IMG_NEWS NEWS.img_news%TYPE,
PREV_NEWS NEWS.PREV_NEWS%TYPE,
PREV_IMG_NEWS NEWS.PREV_IMG_NEWS%TYPE,
SOURCE_NEWS NEWS.SOURCE_NEWS%TYPE)as
BEGIN
INSERT INTO NEWS (NAME_NEWS,DATE_NEWS,TEXT_NEWS,TEXT_NEWS2,TEXT_NEWS3,TEXT_NEWS4,IMG_NEWS,PREV_NEWS,PREV_IMG_NEWS,SOURCE_NEWS)
values (NAME_NEWS,DATE_NEWS,TEXT_NEWS,TEXT_NEWS2,TEXT_NEWS3,TEXT_NEWS4,IMG_NEWS,PREV_NEWS,PREV_IMG_NEWS,SOURCE_NEWS);
commit;
end;

-----------------
Drop sequence USERS_SEQ
/
Create sequence USERS_SEQ
/

