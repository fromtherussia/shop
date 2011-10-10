--
-- DB preparation
--

DROP SCHEMA IF EXISTS shop CASCADE;
CREATE SCHEMA shop;

SET search_path TO shop, public;

--
-- Schema
--

/* Manages site */
CREATE TABLE shop.managers (
	id BIGSERIAL PRIMARY KEY,
	login TEXT,
	password TEXT,
	last_visit TIMESTAMPTZ,
	access_rights INTEGER
);

/* Uses site */
CREATE TABLE shop.clients (
	id BIGSERIAL PRIMARY KEY,
	login TEXT,
	password TEXT,
	last_visit TIMESTAMPTZ,
	registered TIMESTAMPTZ,
	access_rights INTEGER,
	/* Contacts */
	phone TEXT,
	name TEXT,
	organization_type INTEGER,
	comments TEXT,
	/* Extended */
	juridical_address TEXT,
	ogrn TEXT,
	inn TEXT,
	kpp TEXT,
	okpo TEXT,
	mailing_address TEXT,
	current_account TEXT,
	correspondent_account TEXT,
	bik TEXT
);

/* Producers / Categories / Products */
CREATE TABLE shop.producers (
	id BIGSERIAL PRIMARY KEY,
	title TEXT,
	image TEXT,
	short_description TEXT
);

CREATE TABLE shop.categories (
	id BIGSERIAL PRIMARY KEY,
	title TEXT,
	image TEXT,
	short_description TEXT,
	long_description TEXT,
	published INTEGER
);

CREATE TABLE shop.categories_tree (
	category_id BIGINT REFERENCES categories,
	parent_category_id BIGINT REFERENCES categories
);

CREATE TABLE shop.products (
	id BIGSERIAL PRIMARY KEY,
	category_id BIGINT REFERENCES categories,
	producer_id BIGINT REFERENCES producers,
	title TEXT,
	price_wholesale INTEGER,
	price_retail INTEGER,
	article TEXT,
	short_description TEXT,
	long_description TEXT,
	published INTEGER,
	hits BIGINT 
);

CREATE TABLE shop.product_images (
	product_id BIGINT REFERENCES products,
	image_url TEXT
);

/* Keywords. Shared between products and categories */
CREATE TABLE shop.keywords (
	id BIGSERIAL PRIMARY KEY,
	keyword TEXT
);

CREATE TABLE shop.product_keywords (
	product_id BIGINT REFERENCES products,
	keyword_id BIGINT REFERENCES keywords
);

CREATE TABLE shop.category_keywords (
	category_id BIGINT REFERENCES categories,
	keyword_id BIGINT REFERENCES keywords
);

/* Information pages */
CREATE TABLE shop.info_sections (
	id BIGSERIAL PRIMARY KEY,
	order_no INTEGER,
	title TEXT
);

CREATE TABLE shop.info_pages (
	id BIGSERIAL PRIMARY KEY,
	title TEXT,
	info_section_id BIGINT REFERENCES info_sections,
	order_no INTEGER,
	content TEXT
);

/* Named articles */
CREATE TABLE shop.article_locations (
	id BIGSERIAL PRIMARY KEY,
	name TEXT,
	title TEXT
);

CREATE TABLE shop.named_articles (
	id BIGSERIAL PRIMARY KEY,
	article_location_id BIGINT REFERENCES article_locations,
	name TEXT,
	content TEXT
);

/* Ads */
CREATE TABLE shop.ads (
	id BIGSERIAL PRIMARY KEY,
	name TEXT,
	content TEXT,
	from_date DATE,
	to_date DATE
);

/* Discounts */
CREATE TABLE shop.discounts (
	precent INTEGER,
	type INTEGER,
	range_begin INTEGER,
	range_end INTEGER
);

/* Cart */
CREATE TABLE shop.cart (
	client_id INTEGER REFERENCES clients,
	product_id INTEGER REFERENCES products,
	amount INTEGER
);

CREATE TABLE shop.cart_order_status (
	id SERIAL PRIMARY KEY,
	title TEXT
);

CREATE TABLE shop.cart_order (
	id BIGSERIAL PRIMARY KEY,
	client_id INTEGER REFERENCES clients,
	status_id INTEGER REFERENCES cart_order_status,
	paid BOOLEAN,
	price INTEGER,
	price_discounted INTEGER
);

