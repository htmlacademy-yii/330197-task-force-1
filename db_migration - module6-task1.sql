/*Обновляем данные в таблтце tasks чтобы появились задачи без исполнителей. Для тестирования фильтра*/
UPDATE tasks
SET idexecuter = NULL
WHERE id IN(3,9);

/*Добавляем индекс к таблице tasks и users для полнотекстового поиска*/
ALTER TABLE users  
ADD FULLTEXT(fio);

ALTER TABLE tasks  
ADD FULLTEXT(title);

/*Для добавленичя данных в таблицу tasks данных без дубликатов, создаём временную таблицу*/
CREATE TABLE if not exists temp_tasks AS SELECT * FROM tasks;
DELETE FROM temp_tasks WHERE 1=1;

/*Для добавленичя данных в таблицу users данных без дубликатов, создаём временную таблицу*/
CREATE TABLE if not exists temp_users AS SELECT * FROM users;
DELETE FROM temp_users WHERE 1=1;

/*Добавляем задачу без привязки к географическому расположению*/
INSERT INTO temp_tasks (idcustomer, title, description, idcategory, budget, dt_add, deadline, current_status, idcity, address, latitude, longitude, file_1, file_2, file_3)
VALUES 
(2, 'Перевести войну и мир на клингонский', 'Значимость этих проблем настолько очевидна, что начало
                            повседневной работы по формированию позиции
                            требуют определения и уточнения позиций…', 1, 30000, DATE(SYSDATE()), '2021-05-15', 'new', NULL, NULL, NULL, NULL, NULL, NULL, NULL)
;

/*Добавляем задачу с датой добавления неделю назад и месяц назад*/
INSERT INTO temp_tasks (idcustomer, title, description, idcategory, budget, dt_add, deadline, current_status, idcity, address, latitude, longitude, file_1, file_2, file_3)
VALUES 
(6, 'Убраться в квартире после вписки', 'Значимость этих проблем настолько очевидна, что начало повседневной работы по формированию позиции требуют определения и уточнения позиций…', 2, 1000, DATE_ADD(SYSDATE(), INTERVAL -5 DAY), '2021-07-25', 'new', 920, NULL, 61.2539773, 73.3961726, NULL, NULL, NULL),
(8, 'Перевезти груз на новое место', 'Значимость этих проблем настолько очевидна, что начало повседневной работы по формированию позиции требуют определения и уточнения позиций…', 3, 1500, DATE_ADD(SYSDATE(), INTERVAL -25 DAY), '2021-08-30', 'new', 566, NULL, NULL, NULL, NULL, NULL, NULL);


/*Вставляем данные в таблицу tasks без дубликатов*/
INSERT INTO tasks (idcustomer, idexecuter, title, description, idcategory, budget, dt_add, deadline, current_status, idcity, address, latitude, longitude, file_1, file_2, file_3)
SELECT idcustomer, idexecuter, title, description, idcategory, budget, dt_add, deadline, current_status, idcity, address, latitude, longitude, file_1, file_2, file_3
FROM temp_tasks tt
WHERE NOT EXISTS (SELECT * FROM tasks t WHERE t.idcustomer = tt.idcustomer AND t.title = tt.title);

/*Добавляем нового исполнителя, который был на сайте меньше получаса назад*/
INSERT INTO temp_users (fio, email, pass, dt_add, role, address, birthday, about, avatar, phone, skype, telegram, last_update) VALUES
	('Андрей Балконский', 'andrew@bal.com', 'supperpass', '2017-02-10', 2, 'пер. Вишнёвый', '1970-03-11', 'Фотограф на все случаи жизни. Сделаю важные события в Вешей жизни незабываемыми.', 'user-man.jpg', '0947536548', 'andrew-balc', NULL, DATE_ADD(SYSDATE(), INTERVAL -5 MINUTE));

INSERT INTO users (fio, email, pass, dt_add, role, address, birthday, about, avatar, phone, skype, telegram, last_update)
SELECT fio, email, pass, dt_add, role, address, birthday, about, avatar, phone, skype, telegram, last_update
FROM temp_users tu
WHERE NOT EXISTS(SELECT * FROM users u WHERE u.email = tu.email);

INSERT INTO executers_category (idexecuter, idcategory)
VALUES (21, 8);

COMMIT;
