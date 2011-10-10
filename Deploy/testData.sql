\encoding WIN1251

SET search_path TO shop,public;

INSERT INTO article_locations (name, title) VALUES ('companyInfo', 'Информация о компании');
INSERT INTO article_locations (name, title) VALUES ('importantInfo', 'Важная информация');
INSERT INTO article_locations (name, title) VALUES ('contactInfo', 'Контакты');
INSERT INTO article_locations (name, title) VALUES ('catalogTail', 'После каталога');
INSERT INTO article_locations (name, title) VALUES ('footerInfoLeft', '"Подвал" сайта (левая сторона)');
INSERT INTO article_locations (name, title) VALUES ('footerInfoRight', '"Подвал" сайта (правая сторона)');
INSERT INTO article_locations (name, title) VALUES ('wholesaleAddress', 'Адрес оптового склада (и расписание работы)');
INSERT INTO article_locations (name, title) VALUES ('retailAddress', 'Адрес розничного магазина (и расписание работы)');
INSERT INTO article_locations (name, title) VALUES ('paymentInfo', 'Информация по оплате');
INSERT INTO article_locations (name, title) VALUES ('catalogTop', 'Над каталогом');
INSERT INTO article_locations (name, title) VALUES ('kuibyshevAddress', 'Адрес филиала в г.Куйбышев (и расписание работы)');

INSERT INTO article_locations (name, title) VALUES ('registerWholesaleInfo', 'Регистрация оптового покупателя');
INSERT INTO article_locations (name, title) VALUES ('registerRetailInfo', 'Регистрация розничного покупателя');
INSERT INTO article_locations (name, title) VALUES ('registerTop', 'Информация выше формы регистрации');
INSERT INTO article_locations (name, title) VALUES ('registerBottom', 'Информация ниже формы регистрации');

