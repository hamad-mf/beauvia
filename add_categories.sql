-- Insert categories into the database
INSERT INTO categories (name, slug, icon, description, sort_order, is_active, created_at, updated_at) VALUES
('Hair Salon', 'hair-salon', '💇', 'Haircuts, styling, coloring & treatments', 1, 1, NOW(), NOW()),
('Nail Studio', 'nail-studio', '💅', 'Manicure, pedicure & nail art', 2, 1, NOW(), NOW()),
('Spa & Wellness', 'spa-wellness', '🧖', 'Massage, facials & body treatments', 3, 1, NOW(), NOW()),
('Barbershop', 'barbershop', '💈', 'Men''s cuts, shaves & grooming', 4, 1, NOW(), NOW()),
('Makeup Artist', 'makeup-artist', '💄', 'Bridal, editorial & everyday makeup', 5, 1, NOW(), NOW()),
('Skincare', 'skincare', '✨', 'Facials, peels & skin treatments', 6, 1, NOW(), NOW()),
('Massage', 'massage', '💆', 'Deep tissue, Swedish & therapeutic', 7, 1, NOW(), NOW()),
('Fitness', 'fitness', '🏋️', 'Personal training & yoga', 8, 1, NOW(), NOW())
ON CONFLICT (slug) DO NOTHING;
