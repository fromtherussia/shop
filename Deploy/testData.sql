\encoding WIN1251

SET search_path TO shop,public;

INSERT INTO article_locations (name, title) VALUES ('companyInfo', '���������� � ��������');
INSERT INTO article_locations (name, title) VALUES ('importantInfo', '������ ����������');
INSERT INTO article_locations (name, title) VALUES ('contactInfo', '��������');
INSERT INTO article_locations (name, title) VALUES ('catalogTail', '����� ��������');
INSERT INTO article_locations (name, title) VALUES ('footerInfoLeft', '"������" ����� (����� �������)');
INSERT INTO article_locations (name, title) VALUES ('footerInfoRight', '"������" ����� (������ �������)');
INSERT INTO article_locations (name, title) VALUES ('wholesaleAddress', '����� �������� ������ (� ���������� ������)');
INSERT INTO article_locations (name, title) VALUES ('retailAddress', '����� ���������� �������� (� ���������� ������)');
INSERT INTO article_locations (name, title) VALUES ('paymentInfo', '���������� �� ������');
INSERT INTO article_locations (name, title) VALUES ('catalogTop', '��� ���������');
INSERT INTO article_locations (name, title) VALUES ('kuibyshevAddress', '����� ������� � �.�������� (� ���������� ������)');

INSERT INTO article_locations (name, title) VALUES ('registerWholesaleInfo', '����������� �������� ����������');
INSERT INTO article_locations (name, title) VALUES ('registerRetailInfo', '����������� ���������� ����������');
INSERT INTO article_locations (name, title) VALUES ('registerTop', '���������� ���� ����� �����������');
INSERT INTO article_locations (name, title) VALUES ('registerBottom', '���������� ���� ����� �����������');

