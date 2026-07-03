-- *****************************************************************
-- Doel : Haal het volledige productdetail op, inclusief voorraad
--        en leveranciersgegevens (via LeverancierOrder).
-- *****************************************************************

DROP PROCEDURE IF EXISTS sp_GetProductDetail;

DELIMITER $$

CREATE PROCEDURE sp_GetProductDetail(
    IN p_product_id INT
)
BEGIN
    SELECT
        P.Id,
        P.Naam,
        P.Merk,
        P.Omschrijving,
        P.EANcode,
        P.Houdbaarheidsdatum,
        P.InkoopPrijs,
        P.VerkoopPrijs,
        P.Opmerking,
        V.AantalOpVoorraad,
        L.Naam AS LeverancierNaam,
        L.Postcode AS LeverancierPostcode,
        L.Plaats AS LeverancierPlaats,
        L.Email AS LeverancierEmail,
        L.Mobiel AS LeverancierMobiel
    FROM Product AS P
    LEFT JOIN Voorraad AS V ON V.ProductId = P.Id AND V.IsActief = 1
    LEFT JOIN LeverancierOrder AS LO ON LO.ProductId = P.Id AND LO.IsActief = 1
    LEFT JOIN Leverancier AS L ON L.Id = LO.LeverancierId AND L.IsActief = 1
    WHERE P.Id = p_product_id
      AND P.IsActief = 1
    ORDER BY LO.Id ASC
    LIMIT 1;
END$$

DELIMITER ;