INSERT INTO article_locations (name, title) VALUES ('orderCases', 'Соглашение о покупке');

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	1,
	'Информация о компании',
	'<b>ООО «Мир Рыбалки Охоты и Туризма»</b> - успешная и конкурентоспособная фирма.<br />
	На протяжении десяти лет получила огромнейший опыт в торговой и производственной деятельности,<br />
	которая позволяет обеспечивать надежность и удобство эксплуатации наших изделий.<br /><br />
	За время существования на рынке мы организовали розничный магазин ООО «Мир Рыбалки, Охоты, Туризма»<br />
	и создали швейный цех по производству одежды, рыболовных ящиков, охотничьих и рыболовных принадлежностей.<br /><br />
	<b>Наша фирма занимается оптовыми и розничными поставками товаров для отдыха, рыбалки, туризма.<br />
	А также предлагаем Вам широкий ассортимент товаров по низким ценам с возможностью выбора<br />
	товаров в сети интернет. Для этого на сайте есть каталог товаров и выложен прайс-лист продукции.</b>'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	2,
	'Кратко о нас',
	'<b>ООО «Мир Рыбалки Охоты и Туризма»</b> - успешная и конкурентоспособная фирма.<br />
	На протяжении десяти лет получила огромнейший опыт в торговой и производственной деятельности,
	которая позволяет обеспечивать надежность и удобство эксплуатации наших изделий.<br /><br />
	За время существования на рынке мы организовали розничный магазин ООО «Мир Рыбалки, Охоты, Туризма»
	и создали швейный цех по производству одежды, рыболовных ящиков, охотничьих и рыболовных принадлежностей.<br /><br />
	<b>Наша фирма занимается оптовыми и розничными поставками товаров для отдыха, рыбалки, туризма.
	А также предлагаем Вам широкий ассортимент товаров по низким ценам с возможностью выбора
	товаров в сети интернет. Для этого на сайте есть каталог товаров и выложен прайс-лист продукции.</b>'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	3,
	'Контактная информация',
	'<p>
		<h2>Наш оптовый мазагин</h2>
		<h3>г.Новосибирск, ул. Волочаевская 64</h3>
		<b>
			8 (383) 256 11 15<br />
			8 (383) 256 11 50<br />
			8 (383) 256 10 77 <br />
			8 (901) 451 27 37
		</b>
	</p>'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	4,
	'Способы доставки',
	'При доставке по городу Новосибирску все срок доставки составляет 2 дня.<br />
	Для доставки в отдаленный районы крайнего севера можно воспользоваться<br />
	услугами следующих транспортных компаний:<br />
	- первая транспортная<br />
	- емс<br />
	- транссервис'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	4,
	'Система скидок',
	'В каталоге указаны оптовые цены.<br />
	Они действуют только при покупке от 3000 тысяч.'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	4,
	'Система скидок',
	'В каталоге указаны оптовые цены.<br />
	Они действуют только при покупке от 3000 тысяч.'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	4,
	'Система скидок',
	'В каталоге указаны оптовые цены.<br />
	Они действуют только при покупке от 3000 тысяч.'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	4,
	'Система скидок',
	'В каталоге указаны оптовые цены.<br />
	Они действуют только при покупке от 3000 тысяч.'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	6,
	'Содержимое подвала',
	'<small>В случае возникновения проблем пишите на <a href="mailto:support@mir-ribalki-nsk.ru">support@mir-ribalki-nsk.ru</a><br />
	<b>© 2010-2011г. Мир Рыбалки, Охоты и Туризма.</b></small>'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	5,
	'Содержимое подвала',
	'<small>Мы используем полученную контактную информацию,	только для выполнения Вашего заказа.<br />
	Подробнее <a href="#">о нашей политике конфеденциальности</a>.</small>'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	7,
	'Адрес оптового магазина',
	'<h3>г.Новосибирск, ул.Волочаевская 64</h3><br />
	<b>Мы работаем с понедельника по пятницу с 7 до 16 часов<br />
	А в субботу с 7 до 14 часов</b>.'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	8,
	'Адрес розничного магазина',
	'<h3>г.Новосибирск, ул.Покрышкина 1</h3>
	<b>Мы работаем с понедельника по субботу с 10 до 19 часов</b>.'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	11,
	'Адрес магазина в г.Куйбышев',
	'<h3>НСО, г.Куйбышев Советская 8</h3>
	<b>Мы работаем с понедельника по субботу с 10 до 19 часов</b>.'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	9,
	'Условия оплаты',
	'<h3>Оплата при получении</h3>
	При покупке в городе Новосибирске.
	<h3>Оплата наложенным платежом</h3>
	При покупке наложенным платежом ...'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	10,
	'Информация о покупке',
	'<h3>Важная информация о покупке</h3>'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	12,
	'Регистрация оптового покупателя',
	'Оптовая закупка доступна для юридических лиц и ИП'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	13,
	'Регистрация розничного покупателя',
	'Розничная покупка для физических лиц'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	14,
	'Регистрация верх',
	'Доп. регистрационная информация'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	15,
	'Регистрация низ',
	'Доп. регистрационная информация'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	16,
	'Соглашение о покупке',
	'Соглашение о покупке'
);

/* Info pages */
INSERT INTO info_sections (title, order_no) VALUES ('Оптовикам', 2);
INSERT INTO info_sections (title, order_no) VALUES ('Доставка', 1);

INSERT INTO info_pages (title, info_section_id, order_no, content) VALUES ('Скидки оптовикам', 1, 1, 'Скидки оптовикам. Скидки оптовикам!');
INSERT INTO info_pages (title, info_section_id, order_no, content) VALUES ('Условия оптовых закупок', 1, 2, 'Условия оптовых закупок. Условия оптовых закупок!');
INSERT INTO info_pages (title, info_section_id, order_no, content) VALUES ('Доставка по г.Новосибирску', 2, 1, 'Доставка по г.Новосибирску. Доставка по г.Новосибирску!');
INSERT INTO info_pages (title, info_section_id, order_no, content) VALUES ('Доставка в другие регионы', 2, 2, 'Доставка в другие регионы. Доставка в другие регионы!');

/* Producers / Categories / Products */
INSERT INTO producers (title, image, short_description) VALUES ('Русский Лес', '20110806/logo1.jpg', 'Фирма Русский Лес');
INSERT INTO producers (title, image, short_description) VALUES ('China', '20110806/logo2.jpg', 'Made in Китай');
INSERT INTO producers (title, image, short_description) VALUES ('Russia', '20110806/logo3.jpg', 'Российская продукция');
INSERT INTO producers (title, image, short_description) VALUES ('Длинное название', '20110806/logo3.jpg', 'Фирма с очень очень очень очень очень очень очень очень очень очень очень очень очень очень длинным названием');