INSERT INTO article_locations (name, title) VALUES ('orderCases', '���������� � �������');

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	1,
	'���������� � ��������',
	'<b>��� ���� ������� ����� � �������</b> - �������� � ������������������� �����.<br />
	�� ���������� ������ ��� �������� ����������� ���� � �������� � ���������������� ������������,<br />
	������� ��������� ������������ ���������� � �������� ������������ ����� �������.<br /><br />
	�� ����� ������������� �� ����� �� ������������ ��������� ������� ��� ���� �������, �����, �������<br />
	� ������� ������� ��� �� ������������ ������, ���������� ������, ���������� � ���������� ���������������.<br /><br />
	<b>���� ����� ���������� �������� � ���������� ���������� ������� ��� ������, �������, �������.<br />
	� ����� ���������� ��� ������� ����������� ������� �� ������ ����� � ������������ ������<br />
	������� � ���� ��������. ��� ����� �� ����� ���� ������� ������� � ������� �����-���� ���������.</b>'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	2,
	'������ � ���',
	'<b>��� ���� ������� ����� � �������</b> - �������� � ������������������� �����.<br />
	�� ���������� ������ ��� �������� ����������� ���� � �������� � ���������������� ������������,
	������� ��������� ������������ ���������� � �������� ������������ ����� �������.<br /><br />
	�� ����� ������������� �� ����� �� ������������ ��������� ������� ��� ���� �������, �����, �������
	� ������� ������� ��� �� ������������ ������, ���������� ������, ���������� � ���������� ���������������.<br /><br />
	<b>���� ����� ���������� �������� � ���������� ���������� ������� ��� ������, �������, �������.
	� ����� ���������� ��� ������� ����������� ������� �� ������ ����� � ������������ ������
	������� � ���� ��������. ��� ����� �� ����� ���� ������� ������� � ������� �����-���� ���������.</b>'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	3,
	'���������� ����������',
	'<p>
		<h2>��� ������� �������</h2>
		<h3>�.�����������, ��. ������������ 64</h3>
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
	'������� ��������',
	'��� �������� �� ������ ������������ ��� ���� �������� ���������� 2 ���.<br />
	��� �������� � ���������� ������ �������� ������ ����� ���������������<br />
	�������� ��������� ������������ ��������:<br />
	- ������ ������������<br />
	- ���<br />
	- �����������'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	4,
	'������� ������',
	'� �������� ������� ������� ����.<br />
	��� ��������� ������ ��� ������� �� 3000 �����.'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	4,
	'������� ������',
	'� �������� ������� ������� ����.<br />
	��� ��������� ������ ��� ������� �� 3000 �����.'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	4,
	'������� ������',
	'� �������� ������� ������� ����.<br />
	��� ��������� ������ ��� ������� �� 3000 �����.'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	4,
	'������� ������',
	'� �������� ������� ������� ����.<br />
	��� ��������� ������ ��� ������� �� 3000 �����.'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	6,
	'���������� �������',
	'<small>� ������ ������������� ������� ������ �� <a href="mailto:support@mir-ribalki-nsk.ru">support@mir-ribalki-nsk.ru</a><br />
	<b>� 2010-2011�. ��� �������, ����� � �������.</b></small>'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	5,
	'���������� �������',
	'<small>�� ���������� ���������� ���������� ����������,	������ ��� ���������� ������ ������.<br />
	��������� <a href="#">� ����� �������� ������������������</a>.</small>'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	7,
	'����� �������� ��������',
	'<h3>�.�����������, ��.������������ 64</h3><br />
	<b>�� �������� � ������������ �� ������� � 7 �� 16 �����<br />
	� � ������� � 7 �� 14 �����</b>.'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	8,
	'����� ���������� ��������',
	'<h3>�.�����������, ��.���������� 1</h3>
	<b>�� �������� � ������������ �� ������� � 10 �� 19 �����</b>.'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	11,
	'����� �������� � �.��������',
	'<h3>���, �.�������� ��������� 8</h3>
	<b>�� �������� � ������������ �� ������� � 10 �� 19 �����</b>.'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	9,
	'������� ������',
	'<h3>������ ��� ���������</h3>
	��� ������� � ������ ������������.
	<h3>������ ���������� ��������</h3>
	��� ������� ���������� �������� ...'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	10,
	'���������� � �������',
	'<h3>������ ���������� � �������</h3>'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	12,
	'����������� �������� ����������',
	'������� ������� �������� ��� ����������� ��� � ��'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	13,
	'����������� ���������� ����������',
	'��������� ������� ��� ���������� ���'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	14,
	'����������� ����',
	'���. ��������������� ����������'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	15,
	'����������� ���',
	'���. ��������������� ����������'
);

INSERT INTO named_articles (article_location_id, name, content) VALUES (
	16,
	'���������� � �������',
	'���������� � �������'
);

/* Info pages */
INSERT INTO info_sections (title, order_no) VALUES ('���������', 2);
INSERT INTO info_sections (title, order_no) VALUES ('��������', 1);

INSERT INTO info_pages (title, info_section_id, order_no, content) VALUES ('������ ���������', 1, 1, '������ ���������. ������ ���������!');
INSERT INTO info_pages (title, info_section_id, order_no, content) VALUES ('������� ������� �������', 1, 2, '������� ������� �������. ������� ������� �������!');
INSERT INTO info_pages (title, info_section_id, order_no, content) VALUES ('�������� �� �.������������', 2, 1, '�������� �� �.������������. �������� �� �.������������!');
INSERT INTO info_pages (title, info_section_id, order_no, content) VALUES ('�������� � ������ �������', 2, 2, '�������� � ������ �������. �������� � ������ �������!');

/* Producers / Categories / Products */
INSERT INTO producers (title, image, short_description) VALUES ('������� ���', '20110806/logo1.jpg', '����� ������� ���');
INSERT INTO producers (title, image, short_description) VALUES ('China', '20110806/logo2.jpg', 'Made in �����');
INSERT INTO producers (title, image, short_description) VALUES ('Russia', '20110806/logo3.jpg', '���������� ���������');
INSERT INTO producers (title, image, short_description) VALUES ('������� ��������', '20110806/logo3.jpg', '����� � ����� ����� ����� ����� ����� ����� ����� ����� ����� ����� ����� ����� ����� ����� ������� ���������');