CREATE TABLE shop.ordered_products (
	ordered_id BIGINT REFERENCES cart_order,
	product_id INTEGER REFERENCES products,
	amount INTEGER
);

--
-- API
--

CREATE FUNCTION getCategoriesRoot() RETURNS BIGINT AS $$
	BEGIN
		RETURN 1;
	END;
$$ LANGUAGE plpgsql;

CREATE FUNCTION	getCategoryPath(parentCategoryId BIGINT, categoryId BIGINT, title TEXT, shortDescription TEXT) RETURNS SETOF RECORD AS $$
	BEGIN
		RETURN QUERY
			WITH RECURSIVE getCategoryPath(n, r_parent_category_id, r_category_id, r_category_title, r_category_short_description) AS
				(VALUES(0::bigint, parentCategoryId, categoryId, title, shortDescription)
			UNION ALL
                                SELECT
					n + 1,
					(SELECT t.parent_category_id FROM categories_tree t WHERE t.category_id = r_parent_category_id),
					r_parent_category_id,
					c.title,
					c.short_description
                                FROM getCategoryPath
				INNER JOIN categories c ON c.id = r_parent_category_id
                                WHERE r_parent_category_id > 0
			)
			SELECT r_parent_category_id, r_category_id, r_category_title, r_category_short_description
				FROM getCategoryPath
				ORDER BY n DESC;
	END;
$$ LANGUAGE 'plpgsql';

--
-- Permissions
--

/*
	Table usage permissions
*/
/* Users */
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE clients TO mrot_user;
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE managers TO mrot_user;
/* Products */
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE producers TO mrot_user;
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE categories TO mrot_user;
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE categories_tree TO mrot_user;
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE products TO mrot_user;
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE product_images TO mrot_user;
/* Keywords */
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE keywords TO mrot_user;
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE product_keywords TO mrot_user;
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE category_keywords TO mrot_user;
/* Info pages */
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE info_sections TO mrot_user;
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE info_pages TO mrot_user;
/* Named articles */
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE article_locations TO mrot_user;
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE named_articles TO mrot_user;
/* Ads */
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE ads TO mrot_user;
/* Discounts */
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE discounts TO mrot_user;
/* Cart */
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE cart TO mrot_user;
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE cart_order_status TO mrot_user;
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE cart_order TO mrot_user;
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE ordered_products TO mrot_user;

/*
	Sequence usage permissions
*/
/* Users */
GRANT USAGE, SELECT, UPDATE ON SEQUENCE clients_id_seq TO mrot_user;
GRANT USAGE, SELECT, UPDATE ON SEQUENCE managers_id_seq TO mrot_user;
/* Products */
GRANT USAGE, SELECT, UPDATE ON SEQUENCE producers_id_seq TO mrot_user;
GRANT USAGE, SELECT, UPDATE ON SEQUENCE categories_id_seq TO mrot_user;
GRANT USAGE, SELECT, UPDATE ON SEQUENCE products_id_seq TO mrot_user;
/* Keywords */
GRANT USAGE, SELECT, UPDATE ON SEQUENCE keywords_id_seq TO mrot_user;
/* Info pages */
GRANT USAGE, SELECT, UPDATE ON SEQUENCE info_pages_id_seq TO mrot_user;
GRANT USAGE, SELECT, UPDATE ON SEQUENCE info_sections_id_seq TO mrot_user;
/* Named articles */
GRANT USAGE, SELECT, UPDATE ON SEQUENCE article_locations_id_seq TO mrot_user;
GRANT USAGE, SELECT, UPDATE ON SEQUENCE named_articles_id_seq TO mrot_user;
/* Ads */
GRANT USAGE, SELECT, UPDATE ON SEQUENCE ads_id_seq TO mrot_user;
/* Cart */
GRANT USAGE, SELECT, UPDATE ON SEQUENCE cart_order_id_seq TO mrot_user;

/*
	Schema usage permissions
*/
GRANT USAGE ON SCHEMA public TO mrot_user;
GRANT USAGE ON SCHEMA shop TO mrot_user;

/*
	API usage permissions
*/
GRANT ALL ON FUNCTION getCategoriesRoot() TO mrot_user;
GRANT ALL ON FUNCTION getCategoryPath(parentCategoryId BIGINT, categoryId BIGINT, title TEXT, shortDescription TEXT) TO mrot_user;
GRANT USAGE ON LANGUAGE plpgsql TO mrot_user;