INSERT INTO categories (title, image, short_description, long_description, published) VALUES ('', '', '', '', 1);
INSERT INTO categories (title, image, short_description, long_description, published) VALUES ('Рыбалка', '', 'Товары для рыбалки', 'Товары для рыбалки: удочки и прочее', 1);
INSERT INTO categories (title, image, short_description, long_description, published) VALUES ('Удочки', '', 'Удочки', 'Удочки', 1);
INSERT INTO categories (title, image, short_description, long_description, published) VALUES ('Спининги', '', 'Спининги', 'Спининги', 0);
INSERT INTO categories (title, image, short_description, long_description, published) VALUES ('Одежда', '', 'Одежда', 'Одежда', 1);
INSERT INTO categories (title, image, short_description, long_description, published) VALUES ('Костюмы', '', 'Костюмы', 'Костюмы', 1);
INSERT INTO categories (title, image, short_description, long_description, published) VALUES ('Волк (цвет пихта)', '20110905/9927.jpg', 'Волк (цвет пихта)', 'Волк (цвет пихта)', 1);
INSERT INTO categories (title, image, short_description, long_description, published) VALUES ('Волк (дубовый лист)', '20110905/9927.jpg', 'Волк (дубовый лист)', 'Волк (дубовый лист)', 1);
INSERT INTO categories_tree (parent_category_id, category_id) VALUES (1, 2);
INSERT INTO categories_tree (parent_category_id, category_id) VALUES (2, 3);
INSERT INTO categories_tree (parent_category_id, category_id) VALUES (2, 4);
INSERT INTO categories_tree (parent_category_id, category_id) VALUES (1, 5);
INSERT INTO categories_tree (parent_category_id, category_id) VALUES (5, 6);
INSERT INTO categories_tree (parent_category_id, category_id) VALUES (6, 7);
INSERT INTO categories_tree (parent_category_id, category_id) VALUES (6, 8);

INSERT INTO products (category_id, producer_id, title, price_wholesale, article, short_description, long_description, published)
	VALUES (3, 1, 'Удочка #1 Русский Лес', 500, '1 000001', 'Удочка #1 Русский Лес', 'Удочка #1 Русский Лес', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, article, short_description, long_description, published)
	VALUES (3, 1, 'Удочка #2 Русский Лес', 650, '1 000002', 'Удочка #2 Русский Лес', 'Удочка #2 Русский Лес', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, article, short_description, long_description, published)
	VALUES (3, 1, 'Удочка #3 Русский Лес', 900, '1 000003', 'Удочка #3 Русский Лес', 'Удочка #3 Русский Лес', 0);
	
INSERT INTO products (category_id, producer_id, title, price_wholesale, article, short_description, long_description, published)
	VALUES (3, 2, 'Удочка #1 Китай', 200, '1 000004', 'Удочка #1 Китай', 'Удочка #1 Китай', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, article, short_description, long_description, published)
	VALUES (3, 2, 'Удочка #2 Китай', 300, '1 000005', 'Удочка #2 Китай', 'Удочка #2 Китай', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, article, short_description, long_description, published)
	VALUES (3, 2, 'Удочка #3 Китай', 400, '1 000006', 'Удочка #3 Китай', 'Удочка #3 Китай', 1);
	
INSERT INTO products (category_id, producer_id, title, price_wholesale, article, short_description, long_description, published)
	VALUES (4, 3, 'Спининг #1 Россия', 1200, '1 000007', 'Спининг #1 Россия', 'Спининг #1 Россия', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, article, short_description, long_description, published)
	VALUES (4, 3, 'Спининг #2 Россия', 1300, '1 000008', 'Спининг #2 Россия', 'Спининг #2 Россия', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, article, short_description, long_description, published)
	VALUES (4, 3, 'Спининг #3 Россия', 1400, '1 000009', 'Спининг #3 Россия', 'Спининг #3 Россия', 1);
	
