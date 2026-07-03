-- *****************************************************************************************************
-- Doel : Haal alle actieve categorieën op (voor het filter "Categorie selecteren")
-- *****************************************************************************************************

DROP PROCEDURE IF EXISTS sp_GetAllCategorieen;

DELIMITER $$

CREATE PROCEDURE sp_GetAllCategorieen()
BEGIN
	SELECT
		C.Id,
		C.Naam
	FROM Categorie AS C
	WHERE C.IsActief = 1
	ORDER BY C.Naam ASC;
END$$

DELIMITER ;
