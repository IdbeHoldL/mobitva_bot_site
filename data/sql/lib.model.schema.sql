
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- sf_guard_user_profile
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `sf_guard_user_profile`;


CREATE TABLE `sf_guard_user_profile`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER  NOT NULL,
	`balance` FLOAT,
	`nickname` VARCHAR(255)  NOT NULL,
	`auth_key` VARCHAR(255)  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `sf_guard_user_profile_FI_1` (`user_id`),
	CONSTRAINT `sf_guard_user_profile_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- messages
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `messages`;


CREATE TABLE `messages`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER  NOT NULL,
	`from` VARCHAR(255)  NOT NULL,
	`title` VARCHAR(255)  NOT NULL,
	`body` TEXT  NOT NULL,
	`is_readed` TINYINT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `messages_FI_1` (`user_id`),
	CONSTRAINT `messages_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- bot_session
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `bot_session`;


CREATE TABLE `bot_session`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER  NOT NULL,
	`access_key` VARCHAR(255)  NOT NULL,
	`connect_ip` VARCHAR(255)  NOT NULL,
	`hardware_key` VARCHAR(255)  NOT NULL,
	`is_closed` TINYINT default 0,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `bot_session_FI_1` (`user_id`),
	CONSTRAINT `bot_session_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- botconfig
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `botconfig`;


CREATE TABLE `botconfig`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER  NOT NULL,
	`name` VARCHAR(255)  NOT NULL,
	`description` TEXT  NOT NULL,
	`body` TEXT  NOT NULL,
	`price` INTEGER default 0,
	`price_koef` INTEGER default 0,
	`weight` INTEGER default 0,
	`is_approved` TINYINT default 0,
	`is_global` TINYINT default 0,
	`is_editable` TINYINT default 1,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `botconfig_FI_1` (`user_id`),
	CONSTRAINT `botconfig_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- botconfig_relations
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `botconfig_relations`;


CREATE TABLE `botconfig_relations`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`botconfig_id` INTEGER  NOT NULL,
	`parent_botconfig_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `botconfig_relations_FI_1` (`botconfig_id`),
	CONSTRAINT `botconfig_relations_FK_1`
		FOREIGN KEY (`botconfig_id`)
		REFERENCES `botconfig` (`id`)
		ON DELETE CASCADE,
	INDEX `botconfig_relations_FI_2` (`parent_botconfig_id`),
	CONSTRAINT `botconfig_relations_FK_2`
		FOREIGN KEY (`parent_botconfig_id`)
		REFERENCES `botconfig` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- config_status
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `config_status`;


CREATE TABLE `config_status`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255)  NOT NULL,
	`description` TEXT  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- config_category
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `config_category`;


CREATE TABLE `config_category`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255)  NOT NULL,
	`description` TEXT  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- cros_config_category
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `cros_config_category`;


CREATE TABLE `cros_config_category`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`botconfig_id` INTEGER  NOT NULL,
	`config_category_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `cros_config_category_FI_1` (`botconfig_id`),
	CONSTRAINT `cros_config_category_FK_1`
		FOREIGN KEY (`botconfig_id`)
		REFERENCES `botconfig` (`id`)
		ON DELETE CASCADE,
	INDEX `cros_config_category_FI_2` (`config_category_id`),
	CONSTRAINT `cros_config_category_FK_2`
		FOREIGN KEY (`config_category_id`)
		REFERENCES `config_category` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- cros_user_config
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `cros_user_config`;


CREATE TABLE `cros_user_config`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER  NOT NULL,
	`botconfig_id` INTEGER  NOT NULL,
	`date_end` VARCHAR(255)  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `cros_user_config_FI_1` (`user_id`),
	CONSTRAINT `cros_user_config_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE,
	INDEX `cros_user_config_FI_2` (`botconfig_id`),
	CONSTRAINT `cros_user_config_FK_2`
		FOREIGN KEY (`botconfig_id`)
		REFERENCES `botconfig` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- license
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `license`;


CREATE TABLE `license`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER  NOT NULL,
	`date_end` VARCHAR(255)  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `license_FI_1` (`user_id`),
	CONSTRAINT `license_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- llicense_chars_places
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `llicense_chars_places`;


CREATE TABLE `llicense_chars_places`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`license_id` INTEGER  NOT NULL,
	`chars_count` INTEGER  NOT NULL,
	`date_end` VARCHAR(255)  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `llicense_chars_places_FI_1` (`license_id`),
	CONSTRAINT `llicense_chars_places_FK_1`
		FOREIGN KEY (`license_id`)
		REFERENCES `license` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- balance_operation
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `balance_operation`;


CREATE TABLE `balance_operation`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`type_id` INTEGER  NOT NULL,
	`user_id` INTEGER  NOT NULL,
	`sum` FLOAT  NOT NULL,
	`operation_data` INTEGER  NOT NULL,
	`additional` TEXT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `balance_operation_FI_1` (`user_id`),
	CONSTRAINT `balance_operation_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
