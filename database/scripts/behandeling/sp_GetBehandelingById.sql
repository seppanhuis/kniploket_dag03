-- *****************************************************************
-- Doel : Haal één behandeling op basis van Id op (voor breadcrumb/titel).
-- *****************************************************************

DROP PROCEDURE IF EXISTS sp_GetBehandelingById;

DELIMITER $$

CREATE PROCEDURE sp_GetBehandelingById(
    IN p_id INT
)
BEGIN
    SELECT
        B.Id,
        B.Naam,
        B.Omschrijving,
        B.Duurminuten,
        B.Prijs
    FROM Behandeling AS B
    WHERE B.Id = p_id
      AND B.IsActief = 1;
END$$

DELIMITER ;
