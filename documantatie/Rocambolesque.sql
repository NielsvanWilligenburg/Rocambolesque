DROP DATABASE IF EXISTS `rocambolesque`;
CREATE DATABASE `rocambolesque`;

USE `rocambolesque`;

-- PERSONEN
-- Column: Id, Firstname, Lastname
DROP TABLE IF EXISTS `person`;
CREATE TABLE `person`(
	`Id` 				INT 			NOT NULL	AUTO_INCREMENT PRIMARY KEY,
    `Firstname` 		VARCHAR(50)		NOT NULL,
    `Infix`				VARCHAR(20)		NULL,
    `Lastname`			VARCHAR(50) 	NOT NULL,
	`IsActive` 			TINYINT(1) 		NOT NULL 	DEFAULT 1,
    `Remark` 		TEXT			NULL,
    `DateCreated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `DateUpdated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=INNODB;
    
-- CONTACT
-- Column: Id, PersonId, Email, Mobile
DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact`(
	`Id` 				INT 			NOT NULL	AUTO_INCREMENT PRIMARY KEY,
    `PersonId`			INT				NULL,
    `Email`				VARCHAR(50) 	NOT NULL,
    `Mobile`			VARCHAR(15) 	NOT NULL,
	`IsActive` 			TINYINT(1) 		NOT NULL 	DEFAULT 1,
    `Remark` 		TEXT			NULL,
    `DateCreated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `DateUpdated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT PersonContact FOREIGN KEY (`PersonId`) REFERENCES person(`Id`)
)ENGINE=INNODB; 

-- USER
-- Column: Id, PersonId, Username, Password
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`(
	`Id` 				INT 			NOT NULL 	AUTO_INCREMENT PRIMARY KEY,
	`PersonId`			INT				NULL		UNIQUE KEY,
    `Username`			VARCHAR(50)		NOT NULL,
    `Password`			VARCHAR(100)	NOT NULL,
    `DatumIngelogd` 	TIMESTAMP		NULL,
    `DatumUitgelogd` 	TIMESTAMP		NULL,
	`IsActive` 			TINYINT(1) 		NOT NULL 	DEFAULT 1,
    `Remark` 		TEXT			NULL,
    `DateCreated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `DateUpdated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT PersonUser FOREIGN KEY (`PersonId`) REFERENCES person(`Id`)
)ENGINE=INNODB;

-- ROLE
-- Column: Id, Role
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role`(
	`Id` 				INT 			NOT NULL 	AUTO_INCREMENT PRIMARY KEY,
	`Name`				VARCHAR(20)		NOT NULL,
 	`IsActive` 			TINYINT(1) 		NOT NULL 	DEFAULT 1,
    `Remark` 		TEXT			NULL,
    `DateCreated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `DateUpdated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=INNODB;

-- USERROLE
-- Column: Id, UserId, RoleId
DROP TABLE IF EXISTS `userrole`;
CREATE TABLE `userrole`(
	`Id` 				INT 			NOT NULL 	AUTO_INCREMENT PRIMARY KEY,
	`UserId`			INT				NULL,
	`RoleId`			INT				NULL,
	`IsActive` 			TINYINT(1) 		NOT NULL 	DEFAULT 1,
    `Remark` 		TEXT			NULL,
    `DateCreated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `DateUpdated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT UserUserrole FOREIGN KEY (`UserId`) REFERENCES user(`Id`),
    CONSTRAINT RoleUserrole FOREIGN KEY (`RoleId`) REFERENCES role(`Id`)
)ENGINE=INNODB;

-- TABLE
-- Column: Id, TableNumber, MaxGuests, MaxChildren
DROP TABLE IF EXISTS `table`;
CREATE TABLE `table`(
	`Id` 				INT 			NOT NULL 	AUTO_INCREMENT PRIMARY KEY,
    `TableNumber`		INT 			NOT NULL,
    `MaxGuests`			INT   			NOT NULL,
    `MaxChildren`		INT				NULL,
	`IsActive` 			TINYINT(1) 		NOT NULL 	DEFAULT 1,
    `Remark` 		TEXT			NULL,
    `DateCreated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `DateUpdated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=INNODB;

-- PRICE
-- Column: Id, GuestsPrice, ChildPrice
DROP TABLE IF EXISTS `price`;
CREATE TABLE `price`(
	`Id` 				INT 			NOT NULL 	AUTO_INCREMENT PRIMARY KEY,
    `GuestsPrice`		INT				NOT NULL,
    `ChildPrice`		INT				NOT NULL,
	`IsActive` 			TINYINT(1) 		NOT NULL 	DEFAULT 1,
    `Remark` 		TEXT			NULL,
    `DateCreated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `DateUpdated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=INNODB;

-- OPENINGSTIME
-- Column: Id, Day, Opening, Closing
DROP TABLE IF EXISTS `openingtime`;
CREATE TABLE `openingtime`(
	`Id` 				INT 			NOT NULL 	AUTO_INCREMENT PRIMARY KEY,
    `PriceId`			INT				NOT NULL,
    `Day`				VARCHAR(9)		NOT NULL,
	`Opening`			TIME			NOT NULL,
    `Closing`			TIME 			NOT NULL,
	`IsActive` 			TINYINT(1) 		NOT NULL 	DEFAULT 1,
    `Remark` 		TEXT			NULL,
    `DateCreated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `DateUpdated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT PriceOpeningtime FOREIGN KEY (`PriceId`) REFERENCES `price`(`Id`)
)ENGINE=INNODB;

-- RESERVATION
-- Column: Id, DefaultDataId, TableId, Guests, Children, Date, Time
DROP TABLE IF EXISTS `reservation`;
CREATE TABLE reservation(
	`Id` 				INT 			NOT NULL 	AUTO_INCREMENT PRIMARY KEY,
    `PersonId` 			INT 			NOT NULL, 
	`OpeningtimeId` 	INT				NULL,
    `TableId`			INT				NULL,
    `Guests`			INT   	 		NOT NULL,
    `Children`			INT				NOT NULL,
    `Date`				DATE			NOT NULL,
	`Time`				TIME 			NOT NULL,
    `IsActive` 			TINYINT(1) 		NOT NULL 	DEFAULT 1,
    `Remark` 		TEXT			NULL,
    `DateCreated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `DateUpdated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT PersonReservation FOREIGN KEY (`PersonId`) REFERENCES `person`(`Id`),
    CONSTRAINT OpeningstimeReservation FOREIGN KEY (`OpeningtimeId`) REFERENCES openingtime(`Id`),
    CONSTRAINT TableReservation FOREIGN KEY (`TableId`) REFERENCES `table`(`Id`)
)ENGINE=INNODB;

-- MENU
-- Column: Id, Name, Description
CREATE TABLE `menu`(
    `Id` 				INT 			NOT NULL 	AUTO_INCREMENT PRIMARY KEY ,
    `Name` 				VARCHAR(255) 	NOT NULL,
    `Description` 		VARCHAR(255) 	NOT NULL,
    `IsActive` 			TINYINT(1) 		NOT NULL 	DEFAULT 1,
    `Remark` 		TEXT			NULL,
    `DateCreated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `DateUpdated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=INNODB;

-- APPETIZER
-- Column: Id, MenuId, Name, Ingredients, Category
CREATE TABLE `appetizer`(
    `Id` 				INT  			NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `MenuId` 			INT				NOT NULL,
    `Name` 				VARCHAR(255) 	NOT NULL,
    `Ingredients` 		VARCHAR(255) 	NOT NULL,
    `Category` 			VARCHAR(255) 	NOT NULL,
    `IsActive` 			TINYINT(1) 		NOT NULL 	DEFAULT 1,
    `Remark` 		TEXT			NULL,
    `DateCreated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `DateUpdated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT MenuAppetizer FOREIGN KEY (`MenuId`) REFERENCES `menu`(`Id`)
)ENGINE=INNODB;

-- MAIN
-- Column: Id, MenuId, Name, Ingredients, Category
CREATE TABLE `main`(
    `id` 				INT 		 	NOT NULL 	AUTO_INCREMENT PRIMARY KEY,
    `MenuId` 			INT 			NOT NULL,
    `Name` 				VARCHAR(255) 	NOT NULL,
    `Ingredients` 		VARCHAR(255) 	NOT NULL,
    `Category` 			VARCHAR(255)	NOT NULL,
    `IsActive` 			TINYINT(1) 		NOT NULL 	DEFAULT 1,
    `Remark` 		TEXT			NULL,
    `DateCreated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `DateUpdated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT MenuMain FOREIGN KEY (`MenuId`) REFERENCES `menu`(`Id`)
)ENGINE=INNODB;

-- DESSERT
-- Column: Id, MenuId, Name, Ingredients, Category
CREATE TABLE `dessert`(
    `id` 				INT  			NOT NULL 	AUTO_INCREMENT PRIMARY KEY,
    `MenuId` 			INT 			NOT NULL,
    `Name` 				VARCHAR(255) 	NOT NULL,
    `Ingredients` 		VARCHAR(255) 	NOT NULL,
    `Category` 			VARCHAR(255) 	NOT NULL,
    `IsActive` 			TINYINT(1) 		NOT NULL 	DEFAULT 1,
    `Remark` 		TEXT			NULL,
    `DateCreated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `DateUpdated` 	TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT MenuDessert FOREIGN KEY (`MenuId`) REFERENCES `menu`(`Id`)
)ENGINE=INNODB;




