DROP PROCEDURE IF EXISTS sp_GetAllAfspraken;

DELIMITER $$

CREATE PROCEDURE sp_GetAllAfspraken(
	IN p_status VARCHAR(50)
)
BEGIN
	SELECT
		A.Id,
		CONCAT(K.Voornaam, ' ', IFNULL(CONCAT(K.Tussenvoegsel, ' '), ''), K.Achternaam) AS KlantNaam,
		CONCAT(M.Voornaam, ' ', IFNULL(CONCAT(M.Tussenvoegsel, ' '), ''), M.Achternaam) AS MedewerkerNaam,
		B.Naam AS BehandelingNaam,
		A.Datum,
		A.Starttijd,
		B.Duurminuten,
		ADDTIME(A.Starttijd, SEC_TO_TIME(B.Duurminuten * 60)) AS Eindtijd,
		A.Afspraakstatus
	FROM Afspraak AS A
	INNER JOIN Klant AS K ON K.Id = A.KlantId
	INNER JOIN MedewerkerPerBehandeling AS MPB ON MPB.Id = A.MedewerkerPerBehandelingId
	INNER JOIN Medewerker AS M ON M.Id = MPB.MedewerkerId
	INNER JOIN Behandeling AS B ON B.Id = MPB.BehandelingId
	WHERE A.IsActief = 1
	  AND (p_status IS NULL OR p_status = '' OR A.Afspraakstatus = p_status)
	ORDER BY A.Datum DESC, A.Starttijd ASC;
END$$

DELIMITER ;
