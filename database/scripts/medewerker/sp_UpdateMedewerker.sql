-- *****************************************************************
-- Doel : Werk de gegevens van een medewerker en de bijbehorende
--        contactgegevens bij. De business-regel rondom minderjarigheid
--        en specialisatie "Permanent" wordt in de Laravel-controller
--        gecontroleerd (validatie hoort in de applicatielaag, niet in de SP).
-- *****************************************************************

DROP PROCEDURE IF EXISTS sp_UpdateMedewerker;

DELIMITER $$

CREATE PROCEDURE sp_UpdateMedewerker(
    IN p_id INT,
    IN p_voornaam VARCHAR(100),
    IN p_tussenvoegsel VARCHAR(50),
    IN p_achternaam VARCHAR(100),
    IN p_specialisatie VARCHAR(100),
    IN p_geboortedatum DATE,
    IN p_contact_email VARCHAR(150),
    IN p_straatnaam VARCHAR(150),
    IN p_huisnummer INT,
    IN p_toevoeging VARCHAR(20),
    IN p_postcode VARCHAR(20),
    IN p_plaats VARCHAR(100),
    IN p_mobiel VARCHAR(50),
    IN p_opmerking VARCHAR(255)
)
BEGIN
    DECLARE v_medewerker_affected INT DEFAULT 0;

    UPDATE Medewerker
    SET
        Voornaam = p_voornaam,
        Tussenvoegsel = p_tussenvoegsel,
        Achternaam = p_achternaam,
        Specialisatie = p_specialisatie,
        Geboortedatum = p_geboortedatum,
        Opmerking = p_opmerking,
        DatumGewijzigd = SYSDATE(6)
    WHERE Id = p_id
      AND IsActief = 1;

    SET v_medewerker_affected = ROW_COUNT();

    UPDATE Contact AS C
    INNER JOIN MedewerkerPerContact AS MPC ON MPC.ContactId = C.Id
    SET
        C.Straatnaam = p_straatnaam,
        C.Huisnummer = p_huisnummer,
        C.Toevoeging = p_toevoeging,
        C.Postcode = p_postcode,
        C.Plaats = p_plaats,
        C.Email = p_contact_email,
        C.Mobiel = p_mobiel,
        C.DatumGewijzigd = SYSDATE(6)
    WHERE MPC.MedewerkerId = p_id
      AND MPC.IsActief = 1
      AND C.IsActief = 1;

    SELECT v_medewerker_affected AS affected;
END$$

DELIMITER ;