-- DEFAULT WAARDES VAN OPENINGSTIJDEN, TAFELS EN TARIEVEN
INSERT INTO `table`(
	`TableNumber`,
    `MaxGuests`,
    `MaxChildren`)
VALUES 
	('10', '4', '2'),
    ('11', '4', '2'),
    ('12', '4', '0'),
    ('13', '4', '0'),
    ('14', '4', '0'),
    ('15', '4', '0'),
    ('16', '4', '0'),
    ('17', '4', '0');
    
INSERT INTO `price`(
    `GuestsPrice`,
    `ChildPrice`)
VALUES 
	(35, 25),
    (42, 32);

INSERT INTO openingtime(
	`PriceId`,
    `Day`,
	`Opening`,
    `Closing`)
VALUES 
	(1, 'Maandag', '17:00:00', '22:00:00'),
    (1, 'Dinsdag', '17:00:00', '22:00:00'),
    (2, 'Woensdag', '17:00:00', '22:00:00'),
    (1, 'Donderdag', '17:00:00', '22:00:00'),
    (2, 'Vrijdag', '17:00:00', '22:00:00'),
    (1, 'Zaterdag', '17:00:00', '22:00:00'),
    (1, 'Zondag', '17:00:00', '22:00:00');


/**
 *	All the stored procedures below V
**/


