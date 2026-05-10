START TRANSACTION;

-- Revert price back to the original Codashop rate
UPDATE product_skus SET price = cost_price;

-- Remove the cost_price column
ALTER TABLE product_skus DROP COLUMN cost_price;

COMMIT;
