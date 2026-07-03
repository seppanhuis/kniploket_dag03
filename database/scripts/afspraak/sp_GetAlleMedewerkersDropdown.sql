DROP PROCEDURE IF EXISTS sp_GetAlleMedewerkersDropdown;

DELIMITER $$

CREATE PROCEDURE sp_GetAlleMedewerkersDropdown()
BEGIN
	SELECT
		Id,
		CONCAT(Voornaam, ' ', IFNULL(CONCAT(Tussenvoegsel, ' '), ''), Achternaam) AS VolledigeNaam
	FROM Medewerker
	WHERE IsActief = 1
	ORDER BY Achternaam ASC;
END$$

DELIMITER ;
