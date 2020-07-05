DROP DATABASE IF EXISTS task_force;
DROP USER IF EXISTS 'tf_admin'@'localhost';

CREATE DATABASE IF NOT EXISTS task_force;
USE task_force;

CREATE USER 'tf_admin'@'localhost' IDENTIFIED BY 'hf,)nf2O';
GRANT ALL PRIVILEGES ON task_force.* TO 'tf_admin'@'localhost' WITH GRANT OPTION;

CREATE TABLE IF NOT EXISTS categories (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  category varchar(255) DEFAULT NULL,
  icon varchar(255) DEFAULT NULL,
  PRIMARY KEY (id)
) AUTO_INCREMENT=9 DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS cities (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  city varchar(255) DEFAULT NULL,
  latitude double(10,7) DEFAULT NULL,
  longitude double(10,7) DEFAULT NULL,
  PRIMARY KEY (id)
) AUTO_INCREMENT=1109 DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS users (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  fio varchar(255) DEFAULT NULL,
  email varchar(255) DEFAULT NULL,
  pass varchar(255) DEFAULT NULL,
  dt_add date DEFAULT NULL,
  role smallint(6) DEFAULT NULL,
  address varchar(255) DEFAULT NULL,
  birthday date DEFAULT NULL,
  about text DEFAULT NULL,
  avatar varchar(255) DEFAULT NULL,
  phone varchar(255) DEFAULT NULL,
  skype varchar(255) DEFAULT NULL,
  telegram varchar(255) DEFAULT NULL,
  last_update datetime DEFAULT NULL,
  PRIMARY KEY (id),
  FULLTEXT(fio)
) AUTO_INCREMENT=21 DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS tasks (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  idcustomer mediumint(9) DEFAULT NULL,
  idexecuter mediumint(9) DEFAULT NULL,
  title varchar(255) DEFAULT NULL,
  description text DEFAULT NULL,
  idcategory mediumint(9) DEFAULT NULL,
  budget mediumint(9) DEFAULT NULL,
  dt_add date DEFAULT NULL,
  deadline date DEFAULT NULL,
  current_status varchar(100) DEFAULT NULL,
  idcity mediumint(9) DEFAULT NULL,
  address varchar(255) DEFAULT NULL,
  latitude double(10,7) DEFAULT NULL,
  longitude double(10,7) DEFAULT NULL,
  file_1 varchar(255) DEFAULT NULL,
  file_2 varchar(255) DEFAULT NULL,
  file_3 varchar(255) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY idcustomer (idcustomer),
  KEY idexecuter (idexecuter),
  KEY idcategory (idcategory),
  KEY idcity (idcity),
  CONSTRAINT tasks_ibfk_1 FOREIGN KEY (idcustomer) REFERENCES users (id),
  CONSTRAINT tasks_ibfk_2 FOREIGN KEY (idexecuter) REFERENCES users (id),
  CONSTRAINT tasks_ibfk_3 FOREIGN KEY (idcategory) REFERENCES categories (id),
  CONSTRAINT tasks_ibfk_4 FOREIGN KEY (idcity) REFERENCES cities (id),
  FULLTEXT(title)
) AUTO_INCREMENT=11 DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS comments (
  idtask mediumint(9) DEFAULT NULL,
  dt_add date DEFAULT NULL,
  rate smallint(2) DEFAULT NULL,
  notetext text DEFAULT NULL,
  KEY idtask (idtask),
  CONSTRAINT comments_ibfk_1 FOREIGN KEY (idtask) REFERENCES tasks (id)
) DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS executers_category (
  idexecuter mediumint(9) NOT NULL,
  idcategory mediumint(9) NOT NULL,
  KEY idexecuter (idexecuter),
  KEY idcategory (idcategory),
  CONSTRAINT executers_category_ibfk_1 FOREIGN KEY (idexecuter) REFERENCES users (id),
  CONSTRAINT executers_category_ibfk_2 FOREIGN KEY (idcategory) REFERENCES categories (id)
) DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS feadback (
  idtask mediumint(9) DEFAULT NULL,
  idexecuter mediumint(9) DEFAULT NULL,
  idcustomer mediumint(9) DEFAULT NULL,
  rate smallint(2) DEFAULT NULL,
  dt_add date DEFAULT NULL,
  description text DEFAULT NULL,
  KEY idtask (idtask),
  KEY idexecuter (idexecuter),
  KEY idcustomer (idcustomer),
  CONSTRAINT feadback_ibfk_1 FOREIGN KEY (idtask) REFERENCES tasks (id),
  CONSTRAINT feadback_ibfk_2 FOREIGN KEY (idexecuter) REFERENCES users (id),
  CONSTRAINT feadback_ibfk_3 FOREIGN KEY (idcustomer) REFERENCES users (id)
) DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS person_notice (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  key_name varchar(255) DEFAULT NULL,
  notice varchar(255) DEFAULT NULL,
  PRIMARY KEY (id)
) AUTO_INCREMENT=6 DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS portfolio (
  idexecuter mediumint(9) DEFAULT NULL,
  photo varchar(255) DEFAULT NULL,
  KEY idexecuter (idexecuter),
  CONSTRAINT portfolio_ibfk_1 FOREIGN KEY (idexecuter) REFERENCES users (id)
) DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS responds (
  idtask mediumint(9) NOT NULL,
  idexecuter mediumint(9) DEFAULT NULL,
  dt_add date DEFAULT NULL,
  notetext text DEFAULT NULL,
  KEY idtask (idtask),
  KEY idexecuter (idexecuter),
  CONSTRAINT responds_ibfk_1 FOREIGN KEY (idtask) REFERENCES tasks (id),
  CONSTRAINT responds_ibfk_2 FOREIGN KEY (idexecuter) REFERENCES users (id)
) DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS user_personality (
  iduser mediumint(9) NOT NULL,
  idnotice mediumint(9) NOT NULL,
  KEY iduser (iduser),
  KEY idnotice (idnotice),
  CONSTRAINT user_personality_ibfk_1 FOREIGN KEY (iduser) REFERENCES users (id),
  CONSTRAINT user_personality_ibfk_2 FOREIGN KEY (idnotice) REFERENCES person_notice (id)
) DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS favorite (
  iduser mediumint(9) NOT NULL,
  idtask mediumint(9) DEFAULT NULL,
  idexecuter mediumint(9) DEFAULT NULL,
  KEY iduser (iduser),
  KEY idtask (idtask),
  KEY idexecuter (idexecuter),
  CONSTRAINT favorite_ibfk_1 FOREIGN KEY (iduser) REFERENCES users (id),
  CONSTRAINT favorite_ibfk_2 FOREIGN KEY (idtask) REFERENCES tasks (id),
  CONSTRAINT favorite_ibfk_3 FOREIGN KEY (idexecuter) REFERENCES users (id)
) DEFAULT CHARSET=utf8;