INSERT INTO products (category_id, producer_id, title, price_wholesale, price_retail, article, short_description, long_description, published)
	VALUES (7, 1, 'Костюм волк', 1800, 2000, '4 020173', 'Костюм волк<br />размер 48, цвет пихта', 'Куртка, утепленная на шерстоне, в комплекте с п/комбинезоном. П/Комбинезон распашной на молнии. ', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, price_retail, article, short_description, long_description, published)
	VALUES (7, 1, 'Костюм волк', 1800, 2000, '4 020174', 'Костюм волк<br />размер 50, цвет пихта', 'Куртка, утепленная на шерстоне, в комплекте с п/комбинезоном. П/Комбинезон распашной на молнии. ', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, price_retail, article, short_description, long_description, published)
	VALUES (7, 1, 'Костюм волк', 1800, 2000, '4 020175', 'Костюм волк<br />размер 52, цвет пихта', 'Куртка, утепленная на шерстоне, в комплекте с п/комбинезоном. П/Комбинезон распашной на молнии. ', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, price_retail, article, short_description, long_description, published)
	VALUES (7, 1, 'Костюм волк', 1800, 2000, '4 020176', 'Костюм волк<br />размер 54, цвет пихта', 'Куртка, утепленная на шерстоне, в комплекте с п/комбинезоном. П/Комбинезон распашной на молнии. ', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, price_retail, article, short_description, long_description, published)
	VALUES (7, 1, 'Костюм волк', 1800, 2000, '4 020177', 'Костюм волк<br />размер 56, цвет пихта', 'Куртка, утепленная на шерстоне, в комплекте с п/комбинезоном. П/Комбинезон распашной на молнии. ', 1);
	
INSERT INTO products (category_id, producer_id, title, price_wholesale, price_retail, article, short_description, long_description, published)
	VALUES (8, 1, 'Костюм волк', 1800, 2000, '4 020183', 'Костюм волк<br />размер 52, дубовый лист', 'Куртка, утепленная на шерстоне, в комплекте с п/комбинезоном. П/Комбинезон распашной на молнии. ', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, price_retail, article, short_description, long_description, published)
	VALUES (8, 1, 'Костюм волк', 1800, 2000, '4 020184', 'Костюм волк<br />размер 54, дубовый лист', 'Куртка, утепленная на шерстоне, в комплекте с п/комбинезоном. П/Комбинезон распашной на молнии. ', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, price_retail, article, short_description, long_description, published)
	VALUES (8, 1, 'Костюм волк', 1800, 2000, '4 020185', 'Костюм волк<br />размер 56, дубовый лист', 'Куртка, утепленная на шерстоне, в комплекте с п/комбинезоном. П/Комбинезон распашной на молнии. ', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, price_retail, article, short_description, long_description, published)
	VALUES (8, 1, 'Костюм волк', 1800, 2000, '4 020186', 'Костюм волк<br />размер 58, дубовый лист', 'Куртка, утепленная на шерстоне, в комплекте с п/комбинезоном. П/Комбинезон распашной на молнии. ', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, price_retail, article, short_description, long_description, published)
	VALUES (8, 1, 'Костюм волк', 1800, 2000, '4 020187', 'Костюм волк<br />размер 60, дубовый лист', 'Куртка, утепленная на шерстоне, в комплекте с п/комбинезоном. П/Комбинезон распашной на молнии. ', 1);

INSERT INTO product_images (product_id, image_url)
	VALUES (10, '20110905/9927.jpg'), (10, '20110905/IMG_9913_copy.jpg'), (10, '20110905/encefalitka_palatka_setka_big.jpg');
INSERT INTO product_images (product_id, image_url)
	VALUES (11, '20110905/9927.jpg'), (11, '20110905/IMG_9913_copy.jpg'), (11, '20110905/encefalitka_palatka_setka_big.jpg');
INSERT INTO product_images (product_id, image_url)
	VALUES (12, '20110905/9927.jpg'), (12, '20110905/IMG_9913_copy.jpg'), (12, '20110905/encefalitka_palatka_setka_big.jpg');
INSERT INTO product_images (product_id, image_url)
	VALUES (13, '20110905/9927.jpg'), (13, '20110905/IMG_9913_copy.jpg'), (13, '20110905/encefalitka_palatka_setka_big.jpg');
INSERT INTO product_images (product_id, image_url)
	VALUES (14, '20110905/9927.jpg'), (14, '20110905/IMG_9913_copy.jpg'), (14, '20110905/encefalitka_palatka_setka_big.jpg');
	
