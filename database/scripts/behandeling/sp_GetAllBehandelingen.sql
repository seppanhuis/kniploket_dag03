-- *****************************************************************
-- Doel : Haal alle behandelingen op, eventueel gefilterd op naam,
--        inclusief het aantal gekoppelde producten per behandeling.
-- Parameters:
--   p_filter -> 'alle' (of NULL) = alle behandelingen
--               'overig'        = behandelingen buiten de bekende soorten
--               anders          = exacte match op Behandeling.Naam
-- *****************************************************************

DROP PROCEDURE IF EXISTS sp_GetAllBehandelingen;

DELIMITER $$

CREATE PROCEDURE sp_GetAllBehandelingen(
    IN p_filter VARCHAR(100)
)
BEGIN
    SELECT
        B.Id,
        B.Naam,
        B.Omschrijving,
        B.Duurminuten,
        B.Prijs,
        (
            SELECT COUNT(DISTINCT V.ProductId)
            FROM BehandelingPerVoorraad AS BPV
            INNER JOIN Voorraad AS V ON V.Id = BPV.VoorraadId
            WHERE BPV.BehandelingId = B.Id
              AND BPV.IsActief = 1
        ) AS AantalProducten
    FROM Behandeling AS B
    WHERE B.IsActief = 1
      AND (
            p_filter IS NULL
            OR p_filter = 'alle'
            OR (p_filter = 'overig' AND B.Naam NOT IN ('Knippen', 'Combi behandelingen', 'Kleuren', 'Permanent', 'Extensions'))
            OR (p_filter NOT IN ('alle', 'overig') AND B.Naam = p_filter)
          )
    ORDER BY B.Naam ASC;
END$$

DELIMITER ;