INSERT INTO categories (title, image, short_description, long_description, published) VALUES ('', '', '', '', 1);
INSERT INTO categories (title, image, short_description, long_description, published) VALUES ('�������', '', '������ ��� �������', '������ ��� �������: ������ � ������', 1);
INSERT INTO categories (title, image, short_description, long_description, published) VALUES ('������', '', '������', '������', 1);
INSERT INTO categories (title, image, short_description, long_description, published) VALUES ('��������', '', '��������', '��������', 0);
INSERT INTO categories (title, image, short_description, long_description, published) VALUES ('������', '', '������', '������', 1);
INSERT INTO categories (title, image, short_description, long_description, published) VALUES ('�������', '', '�������', '�������', 1);
INSERT INTO categories (title, image, short_description, long_description, published) VALUES ('���� (���� �����)', '20110905/9927.jpg', '���� (���� �����)', '���� (���� �����)', 1);
INSERT INTO categories (title, image, short_description, long_description, published) VALUES ('���� (������� ����)', '20110905/9927.jpg', '���� (������� ����)', '���� (������� ����)', 1);
INSERT INTO categories_tree (parent_category_id, category_id) VALUES (1, 2);
INSERT INTO categories_tree (parent_category_id, category_id) VALUES (2, 3);
INSERT INTO categories_tree (parent_category_id, category_id) VALUES (2, 4);
INSERT INTO categories_tree (parent_category_id, category_id) VALUES (1, 5);
INSERT INTO categories_tree (parent_category_id, category_id) VALUES (5, 6);
INSERT INTO categories_tree (parent_category_id, category_id) VALUES (6, 7);
INSERT INTO categories_tree (parent_category_id, category_id) VALUES (6, 8);

INSERT INTO products (category_id, producer_id, title, price_wholesale, article, short_description, long_description, published)
	VALUES (3, 1, '������ #1 ������� ���', 500, '1 000001', '������ #1 ������� ���', '������ #1 ������� ���', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, article, short_description, long_description, published)
	VALUES (3, 1, '������ #2 ������� ���', 650, '1 000002', '������ #2 ������� ���', '������ #2 ������� ���', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, article, short_description, long_description, published)
	VALUES (3, 1, '������ #3 ������� ���', 900, '1 000003', '������ #3 ������� ���', '������ #3 ������� ���', 0);
	
INSERT INTO products (category_id, producer_id, title, price_wholesale, article, short_description, long_description, published)
	VALUES (3, 2, '������ #1 �����', 200, '1 000004', '������ #1 �����', '������ #1 �����', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, article, short_description, long_description, published)
	VALUES (3, 2, '������ #2 �����', 300, '1 000005', '������ #2 �����', '������ #2 �����', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, article, short_description, long_description, published)
	VALUES (3, 2, '������ #3 �����', 400, '1 000006', '������ #3 �����', '������ #3 �����', 1);
	
INSERT INTO products (category_id, producer_id, title, price_wholesale, article, short_description, long_description, published)
	VALUES (4, 3, '������� #1 ������', 1200, '1 000007', '������� #1 ������', '������� #1 ������', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, article, short_description, long_description, published)
	VALUES (4, 3, '������� #2 ������', 1300, '1 000008', '������� #2 ������', '������� #2 ������', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, article, short_description, long_description, published)
	VALUES (4, 3, '������� #3 ������', 1400, '1 000009', '������� #3 ������', '������� #3 ������', 1);
	
