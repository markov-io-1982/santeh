���������� �������. 
������� �� ������ ������ ���� ������

���������� ������� �������.
>>> ������: 1. �� ������� �������� ���� ��������� - � � ������� ����� ����������� ���.
��� ���������� �������� ����� ������� � ������� ��������� ������ ��� ������ �������� �������

* ������� ����� �������� ������� ��� ���������
frontend/web/images/category


*� ������ Category (backend) ������� ����������� backend/models/Category, ������ ����� ����

*rules ������� [['fileimg'], 'file'],

* ���������� ����� uploadFile � Category

* ������ ������ CategoryImages �� �������� � ProductImages

* ������ ���������

*  ��������� ������� � ������� Category
ALTER TABLE `category` ADD `img` varchar(1000) NOT NULL AFTER `slug`



�������� ��� ������ � ������� category ���� description_en (ru, ua) �� ��� text
ALTER TABLE `category` CHANGE `description_ua` `description_ua` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `category` CHANGE `description_ru` `description_ru` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `category` CHANGE `description_en` `description_en` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;



