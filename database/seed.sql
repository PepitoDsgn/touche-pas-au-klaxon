-- ============================================================
-- TOUCHE PAS AU KLAXON - Jeu d'essais
-- ============================================================

USE klaxon;

-- ------------------------------------------------------------
-- Agences
-- ------------------------------------------------------------
INSERT INTO agences (nom) VALUES
    ('Paris'),
    ('Lyon'),
    ('Marseille'),
    ('Toulouse'),
    ('Nice'),
    ('Nantes'),
    ('Strasbourg'),
    ('Montpellier'),
    ('Bordeaux'),
    ('Lille'),
    ('Rennes'),
    ('Reims');

-- ------------------------------------------------------------
-- Users (mot de passe : Password1! pour tous les users)
-- ------------------------------------------------------------
INSERT INTO users (nom, prenom, telephone, email, password, role) VALUES
    ('Martin',    'Alexandre', '0612345678', 'alexandre.martin@email.fr',  '$2y$10$cLEwT8Ullpn6Ozn1XJabC.ElUGj.Wdl7i.9M6J2/5pm4nJ.U0Xcfq', 'user'),
    ('Dubois',    'Sophie',    '0698765432', 'sophie.dubois@email.fr',     '$2y$10$cLEwT8Ullpn6Ozn1XJabC.ElUGj.Wdl7i.9M6J2/5pm4nJ.U0Xcfq', 'user'),
    ('Bernard',   'Julien',    '0622446688', 'julien.bernard@email.fr',    '$2y$10$cLEwT8Ullpn6Ozn1XJabC.ElUGj.Wdl7i.9M6J2/5pm4nJ.U0Xcfq', 'user'),
    ('Moreau',    'Camille',   '0611223344', 'camille.moreau@email.fr',    '$2y$10$cLEwT8Ullpn6Ozn1XJabC.ElUGj.Wdl7i.9M6J2/5pm4nJ.U0Xcfq', 'user'),
    ('Lefèvre',   'Lucie',     '0777889900', 'lucie.lefevre@email.fr',     '$2y$10$cLEwT8Ullpn6Ozn1XJabC.ElUGj.Wdl7i.9M6J2/5pm4nJ.U0Xcfq', 'user'),
    ('Leroy',     'Thomas',    '0655443322', 'thomas.leroy@email.fr',      '$2y$10$cLEwT8Ullpn6Ozn1XJabC.ElUGj.Wdl7i.9M6J2/5pm4nJ.U0Xcfq', 'user'),
    ('Roux',      'Chloé',     '0633221199', 'chloe.roux@email.fr',        '$2y$10$cLEwT8Ullpn6Ozn1XJabC.ElUGj.Wdl7i.9M6J2/5pm4nJ.U0Xcfq', 'user'),
    ('Petit',     'Maxime',    '0766778899', 'maxime.petit@email.fr',      '$2y$10$cLEwT8Ullpn6Ozn1XJabC.ElUGj.Wdl7i.9M6J2/5pm4nJ.U0Xcfq', 'user'),
    ('Garnier',   'Laura',     '0688776655', 'laura.garnier@email.fr',     '$2y$10$cLEwT8Ullpn6Ozn1XJabC.ElUGj.Wdl7i.9M6J2/5pm4nJ.U0Xcfq', 'user'),
    ('Dupuis',    'Antoine',   '0744556677', 'antoine.dupuis@email.fr',    '$2y$10$cLEwT8Ullpn6Ozn1XJabC.ElUGj.Wdl7i.9M6J2/5pm4nJ.U0Xcfq', 'user'),
    ('Lefebvre',  'Emma',      '0699887766', 'emma.lefebvre@email.fr',     '$2y$10$cLEwT8Ullpn6Ozn1XJabC.ElUGj.Wdl7i.9M6J2/5pm4nJ.U0Xcfq', 'user'),
    ('Fontaine',  'Louis',     '0655667788', 'louis.fontaine@email.fr',    '$2y$10$cLEwT8Ullpn6Ozn1XJabC.ElUGj.Wdl7i.9M6J2/5pm4nJ.U0Xcfq', 'user'),
    ('Chevalier', 'Clara',     '0788990011', 'clara.chevalier@email.fr',   '$2y$10$cLEwT8Ullpn6Ozn1XJabC.ElUGj.Wdl7i.9M6J2/5pm4nJ.U0Xcfq', 'user'),
    ('Robin',     'Nicolas',   '0644332211', 'nicolas.robin@email.fr',     '$2y$10$cLEwT8Ullpn6Ozn1XJabC.ElUGj.Wdl7i.9M6J2/5pm4nJ.U0Xcfq', 'user'),
    ('Gauthier',  'Marine',    '0677889922', 'marine.gauthier@email.fr',   '$2y$10$cLEwT8Ullpn6Ozn1XJabC.ElUGj.Wdl7i.9M6J2/5pm4nJ.U0Xcfq', 'user'),
    ('Fournier',  'Pierre',    '0722334455', 'pierre.fournier@email.fr',   '$2y$10$cLEwT8Ullpn6Ozn1XJabC.ElUGj.Wdl7i.9M6J2/5pm4nJ.U0Xcfq', 'user'),
    ('Girard',    'Sarah',     '0688665544', 'sarah.girard@email.fr',      '$2y$10$cLEwT8Ullpn6Ozn1XJabC.ElUGj.Wdl7i.9M6J2/5pm4nJ.U0Xcfq', 'user'),
    ('Lambert',   'Hugo',      '0611223366', 'hugo.lambert@email.fr',      '$2y$10$cLEwT8Ullpn6Ozn1XJabC.ElUGj.Wdl7i.9M6J2/5pm4nJ.U0Xcfq', 'user'),
    ('Masson',    'Julie',     '0733445566', 'julie.masson@email.fr',      '$2y$10$cLEwT8Ullpn6Ozn1XJabC.ElUGj.Wdl7i.9M6J2/5pm4nJ.U0Xcfq', 'user'),
    ('Henry',     'Arthur',    '0666554433', 'arthur.henry@email.fr',      '$2y$10$cLEwT8Ullpn6Ozn1XJabC.ElUGj.Wdl7i.9M6J2/5pm4nJ.U0Xcfq', 'user'),
    -- Compte administrateur (mot de passe : Admin1234!)
    ('Admin',     'Super',     '0600000000', 'admin@klaxon.fr',            '$2y$10$4VyoiPqb7DRiJla78dJ3aew2bGrK/UpqTWwJeZb0HAeOE2DZKiOfu', 'admin');

