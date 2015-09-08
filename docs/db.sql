CREATE DATABASE loudbite;
# Change into the database to run commands
USE loudbite;
# accounts Table Creation
CREATE TABLE accounts (
	id int(11) AUTO_INCREMENT PRIMARY KEY,
	username varchar(20) NOT NULL UNIQUE,
	email varchar(200) NOT NULL UNIQUE,
	password varchar(20) NOT NULL,
	status varchar(10) DEFAULT 'pending',
	email_newsletter_status varchar(3) DEFAULT 'out',
	email_type varchar(4) DEFAULT 'text',
	email_favorite_artists_status varchar(3) DEFAULT 'out',
	created_date DATETIME
);


# artists Table Creation
CREATE TABLE artists (
	id int(11) AUTO_INCREMENT PRIMARY KEY,
	artist_name varchar(200) NOT NULL,
	genre varchar(100) NOT NULL,
	created_date DATETIME
);
# accounts_artists Table Creation
CREATE TABLE accounts_artists (
	id int(11) AUTO_INCREMENT PRIMARY KEY,
	account_id int(11) NOT NULL,
	artist_id int(11) NOT NULL,
	created_date DATETIME,
	rating int(1),
	is_fav int(1)
);

CREATE TABLE `bugs` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`author` varchar(250) DEFAULT NULL,
	`email` varchar(250) DEFAULT NULL,
	`date` int(11) DEFAULT NULL,
	`url` varchar(250) DEFAULT NULL,
	`description` text,
	`priority` varchar(50) DEFAULT NULL,
	`status` varchar(50) DEFAULT NULL,
	PRIMARY KEY (`id`)
);


CREATE TABLE users (
    id INTEGER  NOT NULL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(32) NULL,
    password_salt VARCHAR(32) NULL,
    real_name VARCHAR(150) NULL
)
