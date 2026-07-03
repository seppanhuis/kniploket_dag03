-- *****************************************************************************************************
-- Doel : Haal alle actieve producten op (Overzicht producten), optioneel gefilterd op categorie
-- Params: p_categorie_id = NULL  -> alle categorieën
--         p_categorie_id = <id>  -> alleen producten van die categorie
-- *****************************************************************************************************

DROP PROCEDURE IF EXISTS sp_GetAllProducten;

DELIMITER $$

CREATE PROCEDURE sp_GetAllProducten(
	IN p_categorie_id INT
)
BEGIN
	SELECT
		P.Id,
		P.Naam,
		C.Naam AS CategorieNaam,
		P.Merk,
		P.EANcode,
		P.VerkoopPrijs,
		COALESCE(V.AantalOpVoorraad, 0) AS AantalOpVoorraad
	FROM Product AS P
	INNER JOIN Categorie AS C ON C.Id = P.CategorieId
	LEFT JOIN Voorraad AS V ON V.ProductId = P.Id AND V.IsActief = 1
	WHERE P.IsActief = 1
	  AND (p_categorie_id IS NULL OR P.CategorieId = p_categorie_id)
	ORDER BY P.Naam ASC;
END$$

DELIMITER ;