USE Rocambolesque;
DROP PROCEDURE IF EXISTS spCreatePerson;

DELIMITER //
    
CREATE PROCEDURE spCreatePerson
(
	 firstname				VARCHAR(50)
	,infix					VARCHAR(20)
	,lastname				VARCHAR(50)
	,username				VARCHAR(50)
	,password				VARCHAR(60)
	,email					VARCHAR(50)
	,mobile					VARCHAR(15)
)

BEGIN

    DECLARE personId 	INT UNSIGNED DEFAULT 0;
    
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
    	ROLLBACK;
    	SELECT 'An error has occurred, operation rollbacked and the stored procedure was terminated';
	END;
            
	START TRANSACTION;					
		INSERT INTO person
		(
			 Firstname			
			,Lastname		
		)
		VALUES
		(
			 firstname
			,lastname
		);
		
        SET personId = LAST_INSERT_ID();

		INSERT INTO contact
		(
			 PersonId
			,Email
			,Mobile		
		)
		VALUES
		(
			 personId
			,email
			,mobile
		);
		INSERT INTO user
		(
			 PersonId
			,Username		
			,Password
			,DatumIngelogd		
			,DatumUitgelogd
		)
		VALUES
		(
			 personId
			,username
			,password	
			,NULL
			,NULL
		);
               
        COMMIT;	
END //


USE Rocambolesque;
DROP PROCEDURE IF EXISTS spFindEmail;

DELIMITER //
    
CREATE PROCEDURE spFindEmail
(
	 emailCheck				VARCHAR(50)
)

BEGIN

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
    	ROLLBACK;
    	SELECT 'An error has occurred, operation rollbacked and the stored procedure was terminated';
	END;
            
	START TRANSACTION;
    	SELECT * FROM contact WHERE Email = emailCheck;
               
        COMMIT;	
END //


USE Rocambolesque;
DROP PROCEDURE IF EXISTS spFindPersonByEmailOrUsername;

DELIMITER //
    
