-- Fix CODM CP prices based on actual Garena PH shop rates
-- Source: https://shop.garena.ph/?app=100082
-- Garena PH GCash rates (base CP -> PHP price)

START TRANSACTION;

-- First, delete existing CODM SKUs that no longer match
DELETE FROM product_skus WHERE game = 'Call of Duty Mobile';

-- Insert correct CP packages with actual Garena PH prices
-- cost_price = Garena actual price, price = retail with tiered markup

-- Tier: <= ₱30  -> +₱2 markup (Garena PH has no packages this cheap, smallest is ₱10)
INSERT INTO product_skus (game, item_name, cost_price, price, stock) VALUES
('Call of Duty Mobile', '20 CP (16+4 Bonus)',   10.00,  12.00, 99),
('Call of Duty Mobile', '40 CP (32+8 Bonus)',   20.00,  22.00, 99),
('Call of Duty Mobile', '100 CP (80+20 Bonus)', 50.00,  55.00, 99),
('Call of Duty Mobile', '208 CP (160+48 Bonus)',100.00, 110.00,99),
('Call of Duty Mobile', '416 CP (320+96 Bonus)',200.00, 210.00,99),
('Call of Duty Mobile', '624 CP (480+144 Bonus)',300.00,310.00,99),
('Call of Duty Mobile', '1160 CP (800+360 Bonus)',500.00,520.00,99),
('Call of Duty Mobile', '2320 CP (1600+720 Bonus)',1000.00,1040.00,99);

COMMIT;
