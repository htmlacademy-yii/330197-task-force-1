CREATE database if not exists task_force
default character set utf8
collate utf8_general_ci;

use task_force;

CREATE USER 'tf_admin'@'localhost' IDENTIFIED BY 'hf,)nf2O';
GRANT ALL PRIVILEGES ON task_force.* TO 'tf_admin'@'localhost' WITH GRANT OPTION;

CREATE OR REPLACE TABLE tasks (
  id MEDIUMINT NOT NULL AUTO_INCREMENT,
  idcustomer MEDIUMINT,
  idexecuter MEDIUMINT,
  title varchar(255),
  description text,
  idcategory MEDIUMINT,
  budget MEDIUMINT,
  dt_add date,
  deadline date,
  satatus varchar(100),
  idcity MEDIUMINT,
  address varchar(255),
  latitude DOUBLE PRECISION(10,7),
  longitude DOUBLE PRECISION(10,7),
  file_1 varchar(255),
  file_2 varchar(255),
  file_3 varchar(255),
  PRIMARY KEY (id)
) DEFAULT CHARSET=utf8;

CREATE OR REPLACE TABLE user_profile (
  iduser MEDIUMINT,
  address varchar(255),
  birthday date,
  about text,
  avatar varchar(255),
  phone varchar(255),
  skype varchar(255),
  telegram varchar(255)
) DEFAULT CHARSET=UTF8;

CREATE OR REPLACE TABLE users (
  id MEDIUMINT NOT NULL AUTO_INCREMENT,
  fio varchar(255),
  email varchar(255),
  pass varchar(255),
  dt_add DATE,
  PRIMARY KEY (id)
) DEFAULT CHARSET=utf8;

CREATE OR REPLACE TABLE person_notice (
  id MEDIUMINT NOT NULL AUTO_INCREMENT,
  key_name varchar(255),
  notice varchar(255),
  PRIMARY KEY (id)
) DEFAULT CHARSET=utf8;

CREATE OR REPLACE TABLE user_personality (
  iduser MEDIUMINT NOT NULL,
  idnotice MEDIUMINT NOT NULL
) DEFAULT CHARSET=utf8;

CREATE OR REPLACE TABLE categories (
  id MEDIUMINT NOT NULL AUTO_INCREMENT,
  category varchar(255),
  icon varchar(255),
  PRIMARY KEY (id)
) DEFAULT CHARSET=utf8;

CREATE OR REPLACE TABLE executers_category (
  idexecuter MEDIUMINT NOT NULL,
  idcategory MEDIUMINT NOT NULL
) DEFAULT CHARSET=utf8;

CREATE OR REPLACE TABLE responds (
  idtask MEDIUMINT NOT NULL,
  idexecuter MEDIUMINT,
  dt_add date,
  notetext text
) DEFAULT CHARSET=utf8;

CREATE OR REPLACE TABLE comments (
  idtask MEDIUMINT,
  dt_add DATE,
  rate SMALLINT(2),
  notetext text
) DEFAULT CHARSET=utf8;

CREATE OR REPLACE TABLE feadback (
  idtask MEDIUMINT,
  rate SMALLINT(2),
  dt_add DATE,
  description text
) DEFAULT CHARSET=utf8;

CREATE OR REPLACE TABLE portfolio (
  idexecuter MEDIUMINT,
  photo varchar(255)
) DEFAULT CHARSET=UTF8;

CREATE OR REPLACE TABLE cities (
  id MEDIUMINT NOT NULL AUTO_INCREMENT,
  city varchar(255),
  latitude DOUBLE PRECISION(10,7),
  longitude DOUBLE PRECISION(10,7),
  PRIMARY KEY (id)
) DEFAULT CHARSET=utf8;