-- ------------------------------------------------------------
-- Trajets (dates futures à partir de 2026-09-01)
-- ------------------------------------------------------------
INSERT INTO trajets (agence_depart_id, agence_arrivee_id, gdh_depart, gdh_arrivee, places_totales, places_disponibles, user_id) VALUES
    (1, 2, '2026-09-01 07:00:00', '2026-09-01 11:30:00', 4, 3, 1),
    (2, 3, '2026-09-02 06:30:00', '2026-09-02 09:00:00', 3, 1, 2),
    (1, 4, '2026-09-03 08:00:00', '2026-09-03 14:00:00', 5, 5, 3),
    (5, 1, '2026-09-04 17:00:00', '2026-09-04 22:00:00', 4, 2, 4),
    (6, 2, '2026-09-05 06:00:00', '2026-09-05 09:30:00', 3, 3, 5),
    (3, 7, '2026-09-08 07:30:00', '2026-09-08 14:00:00', 4, 4, 6),
    (2, 1, '2026-09-09 18:00:00', '2026-09-09 22:30:00', 5, 1, 7),
    (4, 9, '2026-09-10 07:00:00', '2026-09-10 09:30:00', 3, 2, 8),
    (10, 1, '2026-09-11 06:30:00', '2026-09-11 10:00:00', 4, 4, 9),
    (1, 11, '2026-09-12 07:00:00', '2026-09-12 11:30:00', 3, 0, 10),
    (8, 3, '2026-09-15 08:00:00', '2026-09-15 09:30:00', 4, 3, 11),
    (1, 12, '2026-09-16 06:00:00', '2026-09-16 07:45:00', 5, 5, 12),
    (2, 6, '2026-09-17 17:30:00', '2026-09-17 21:00:00', 3, 2, 1),
    (7, 2, '2026-09-18 07:00:00', '2026-09-18 13:30:00', 4, 1, 3),
    (9, 4, '2026-09-19 08:30:00', '2026-09-19 11:00:00', 5, 4, 5);
