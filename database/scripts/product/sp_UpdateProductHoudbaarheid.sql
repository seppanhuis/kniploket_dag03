-- *****************************************************************************************************
-- Doel : Werk de houdbaarheidsdatum van een product bij (pagina "Product wijzigen")
-- *****************************************************************************************************

DROP PROCEDURE IF EXISTS sp_UpdateProductHoudbaarheid;

DELIMITER $$

CREATE PROCEDURE sp_UpdateProductHoudbaarheid(
	IN p_id INT,
	IN p_nieuwe_houdbaarheidsdatum DATE
)
BEGIN
	UPDATE Product
	SET
		Houdbaarheidsdatum = p_nieuwe_houdbaarheidsdatum,
		DatumGewijzigd = SYSDATE(6)
	WHERE Id = p_id;

	SELECT ROW_COUNT() AS affected;
END$$

DELIMITER ;
