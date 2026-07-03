
DROP PROCEDURE IF EXISTS sp_GetAlleBehandelingenDropdown;

DELIMITER $$

CREATE PROCEDURE sp_GetAlleBehandelingenDropdown()
BEGIN
	SELECT Id, Naam, Duurminuten
	FROM Behandeling
	WHERE IsActief = 1
	ORDER BY Naam ASC;
END$$

DELIMITER ;
