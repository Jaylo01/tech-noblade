START TRANSACTION;

-- Add cost_price column
ALTER TABLE product_skus ADD COLUMN cost_price DECIMAL(10,2) DEFAULT 0.00 AFTER price;

-- Copy original Codashop rates to cost_price
UPDATE product_skus SET cost_price = price;

-- Apply smart tiered markup (Profit Margin)
-- Tier 1: Cheap items (<= 100) -> add ₱10
UPDATE product_skus SET price = cost_price + 10 WHERE cost_price <= 100 AND cost_price > 0;

-- Tier 2: Mid-range items (101 to 500) -> add ₱25
UPDATE product_skus SET price = cost_price + 25 WHERE cost_price > 100 AND cost_price <= 500;

-- Tier 3: Expensive items (> 500) -> add ₱50
UPDATE product_skus SET price = cost_price + 50 WHERE cost_price > 500;

COMMIT;
