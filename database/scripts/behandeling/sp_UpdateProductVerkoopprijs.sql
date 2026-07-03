-- *****************************************************************
-- Doel : Werk enkel de verkoopprijs van een product bij.
--        De 30%-marge validatie gebeurt in de Laravel-controller,
--        deze procedure voert alleen de update uit.
-- *****************************************************************

DROP PROCEDURE IF EXISTS sp_UpdateProductVerkoopprijs;

DELIMITER $$

CREATE PROCEDURE sp_UpdateProductVerkoopprijs(
    IN p_product_id INT,
    IN p_nieuwe_verkoopprijs DECIMAL(10,2)
)
BEGIN
    UPDATE Product
    SET
        VerkoopPrijs = p_nieuwe_verkoopprijs,
        DatumGewijzigd = SYSDATE(6)
    WHERE Id = p_product_id
      AND IsActief = 1;

    SELECT ROW_COUNT() AS affected;
END$$

DELIMITER ;
