DROP PROCEDURE IF EXISTS sp_UpdateAfspraak;

DELIMITER $$

CREATE PROCEDURE sp_UpdateAfspraak(
	IN p_id INT,
	IN p_medewerkerId INT,
	IN p_behandelingId INT,
	IN p_datum DATE,
	IN p_starttijd TIME,
	IN p_status VARCHAR(50)
)
BEGIN
	DECLARE v_mpb_id INT DEFAULT NULL;
	DECLARE v_beschikbaarheid_id INT DEFAULT NULL;
	DECLARE v_conflict_count INT DEFAULT 0;
	DECLARE v_affected INT DEFAULT 0;

	-- Zoek de koppeling tussen deze medewerker en deze behandeling
	SELECT Id INTO v_mpb_id
	FROM MedewerkerPerBehandeling
	WHERE MedewerkerId = p_medewerkerId
	  AND BehandelingId = p_behandelingId
	  AND IsActief = 1
	LIMIT 1;

	IF v_mpb_id IS NULL THEN

		SELECT 0 AS Success, 'GEEN_KOPPELING' AS ErrorCode, 0 AS AffectedRows;

	ELSE

		-- Dubbele boeking check: heeft deze medewerker al een afspraak op deze datum/tijd?
		SELECT COUNT(*) INTO v_conflict_count
		FROM Afspraak AS A
		INNER JOIN MedewerkerPerBehandeling AS MPB ON MPB.Id = A.MedewerkerPerBehandelingId
		WHERE MPB.MedewerkerId = p_medewerkerId
		  AND A.Datum = p_datum
		  AND A.Starttijd = p_starttijd
		  AND A.Id <> p_id
		  AND A.IsActief = 1;

		IF v_conflict_count > 0 THEN

			SELECT 0 AS Success, 'DUBBELE_BOEKING' AS ErrorCode, 0 AS AffectedRows;

		ELSE

			-- Zoek passende beschikbaarheid voor de medewerker op de nieuwe datum
			SELECT Id INTO v_beschikbaarheid_id
			FROM Beschikbaarheid
			WHERE MedewerkerId = p_medewerkerId
			  AND Datum = p_datum
			  AND IsActief = 1
			LIMIT 1;

			IF v_beschikbaarheid_id IS NULL THEN
				SELECT BeschikbaarheidId INTO v_beschikbaarheid_id
				FROM Afspraak
				WHERE Id = p_id;
			END IF;

			UPDATE Afspraak
			SET MedewerkerPerBehandelingId = v_mpb_id,
				BeschikbaarheidId = v_beschikbaarheid_id,
				Datum = p_datum,
				Starttijd = p_starttijd,
				Afspraakstatus = p_status,
				DatumGewijzigd = SYSDATE(6)
			WHERE Id = p_id;

			SET v_affected = ROW_COUNT();

			SELECT 1 AS Success, NULL AS ErrorCode, v_affected AS AffectedRows;

		END IF;

	END IF;
END$$

DELIMITER ;
