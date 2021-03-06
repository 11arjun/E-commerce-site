DROP TABLE IF EXISTS VERIFY_EMAIL;
DROP TABLE IF EXISTS RESET_PASSWORD;
DROP TABLE IF EXISTS PAYMENTS;
DROP TABLE IF EXISTS ORDER_PRODUCT;
DROP TABLE IF EXISTS ORDERS;
DROP TABLE IF EXISTS SLOTS;
DROP TABLE IF EXISTS VOUCHERS;
DROP TABLE IF EXISTS REVIEWS; 
DROP TABLE IF EXISTS DISCOUNTS;
DROP TABLE IF EXISTS PRODUCTS;
DROP TABLE IF EXISTS CATEGORIES;
DROP TABLE IF EXISTS SHOPS;
DROP TABLE IF EXISTS TRADERS;
DROP TABLE IF EXISTS CUSTOMERS;
DROP TABLE IF EXISTS MANAGEMENTS;
DROP TABLE IF EXISTS USERS;

CREATE TABLE USERS (
	USER_ID BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	FULL_NAME VARCHAR(100) NOT NULL,
	USERNAME VARCHAR(30) NOT NULL UNIQUE,
	EMAIL VARCHAR(100) NOT NULL UNIQUE,
	STREET VARCHAR(100) NULL,
	CITY VARCHAR(100) NULL,
	STATE VARCHAR(100) NULL,
	POSTAL VARCHAR(100) NULL,
	COUNTRY VARCHAR(100) NULL,
	GENDER BIGINT NOT NULL,
	USER_ROLE BIGINT DEFAULT 3,
	PASSWORD_HASH VARCHAR(255) NOT NULL,
	IMAGE VARCHAR(100) NULL,
	CREATED_AT DATETIME(0) DEFAULT CURRENT_TIMESTAMP,
	UPDATED_AT DATETIME(0) NULL
);


CREATE TABLE MANAGEMENTS (
	MANAGEMENT_ID BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	USER_ID BIGINT NOT NULL,
	CONTACT_NO VARCHAR(20) NOT NULL,
	FOREIGN KEY (USER_ID) REFERENCES USERS (USER_ID) ON DELETE CASCADE
);


CREATE TABLE CUSTOMERS (
	CUSTOMER_ID BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	USER_ID BIGINT NOT NULL,
	EMAIL_VERIFIED_AT DATETIME(0) NULL,
	FOREIGN KEY (USER_ID) REFERENCES USERS (USER_ID) ON DELETE CASCADE
);


CREATE TABLE TRADERS (
	TRADER_ID BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	USER_ID BIGINT NOT NULL,
	VERIFIED_AT DATETIME(0) NULL,
	CONTACT_NO VARCHAR(20) NOT NULL,
	TRADING_SINCE DATETIME(0) NOT NULL,
	BUSINESS_TYPE VARCHAR(20) NOT NULL,
	PREFERRED_PAYMENTS VARCHAR(30) NOT NULL,
	MESSAGE VARCHAR(200) NOT NULL,
	STATUS BIGINT DEFAULT 1,
	FOREIGN KEY (USER_ID) REFERENCES USERS (USER_ID) ON DELETE CASCADE
);


CREATE TABLE SHOPS (
	SHOP_ID BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	TRADER_ID BIGINT NOT NULL,
	SHOP_NAME VARCHAR(100) NOT NULL,
	VERIFIED_ON DATETIME NULL,
	GOV_NO VARCHAR(30) NOT NULL,
	ADDRESS VARCHAR(50) NOT NULL,
	CONTACT_NO VARCHAR(20) NOT NULL,
	SHOP_TYPE VARCHAR(20) NOT NULL,
	DESCRIPTION VARCHAR(200) NOT NULL,
	CREATED_AT DATETIME(0) DEFAULT CURRENT_TIMESTAMP,
	UPDATED_AT DATETIME(0) NULL,
	FOREIGN KEY (TRADER_ID) REFERENCES USERS (USER_ID) ON DELETE CASCADE 
);


CREATE TABLE CATEGORIES (
	CATEGORY_ID BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	CATEGORY_NAME VARCHAR(30) NOT NULL,
	DESCRIPTION VARCHAR(200) NOT NULL,
	IMAGE VARCHAR(200) NOT NULL,
	CREATED_AT DATETIME(0) DEFAULT CURRENT_TIMESTAMP,
	UPDATED_AT DATETIME(0) NULL
);


CREATE TABLE PRODUCTS (
	PRODUCT_ID BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	PRODUCT_NAME VARCHAR(100) NOT NULL,
	CATEGORY_ID BIGINT NOT NULL,
	CONFIRMED_ON DATETIME NULL,
	PRICE BIGINT NOT NULL,
	STOCK BIGINT NOT NULL,
	TRADER_ID BIGINT NOT NULL,
	SHOP_ID BIGINT NOT NULL,
	DESCRIPTION VARCHAR(200) NOT NULL,
	IMAGE1 VARCHAR(50) NOT NULL,
	IMAGE2 VARCHAR(50) NOT NULL,
	CREATED_AT DATETIME(0) DEFAULT CURRENT_TIMESTAMP,
	UPDATED_AT DATETIME(0) NULL,
	FOREIGN KEY (CATEGORY_ID) REFERENCES CATEGORIES (CATEGORY_ID) ON DELETE CASCADE,
	FOREIGN KEY (SHOP_ID) REFERENCES SHOPS (SHOP_ID) ON DELETE CASCADE,
	FOREIGN KEY (TRADER_ID) REFERENCES USERS (USER_ID) ON DELETE CASCADE
);


