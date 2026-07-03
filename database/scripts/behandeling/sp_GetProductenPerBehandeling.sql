-- *****************************************************************
-- Doel : Haal alle producten op die gekoppeld zijn aan een behandeling
--        via BehandelingPerVoorraad -> Voorraad -> Product.
-- *****************************************************************

DROP PROCEDURE IF EXISTS sp_GetProductenPerBehandeling;

DELIMITER $$

CREATE PROCEDURE sp_GetProductenPerBehandeling(
    IN p_behandeling_id INT
)
BEGIN
    SELECT
        P.Id,
        P.Naam,
        P.Merk,
        P.Omschrijving,
        P.EANcode,
        P.VerkoopPrijs,
        V.AantalOpVoorraad
    FROM BehandelingPerVoorraad AS BPV
    INNER JOIN Voorraad AS V ON V.Id = BPV.VoorraadId
    INNER JOIN Product AS P ON P.Id = V.ProductId
    WHERE BPV.BehandelingId = p_behandeling_id
      AND BPV.IsActief = 1
      AND V.IsActief = 1
      AND P.IsActief = 1
    ORDER BY P.Naam ASC;
END$$

DELIMITER ;