INSERT INTO product_images (product_id, image_url)
	VALUES (15, '20110905/9927.jpg'), (15, '20110905/IMG_9913_copy.jpg'), (15, '20110905/encefalitka_palatka_setka_big.jpg');
INSERT INTO product_images (product_id, image_url)
	VALUES (16, '20110905/9927.jpg'), (16, '20110905/IMG_9913_copy.jpg'), (16, '20110905/encefalitka_palatka_setka_big.jpg');
INSERT INTO product_images (product_id, image_url)
	VALUES (17, '20110905/9927.jpg'), (17, '20110905/IMG_9913_copy.jpg'), (17, '20110905/encefalitka_palatka_setka_big.jpg');
INSERT INTO product_images (product_id, image_url)
	VALUES (18, '20110905/9927.jpg'), (18, '20110905/IMG_9913_copy.jpg'), (18, '20110905/encefalitka_palatka_setka_big.jpg');
INSERT INTO product_images (product_id, image_url)
	VALUES (19, '20110905/9927.jpg'), (19, '20110905/IMG_9913_copy.jpg'), (19, '20110905/encefalitka_palatka_setka_big.jpg');
	
/* Discounts */
INSERT INTO discounts (precent, range_begin, range_end, type) VALUES (0, 0, 3000, 1);
INSERT INTO discounts (precent, range_begin, range_end, type) VALUES (1, 3000, 5000, 1);
INSERT INTO discounts (precent, range_begin, range_end, type) VALUES (2, 5000, 10000, 1);
INSERT INTO discounts (precent, range_begin, range_end, type) VALUES (3, 10000, 15000, 1);
INSERT INTO discounts (precent, range_begin, range_end, type) VALUES (5, 15000, 100000, 1);

INSERT INTO discounts (precent, range_begin, range_end, type) VALUES (0, 0, 3000, 2);
INSERT INTO discounts (precent, range_begin, range_end, type) VALUES (4, 3000, 5000, 2);
INSERT INTO discounts (precent, range_begin, range_end, type) VALUES (7, 5000, 10000, 2);
INSERT INTO discounts (precent, range_begin, range_end, type) VALUES (9, 10000, 15000, 2);
INSERT INTO discounts (precent, range_begin, range_end, type) VALUES (15, 15000, 100000, 2);

/* Ads */
INSERT INTO ads (name, content, from_date, to_date) VALUES ('Распродажа к 1 сентября', 'Ура, у нас распродажа к 1 сентября!', '2011-08-01', '2011-09-05');
INSERT INTO ads (name, content, from_date, to_date) VALUES ('Распродажа к 2 сентября', 'Ура, у нас распродажа к 2 сентября!', '2011-08-01', '2011-09-05');
INSERT INTO ads (name, content, from_date, to_date) VALUES ('Распродажа к 1 сентября', 'Ура, у нас распродажа к 1 сентября!', '2011-08-29', '2011-09-05');
INSERT INTO ads (name, content, from_date, to_date) VALUES ('Новогодняя распродажа', 'Ура, у нас новогодняя распродажа!', '2011-12-01', '2011-12-20');

/* Users */
INSERT INTO managers (login, password, access_rights) VALUES ('mrot154', 'a78f907fb4f8d22d59fa1aa0833154c9', 4);

/* Clients */
INSERT INTO clients (login, organization_type, last_visit, registered, phone, name) VALUES ('ivan@mail.ru', 1, '2011-08-10', '2011-01-01', '8-913-777-77-77', 'Иванов Семен Степанович');
INSERT INTO clients (login, organization_type, last_visit, registered, phone, name) VALUES ('semenov@mail.ru', 2, '2011-08-10', '2011-01-01', '8-913-1111-11-11', 'Семенов Иван Степанович');
INSERT INTO clients (login, organization_type, last_visit, registered, phone, name) VALUES ('stepka76@mail.ru', 3, '2011-08-10', '2011-01-01', '8-913-333-33-33', 'Семенов Степан Иванович');

/* Cart */
INSERT INTO cart_order_status (title) VALUES ('Проведение платежа'), ('Оплачен'), ('Комплектуется'), ('Отправлен');