DROP DATABASE IF EXISTS task_force;
DROP USER IF EXISTS 'tf_admin'@'localhost';

CREATE DATABASE task_force;
USE task_force;

CREATE USER 'tf_admin'@'localhost' IDENTIFIED BY 'hf,)nf2O';
GRANT ALL PRIVILEGES ON task_force.* TO 'tf_admin'@'localhost' WITH GRANT OPTION;

CREATE TABLE categories (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  category varchar(255) NOT NULL UNIQUE,
  icon varchar(255) NOT NULL UNIQUE,
  PRIMARY KEY (id)
) AUTO_INCREMENT=1 DEFAULT CHARSET=UTF8;

CREATE TABLE cities (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  city varchar(255) NOT NULL,
  latitude double(10,7) DEFAULT NULL,
  longitude double(10,7) DEFAULT NULL,
  PRIMARY KEY (id)
) AUTO_INCREMENT=1 DEFAULT CHARSET=UTF8;

CREATE TABLE users (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  fio varchar(255) NOT NULL,
  email varchar(255) NOT NULL UNIQUE,
  pass varchar(255) NOT NULL,
  dt_add datetime DEFAULT SYSDATE(),
  role smallint(6) NOT NULL,
  address varchar(255) DEFAULT NULL,
  birthday date DEFAULT NULL,
  about text DEFAULT NULL,
  avatar varchar(255) DEFAULT NULL,
  phone varchar(255) DEFAULT NULL,
  skype varchar(255) DEFAULT NULL,
  telegram varchar(255) DEFAULT NULL,
  last_update datetime DEFAULT SYSDATE(),
  PRIMARY KEY (id),
  FULLTEXT(fio)
) AUTO_INCREMENT=1 DEFAULT CHARSET=UTF8;

CREATE TABLE tasks (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  idcustomer mediumint(9) NOT NULL,
  idexecuter mediumint(9) DEFAULT NULL,
  title varchar(255) NOT NULL,
  description text DEFAULT NULL,
  idcategory mediumint(9) NOT NULL,
  budget mediumint(9) DEFAULT NULL,
  dt_add datetime DEFAULT SYSDATE(),
  deadline datetime DEFAULT date_add(SYSDATE(), INTERVAL 30 DAY),
  current_status varchar(100) DEFAULT 'new',
  idcity mediumint(9) DEFAULT NULL,
  address varchar(255) DEFAULT NULL,
  latitude double(10,7) DEFAULT NULL,
  longitude double(10,7) DEFAULT NULL,
  PRIMARY KEY (id),
  CONSTRAINT tasks_ibfk_1 FOREIGN KEY (idcustomer) REFERENCES users (id),
  CONSTRAINT tasks_ibfk_2 FOREIGN KEY (idexecuter) REFERENCES users (id),
  CONSTRAINT tasks_ibfk_3 FOREIGN KEY (idcategory) REFERENCES categories (id),
  CONSTRAINT tasks_ibfk_4 FOREIGN KEY (idcity) REFERENCES cities (id),
  FULLTEXT(title)
) AUTO_INCREMENT=1 DEFAULT CHARSET=UTF8;

CREATE TABLE comments (
  idtask mediumint(9) NOT NULL,
  dt_add datetime DEFAULT SYSDATE(),
  rate smallint(2) DEFAULT NULL,
  notetext text DEFAULT NULL,
  CONSTRAINT comments_ibfk_1 FOREIGN KEY (idtask) REFERENCES tasks (id)
) DEFAULT CHARSET=UTF8;

CREATE TABLE executers_category (
  idexecuter mediumint(9) NOT NULL,
  idcategory mediumint(9) NOT NULL,
  CONSTRAINT executers_category_ibfk_1 FOREIGN KEY (idexecuter) REFERENCES users (id),
  CONSTRAINT executers_category_ibfk_2 FOREIGN KEY (idcategory) REFERENCES categories (id)
) DEFAULT CHARSET=UTF8;

CREATE TABLE feadback (
  idtask mediumint(9) NOT NULL,
  idexecuter mediumint(9) DEFAULT NULL,
  idcustomer mediumint(9) DEFAULT NULL,
  rate smallint(2) DEFAULT NULL,
  dt_add datetime DEFAULT SYSDATE(),
  description text DEFAULT NULL,
  CONSTRAINT feadback_ibfk_1 FOREIGN KEY (idtask) REFERENCES tasks (id),
  CONSTRAINT feadback_ibfk_2 FOREIGN KEY (idexecuter) REFERENCES users (id),
  CONSTRAINT feadback_ibfk_3 FOREIGN KEY (idcustomer) REFERENCES users (id)
) DEFAULT CHARSET=UTF8;

CREATE TABLE person_notice (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  key_name varchar(255) DEFAULT NULL,
  notice varchar(255) DEFAULT NULL,
  PRIMARY KEY (id)
) AUTO_INCREMENT=1 DEFAULT CHARSET=UTF8;

CREATE TABLE portfolio (
  idexecuter mediumint(9) NOT NULL,
  photo varchar(255) NOT NULL,
  CONSTRAINT portfolio_ibfk_1 FOREIGN KEY (idexecuter) REFERENCES users (id)
) DEFAULT CHARSET=UTF8;

CREATE TABLE responds (
  idtask mediumint(9) NOT NULL,
  idexecuter mediumint(9) DEFAULT NULL,
  dt_add datetime DEFAULT SYSDATE(),
  notetext text DEFAULT NULL,
  CONSTRAINT responds_ibfk_1 FOREIGN KEY (idtask) REFERENCES tasks (id),
  CONSTRAINT responds_ibfk_2 FOREIGN KEY (idexecuter) REFERENCES users (id)
) DEFAULT CHARSET=UTF8;

CREATE TABLE user_personality (
  iduser mediumint(9) NOT NULL,
  idnotice mediumint(9) NOT NULL,
  CONSTRAINT user_personality_ibfk_1 FOREIGN KEY (iduser) REFERENCES users (id),
  CONSTRAINT user_personality_ibfk_2 FOREIGN KEY (idnotice) REFERENCES person_notice (id)
) DEFAULT CHARSET=UTF8;

CREATE TABLE favorite (
  iduser mediumint(9) NOT NULL,
  idtask mediumint(9) DEFAULT NULL,
  idexecuter mediumint(9) DEFAULT NULL,
  CONSTRAINT favorite_ibfk_1 FOREIGN KEY (iduser) REFERENCES users (id),
  CONSTRAINT favorite_ibfk_2 FOREIGN KEY (idtask) REFERENCES tasks (id),
  CONSTRAINT favorite_ibfk_3 FOREIGN KEY (idexecuter) REFERENCES users (id)
) DEFAULT CHARSET=UTF8;

CREATE TABLE stored_files (
  idtask mediumint(9) NOT NULL,
  file_path mediumint(9) NOT NULL,
  CONSTRAINT stored_files_ibfk_1 FOREIGN KEY (idtask) REFERENCES tasks (id)
) DEFAULT CHARSET=utf8;