INSERT INTO products (category_id, producer_id, title, price_wholesale, price_retail, article, short_description, long_description, published)
	VALUES (7, 1, '������ ����', 1800, 2000, '4 020173', '������ ����<br />������ 48, ���� �����', '������, ���������� �� ��������, � ��������� � �/������������. �/���������� ��������� �� ������. ', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, price_retail, article, short_description, long_description, published)
	VALUES (7, 1, '������ ����', 1800, 2000, '4 020174', '������ ����<br />������ 50, ���� �����', '������, ���������� �� ��������, � ��������� � �/������������. �/���������� ��������� �� ������. ', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, price_retail, article, short_description, long_description, published)
	VALUES (7, 1, '������ ����', 1800, 2000, '4 020175', '������ ����<br />������ 52, ���� �����', '������, ���������� �� ��������, � ��������� � �/������������. �/���������� ��������� �� ������. ', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, price_retail, article, short_description, long_description, published)
	VALUES (7, 1, '������ ����', 1800, 2000, '4 020176', '������ ����<br />������ 54, ���� �����', '������, ���������� �� ��������, � ��������� � �/������������. �/���������� ��������� �� ������. ', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, price_retail, article, short_description, long_description, published)
	VALUES (7, 1, '������ ����', 1800, 2000, '4 020177', '������ ����<br />������ 56, ���� �����', '������, ���������� �� ��������, � ��������� � �/������������. �/���������� ��������� �� ������. ', 1);
	
INSERT INTO products (category_id, producer_id, title, price_wholesale, price_retail, article, short_description, long_description, published)
	VALUES (8, 1, '������ ����', 1800, 2000, '4 020183', '������ ����<br />������ 52, ������� ����', '������, ���������� �� ��������, � ��������� � �/������������. �/���������� ��������� �� ������. ', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, price_retail, article, short_description, long_description, published)
	VALUES (8, 1, '������ ����', 1800, 2000, '4 020184', '������ ����<br />������ 54, ������� ����', '������, ���������� �� ��������, � ��������� � �/������������. �/���������� ��������� �� ������. ', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, price_retail, article, short_description, long_description, published)
	VALUES (8, 1, '������ ����', 1800, 2000, '4 020185', '������ ����<br />������ 56, ������� ����', '������, ���������� �� ��������, � ��������� � �/������������. �/���������� ��������� �� ������. ', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, price_retail, article, short_description, long_description, published)
	VALUES (8, 1, '������ ����', 1800, 2000, '4 020186', '������ ����<br />������ 58, ������� ����', '������, ���������� �� ��������, � ��������� � �/������������. �/���������� ��������� �� ������. ', 1);
INSERT INTO products (category_id, producer_id, title, price_wholesale, price_retail, article, short_description, long_description, published)
	VALUES (8, 1, '������ ����', 1800, 2000, '4 020187', '������ ����<br />������ 60, ������� ����', '������, ���������� �� ��������, � ��������� � �/������������. �/���������� ��������� �� ������. ', 1);

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
INSERT INTO ads (name, content, from_date, to_date) VALUES ('���������� � 1 ��������', '���, � ��� ���������� � 1 ��������!', '2011-08-01', '2011-09-05');
INSERT INTO ads (name, content, from_date, to_date) VALUES ('���������� � 2 ��������', '���, � ��� ���������� � 2 ��������!', '2011-08-01', '2011-09-05');
INSERT INTO ads (name, content, from_date, to_date) VALUES ('���������� � 1 ��������', '���, � ��� ���������� � 1 ��������!', '2011-08-29', '2011-09-05');
INSERT INTO ads (name, content, from_date, to_date) VALUES ('���������� ����������', '���, � ��� ���������� ����������!', '2011-12-01', '2011-12-20');

/* Users */
INSERT INTO managers (login, password, access_rights) VALUES ('mrot154', 'a78f907fb4f8d22d59fa1aa0833154c9', 4);

/* Clients */
INSERT INTO clients (login, organization_type, last_visit, registered, phone, name) VALUES ('ivan@mail.ru', 1, '2011-08-10', '2011-01-01', '8-913-777-77-77', '������ ����� ����������');
INSERT INTO clients (login, organization_type, last_visit, registered, phone, name) VALUES ('semenov@mail.ru', 2, '2011-08-10', '2011-01-01', '8-913-1111-11-11', '������� ���� ����������');
INSERT INTO clients (login, organization_type, last_visit, registered, phone, name) VALUES ('stepka76@mail.ru', 3, '2011-08-10', '2011-01-01', '8-913-333-33-33', '������� ������ ��������');

/* Cart */
INSERT INTO cart_order_status (title) VALUES ('���������� �������'), ('�������'), ('�������������'), ('���������');