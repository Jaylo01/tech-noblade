START TRANSACTION;

-- Add cost_price column
ALTER TABLE product_skus ADD COLUMN cost_price DECIMAL(10,2) DEFAULT 0.00 AFTER price;

-- Set cost_price to original price
UPDATE product_skus SET cost_price = price;

-- Apply recalibrated, sensible margins
-- <= 30 PHP -> add ₱2
UPDATE product_skus SET price = cost_price + 2 WHERE cost_price <= 30 AND cost_price > 0;

-- 31 to 100 PHP -> add ₱5
UPDATE product_skus SET price = cost_price + 5 WHERE cost_price > 30 AND cost_price <= 100;

-- 101 to 300 PHP -> add ₱10
UPDATE product_skus SET price = cost_price + 10 WHERE cost_price > 100 AND cost_price <= 300;

-- 301 to 700 PHP -> add ₱20
UPDATE product_skus SET price = cost_price + 20 WHERE cost_price > 300 AND cost_price <= 700;

-- 701 to 1500 PHP -> add ₱40
UPDATE product_skus SET price = cost_price + 40 WHERE cost_price > 700 AND cost_price <= 1500;

-- > 1500 PHP -> add ₱80
UPDATE product_skus SET price = cost_price + 80 WHERE cost_price > 1500;

COMMIT;
