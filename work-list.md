Реализация задания. 
Поднято на локале создал базу данных

Реализация первого задания.
>>> Цытата: 1. Вы просили добавить фото категории - а в админке такой возможности нет.
Для добавления картинки нужно создать в таблице категорий ячейку для записи названия картики

* создаем папку хранения каринок для категорий
frontend/web/images/category


*В модели Category (backend) удалить подключения backend/models/Category, тоисть сомую себя

*rules добавил [['fileimg'], 'file'],

* Добавляемо метод uploadFile в Category

* создал модель CategoryImages по аналогии с ProductImages

* правим контролер

*  добавляем колонку в таблицу Category
ALTER TABLE `category` ADD `img` varchar(1000) NOT NULL AFTER `slug`



Изменить тип данных в таблице category поле description_en (ru, ua) на тип text
ALTER TABLE `category` CHANGE `description_ua` `description_ua` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `category` CHANGE `description_ru` `description_ru` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `category` CHANGE `description_en` `description_en` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;



