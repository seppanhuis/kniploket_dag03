-- *****************************************************************************************************
-- Doel : Haal 1 product op inclusief categorie, voorraad en (meest recente) leverancier
--        voor de pagina "Productdetail"
-- *****************************************************************************************************

DROP PROCEDURE IF EXISTS sp_GetProductById;

DELIMITER $$

CREATE PROCEDURE sp_GetProductById(
	IN p_id INT
)
BEGIN
	SELECT
		P.Id,
		P.Naam,
		P.Omschrijving,
		P.Merk,
		P.EANcode,
		P.Houdbaarheidsdatum,
		P.InkoopPrijs,
		P.VerkoopPrijs,
		P.Opmerking,
		C.Naam AS CategorieNaam,
		COALESCE(V.AantalOpVoorraad, 0) AS AantalOpVoorraad,
		L.Naam AS LeverancierNaam,
		L.Postcode AS LeverancierPostcode,
		L.Plaats AS LeverancierPlaats,
		L.Email AS LeverancierEmail,
		L.Mobiel AS LeverancierMobiel
	FROM Product AS P
	INNER JOIN Categorie AS C ON C.Id = P.CategorieId
	LEFT JOIN Voorraad AS V ON V.ProductId = P.Id AND V.IsActief = 1
	LEFT JOIN LeverancierOrder AS LO ON LO.ProductId = P.Id
	LEFT JOIN Leverancier AS L ON L.Id = LO.LeverancierId
	WHERE P.Id = p_id
	ORDER BY LO.Orderdatum DESC
	LIMIT 1;
END$$

DELIMITER ;
