--Create Data Base 
CREATE database if not exists task_force
default character set utf8
collate utf8_general_ci;

use task_force;

CREATE TABLE task (
  id int(100) NOT NULL,
  idcustomer int(100),
  idexecuter int(100),
  title varchar(255),
  description text,
  idcategory int(100),
  budget int(100),
  date_open date,
  deadline date,
  satatus varchar(100),
  city varchar(100),
  latitude int(255),
  longitude int(255),
  file_1 varchar(255),
  file_2 varchar(255),
  file_3 varchar(255)
) DEFAULT CHARSET=utf8;

CREATE TABLE users (
  id int(100) NOT NULL,
  fio varchar(255),
  email varchar(255),
  city varchar(255),
  password varchar(255),
  birthday date,
  aboutme text,
  avatar varchar(255),
  phone varchar(255),
  skype varchar(255),
  telegram varchar(255)
) DEFAULT CHARSET=utf8;

CREATE TABLE person_notice (
  id int(100) NOT NULL,
  key_name varchar(255),
  notice varchar(255)
) DEFAULT CHARSET=utf8;

CREATE TABLE user_personality (
  iduser int(100) NOT NULL,
  idnotice int(100) NOT NULL
) DEFAULT CHARSET=utf8;

CREATE TABLE categories (
  id int(100) NOT NULL,
  category varchar(255)
) DEFAULT CHARSET=utf8;

CREATE TABLE executers_category (
  idexecuter int(100) NOT NULL,
  idcategory int(100) NOT NULL
) DEFAULT CHARSET=utf8;

CREATE TABLE responds (
  idtask int(100) NOT NULL,
  idcustomer int(100),
  idexecuter int(100),
  date_respond int(100),
  notetext text
) DEFAULT CHARSET=utf8;

CREATE TABLE comments (
  idtask int(100) NOT NULL,
  idcustomer int(100),
  idexecuter int(100),
  date_create int(100),
  notetext text
) DEFAULT CHARSET=utf8;

CREATE TABLE feadback (
  idtask int(100) NOT NULL,
  idcustomer int(100),
  idexecuter int(100),
  rate int(10),
  date_create int(100),
  comment text
) DEFAULT CHARSET=utf8;

CREATE TABLE portfolio (
  idexecuter int(100),
  photo varchar(255)
) DEFAULT CHARSET=utf8;