CREATE PROCEDURE spFindPersonByEmailOrUsername
(
	userString				VARCHAR(50)
)

BEGIN

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
    	ROLLBACK;
    	SELECT 'An error has occurred, operation rollbacked and the stored procedure was terminated';
	END;
            
	START TRANSACTION;
    	SELECT `user`.Password, per.Id FROM `person` per INNER JOIN `contact` con ON per.Id = con.PersonId INNER JOIN `user` ON per.Id = `user`.PersonId WHERE con.Email = userString OR `user`.Username = userString;
               
        COMMIT;	
END //

DROP PROCEDURE IF EXISTS delete_person_and_related_tables;

DELIMITER //

CREATE PROCEDURE delete_person_and_related_tables(
    IN person_id INT
)
BEGIN
    DELETE FROM userrole WHERE UserId IN (SELECT Id FROM user WHERE PersonId = person_id);
    DELETE FROM user WHERE PersonId = person_id;
    DELETE FROM contact WHERE PersonId = person_id;
    DELETE FROM reservation WHERE PersonId = person_id;
    DELETE FROM person WHERE Id = person_id;
END //

DELIMITER ;

DROP PROCEDURE IF EXISTS delete_person_and_related_tables;

DELIMITER //

CREATE PROCEDURE delete_person_and_related_tables(
    IN person_id INT
)
BEGIN
    DELETE FROM userrole WHERE UserId IN (SELECT Id FROM user WHERE PersonId = person_id);
    DELETE FROM user WHERE PersonId = person_id;
    DELETE FROM contact WHERE PersonId = person_id;
    DELETE FROM reservation WHERE PersonId = person_id;
    DELETE FROM person WHERE Id = person_id;
END //

DELIMITER ;

USE Rocambolesque;
DROP PROCEDURE IF EXISTS spFindUsername;

DELIMITER //
    
CREATE PROCEDURE spFindUsername
(
	 usernameCheck				VARCHAR(50)
)

BEGIN

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
    	ROLLBACK;
    	SELECT 'An error has occurred, operation rollbacked and the stored procedure was terminated';
	END;
            
	START TRANSACTION;
    	SELECT * FROM user WHERE Username = usernameCheck;
               
        COMMIT;	
END //


-- CREATE RESERVATION STORED PROCEDURE

USE Rocambolesque;
DROP PROCEDURE IF EXISTS spCreateReservation;

DELIMITER //
    
CREATE PROCEDURE spCreateReservation
(
	 personId				int
	,openingtimeId			int	
	,tableId				int
	,guests					int
	,children				int
    ,dateReservation		date
    ,timeReservation 		time
)

BEGIN
    
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
    	ROLLBACK;
    	SELECT 'An error has occurred, operation rollbacked and the stored procedure was terminated';
	END;
            
	START TRANSACTION;					
		INSERT INTO reservation
		(
			 PersonId			
            ,OpeningtimeId
            ,TableId
            ,Guests
            ,Children
            ,Date
            ,Time
		)
		VALUES
		(
			personId				
			,openingtimeId			
			,tableId				
			,guests					
			,children				
			,dateReservation		
			,timeReservation 		
		);	
	COMMIT;
END //


-- FIND TABLE STORED PROCEDURE

USE Rocambolesque;

DROP PROCEDURE IF EXISTS spFindTable;

DELIMITER //

CREATE PROCEDURE spFindTable(
    guestCheck                    INT,
    childCheck                    INT,
    dateCheck                    VARCHAR(10),
    timeStartCheck                VARCHAR(8)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SELECT 'An error has occurred, operation rollbacked and the stored procedure was terminated';
    END;
    
    START TRANSACTION;
    SELECT tab.Id
    FROM `table` tab
    WHERE MaxGuests >= guestCheck 
        AND MaxChildren >= childCheck
        AND Id NOT IN (    SELECT tab.Id
                        FROM `table` tab 
                        LEFT JOIN reservation res 
                        ON res.TableId = tab.Id 
                        WHERE `Date` = dateCheck
                            AND timeStartCheck BETWEEN DATE_SUB(`Time`, INTERVAL 2 HOUR) AND DATE_ADD(`Time`, INTERVAL 2 HOUR))
    ORDER BY MaxGuests ASC, MaxChildren ASC LIMIT 1;
    COMMIT;
END //