CREATE TABLE `insly_employee` (	`employeeID` int NOT NULL AUTO_INCREMENT COMMENT 'Employee ID',	`Name` varchar(100) NULL,	`Birthdate` date NULL,
	`SSN` varchar(100) NULL,
	`current_employee` enum('yes','no') NULL COMMENT 'Is a current employee (yes/no)',
	`email` varchar(255) NULL,
	`phone` varchar(255) NULL,
	`address` text NULL,
	PRIMARY KEY (`employeeID`) 
) ENGINE = InnoDB;

CREATE TABLE `insly_employee_languages` (	`employeeID` int,	`lang` enum('English', 'Spanish', 'French') NULL,	`introduction` text NULL,
	`work_experience` text NULL COMMENT 'Previous work experience',
	`education` text NULL COMMENT 'Education information',    UNIQUE INDEX `id_lang_unique` (`employeeID` ASC, `lang` ASC),    CONSTRAINT `FK_employeeLangID` FOREIGN KEY (`employeeID`) REFERENCES insly_employee(`employeeID`)
) ENGINE = InnoDB;

CREATE TABLE `insly_employee_log` (	`employeeID` int,	`who` varchar(255) NULL,	`log_date` date NULL,	`oper` enum('created', 'edited') NULL,	CONSTRAINT `FK_employeeLogID` FOREIGN KEY (`employeeID`) REFERENCES insly_employee(`employeeID`)
) ENGINE = InnoDB;INSERT INTO `insly_employee` (`employeeID`, `Name`, `Birthdate`, `SSN`, `current_employee`, `email`, `phone`, `address`) VALUES (NULL, 'Rashad Aliyev', '1983-06-05', '1234567890', 'yes', 'rashad@aliev.info', '00994506482737', 'Baku, Azerbaijan');INSERT INTO `insly_employee_languages` (`employeeID`, `lang`, `introduction`, `work_experience`, `education`) VALUES ('1', 'English', 'Introduction in English', 'Work Experience in English', 'Education info in English');INSERT INTO `insly_employee_languages` (`employeeID`, `lang`, `introduction`, `work_experience`, `education`) VALUES ('1', 'Spanish', 'Introduction in Spanish', 'Work Experience in Spanish', 'Education info in Spanish');INSERT INTO `insly_employee_languages` (`employeeID`, `lang`, `introduction`, `work_experience`, `education`) VALUES ('1', 'French', 'Introduction in French', 'Work Experience in French', 'Education info in French');INSERT INTO `insly_employee_log` (`employeeID`, `who`, `log_date`, `oper`) VALUES ('1', 'Pamela', '2019-01-12', 'created');