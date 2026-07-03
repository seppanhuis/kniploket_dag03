-- *****************************************************************
-- Doel : Haal het volledige medewerkerdetail op, inclusief account-
--        e-mail (users) en contactgegevens (Contact).
-- *****************************************************************

DROP PROCEDURE IF EXISTS sp_GetMedewerkerById;

DELIMITER $$

CREATE PROCEDURE sp_GetMedewerkerById(
    IN p_id INT
)
BEGIN
    SELECT
        M.Id,
        M.Voornaam,
        M.Tussenvoegsel,
        M.Achternaam,
        CONCAT_WS(' ', M.Voornaam, NULLIF(M.Tussenvoegsel, ''), M.Achternaam) AS VolledigeNaam,
        M.Specialisatie,
        M.Geboortedatum,
        M.Opmerking,
        U.email AS AccountEmail,
        C.Straatnaam,
        C.Huisnummer,
        C.Toevoeging,
        C.Postcode,
        C.Plaats,
        C.Mobiel,
        C.Email AS ContactEmail
    FROM Medewerker AS M
    INNER JOIN users AS U ON U.id = M.UserId
    LEFT JOIN MedewerkerPerContact AS MPC ON MPC.MedewerkerId = M.Id AND MPC.IsActief = 1
    LEFT JOIN Contact AS C ON C.Id = MPC.ContactId AND C.IsActief = 1
    WHERE M.Id = p_id
      AND M.IsActief = 1
    LIMIT 1;
END$$

DELIMITER ;
