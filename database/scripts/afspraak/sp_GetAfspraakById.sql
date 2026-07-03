DROP PROCEDURE IF EXISTS sp_GetAfspraakById;

DELIMITER $$

CREATE PROCEDURE sp_GetAfspraakById(
	IN p_id INT
)
BEGIN
	SELECT
		A.Id,
		K.Id AS KlantId,
		CONCAT(K.Voornaam, ' ', IFNULL(CONCAT(K.Tussenvoegsel, ' '), ''), K.Achternaam) AS KlantNaam,
		K.Relatienummer,
		C.Mobiel,
		C.Email,
		M.Id AS MedewerkerId,
		CONCAT(M.Voornaam, ' ', IFNULL(CONCAT(M.Tussenvoegsel, ' '), ''), M.Achternaam) AS MedewerkerNaam,
		B.Id AS BehandelingId,
		B.Naam AS BehandelingNaam,
		A.Datum,
		A.Starttijd,
		B.Duurminuten,
		ADDTIME(A.Starttijd, SEC_TO_TIME(B.Duurminuten * 60)) AS Eindtijd,
		A.Afspraakstatus
	FROM Afspraak AS A
	INNER JOIN Klant AS K ON K.Id = A.KlantId
	INNER JOIN KlantPerContact AS KPC ON KPC.KlantId = K.Id AND KPC.IsActief = 1
	INNER JOIN Contact AS C ON C.Id = KPC.ContactId
	INNER JOIN MedewerkerPerBehandeling AS MPB ON MPB.Id = A.MedewerkerPerBehandelingId
	INNER JOIN Medewerker AS M ON M.Id = MPB.MedewerkerId
	INNER JOIN Behandeling AS B ON B.Id = MPB.BehandelingId
	WHERE A.Id = p_id
	LIMIT 1;
END$$

DELIMITER ;
