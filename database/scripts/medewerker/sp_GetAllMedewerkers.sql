-- *****************************************************************
-- Doel : Haal alle medewerkers op, eventueel gefilterd op specialisatie,
--        inclusief contactgegevens (join via MedewerkerPerContact -> Contact).
-- Parameters:
--   p_specialisatie -> 'alle' (of NULL) = alle medewerkers
--                       anders          = exacte match op Medewerker.Specialisatie
-- *****************************************************************

DROP PROCEDURE IF EXISTS sp_GetAllMedewerkers;

DELIMITER $$

CREATE PROCEDURE sp_GetAllMedewerkers(
    IN p_specialisatie VARCHAR(100)
)
BEGIN
    SELECT
        M.Id,
        CONCAT_WS(' ', M.Voornaam, NULLIF(M.Tussenvoegsel, ''), M.Achternaam) AS VolledigeNaam,
        M.Specialisatie,
        CONCAT_WS(' ', C.Straatnaam, C.Huisnummer) AS Adres,
        C.Postcode,
        C.Plaats,
        C.Mobiel,
        C.Email AS ContactEmail
    FROM Medewerker AS M
    INNER JOIN MedewerkerPerContact AS MPC ON MPC.MedewerkerId = M.Id AND MPC.IsActief = 1
    INNER JOIN Contact AS C ON C.Id = MPC.ContactId AND C.IsActief = 1
    WHERE M.IsActief = 1
      AND (
            p_specialisatie IS NULL
            OR p_specialisatie = 'alle'
            OR M.Specialisatie = p_specialisatie
          )
    ORDER BY M.Voornaam ASC, M.Achternaam ASC;
END$$

DELIMITER ;