CREATE TABLE DISCOUNTS (
	DISCOUNT_ID BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	DISCOUNT_NAME VARCHAR(50) NOT NULL,
	RATE DOUBLE NOT NULL,
	TARGET_ID BIGINT NULL,
	DISCOUNT_TYPE VARCHAR(20) NOT NULL,
	STARTS_ON DATETIME NOT NULL,
	EXPIRES_ON DATETIME NOT NULL,
	CREATED_BY BIGINT NOT NULL,
	CREATED_AT DATETIME(0) DEFAULT CURRENT_TIMESTAMP,
	UPDATED_AT DATETIME(0) NULL,
	FOREIGN KEY (CREATED_BY) REFERENCES USERS (USER_ID) ON DELETE CASCADE
);


CREATE TABLE REVIEWS (
	REVIEW_ID BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	USER_ID BIGINT NOT NULL,
	PRODUCT_ID BIGINT NOT NULL,
	RATING BIGINT NOT NULL,
	REVIEW VARCHAR(200) NOT NULL,
	CREATED_AT DATETIME(0) DEFAULT CURRENT_TIMESTAMP,
	UPDATED_AT DATETIME(0) NULL,
	FOREIGN KEY (USER_ID) REFERENCES USERS (USER_ID) ON DELETE CASCADE,
	FOREIGN KEY (PRODUCT_ID) REFERENCES PRODUCTS (PRODUCT_ID) ON DELETE CASCADE
);


CREATE TABLE VOUCHERS (
	VOUCHER_ID BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	VOUCHER_CODE VARCHAR(30) NOT NULL UNIQUE,
	DISCOUNT_AMOUNT BIGINT NOT NULL,
	MINIMUM BIGINT NOT NULL,
	CREATED_AT DATETIME(0) DEFAULT CURRENT_TIMESTAMP,
	UPDATED_AT DATETIME(0) NULL
);


CREATE TABLE SLOTS (
	SLOT_ID BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	SLOT_TIME VARCHAR(30) NOT NULL
);


CREATE TABLE ORDERS (
	ORDER_ID BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	USER_ID BIGINT NOT NULL,
	SLOT_ID BIGINT NOT NULL,
	STATUS BIGINT DEFAULT 1,
	ORDER_DATE DATETIME(0) DEFAULT CURRENT_TIMESTAMP,
	AMOUNT BIGINT NOT NULL,
	VOUCHER_CODE VARCHAR(30) NULL,
	VOUCHER_DISCOUNT BIGINT NULL,
	FOREIGN KEY (USER_ID) REFERENCES USERS (USER_ID) ON DELETE CASCADE,
	FOREIGN KEY (SLOT_ID) REFERENCES SLOTS (SLOT_ID) ON DELETE CASCADE
);


CREATE TABLE ORDER_PRODUCT (
	ID BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	ORDER_ID BIGINT NOT NULL,
	PRODUCT_ID BIGINT NOT NULL,
	SITE_DISCOUNT BIGINT NULL,
	PRODUCT_DISCOUNT BIGINT NULL,
	QUANTITY BIGINT NULL,
	STATUS BIGINT DEFAULT 1,
	FOREIGN KEY (ORDER_ID) REFERENCES ORDERS (ORDER_ID) ON DELETE CASCADE,
	FOREIGN KEY (PRODUCT_ID) REFERENCES PRODUCTS (PRODUCT_ID) ON DELETE CASCADE
);


CREATE TABLE PAYMENTS (
	PAYMENT_ID BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	ORDER_ID BIGINT NOT NULL,
	AMOUNT DOUBLE NOT NULL,
	PAYMENT_METHOD VARCHAR(15) NOT NULL,
	PAYMENT_DATE DATETIME(0) DEFAULT CURRENT_TIMESTAMP,
	TXN_ID VARCHAR(100) NULL,
	PAYMENT_FEE DOUBLE NULL,
	FOREIGN KEY (ORDER_ID) REFERENCES ORDERS (ORDER_ID)
);


CREATE TABLE RESET_PASSWORD (
	EMAIL VARCHAR(100) NOT NULL UNIQUE,
	TOKEN VARCHAR(32) NOT NULL,
	CREATED_AT DATETIME DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE VERIFY_EMAIL (
	EMAIL VARCHAR(100) NOT NULL UNIQUE,
	TOKEN VARCHAR(32) NOT NULL,
	CREATED_AT DATETIME DEFAULT CURRENT_TIMESTAMP
);