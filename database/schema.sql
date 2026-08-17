-- ============================================================
-- TOUCHE PAS AU KLAXON - Schéma de base de données
-- ============================================================

CREATE DATABASE IF NOT EXISTS klaxon CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE klaxon;

-- ------------------------------------------------------------
-- Table : agences
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS agences (
    id   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom  VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Table : users
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom        VARCHAR(100) NOT NULL,
    prenom     VARCHAR(100) NOT NULL,
    telephone  VARCHAR(20)  NOT NULL,
    email      VARCHAR(255) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    role       ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Table : trajets
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS trajets (
    id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    agence_depart_id    INT UNSIGNED NOT NULL,
    agence_arrivee_id   INT UNSIGNED NOT NULL,
    gdh_depart          DATETIME NOT NULL,
    gdh_arrivee         DATETIME NOT NULL,
    places_totales      TINYINT UNSIGNED NOT NULL,
    places_disponibles  TINYINT UNSIGNED NOT NULL,
    user_id             INT UNSIGNED NOT NULL,
    created_at          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_trajet_depart  FOREIGN KEY (agence_depart_id)  REFERENCES agences(id),
    CONSTRAINT fk_trajet_arrivee FOREIGN KEY (agence_arrivee_id) REFERENCES agences(id),
    CONSTRAINT fk_trajet_user    FOREIGN KEY (user_id)           REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT chk_agences_diff  CHECK (agence_depart_id <> agence_arrivee_id),
    CONSTRAINT chk_dates_ordre   CHECK (gdh_arrivee > gdh_depart),
    CONSTRAINT chk_places        CHECK (places_disponibles <= places_totales)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
