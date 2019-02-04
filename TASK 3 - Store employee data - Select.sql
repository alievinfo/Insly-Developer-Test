SELECT 
	`Employee`.`employeeID` AS `ID`,
	`employeeLang`.`lang` AS `Language`,
	`Employee`.`Name`,
	`Employee`.`Birthdate`,
	`Employee`.`SSN`,
	`Employee`.`current_employee`,
	`Employee`.`email`,
	`Employee`.`phone`,
	`Employee`.`address`,
	`employeeLang`.`introduction`,
	`employeeLang`.`work_experience`,
	`employeeLang`.`education`
FROM `insly_employee` `Employee`
INNER JOIN `insly_employee_languages` `employeeLang`
WHERE 
	`Employee`.`employeeID` = 1
