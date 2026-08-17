<?php

declare(strict_types=1);

namespace Core;

use PDO;
use PDOException;

/**
 * Singleton de connexion à la base de données via PDO.
 */
class Database
{
    private static ?PDO $instance = null;

    private function __construct() {}

    /**
     * Retourne l'instance PDO unique (Singleton).
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $host     = $_ENV['DB_HOST']     ?? 'localhost';
            $dbname   = $_ENV['DB_NAME']     ?? 'klaxon';
            $user     = $_ENV['DB_USER']     ?? 'root';
            $password = $_ENV['DB_PASSWORD'] ?? '';
            $charset  = 'utf8mb4';

            $dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";

            try {
                self::$instance = new PDO($dsn, $user, $password, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                http_response_code(500);
                exit('Erreur de connexion à la base de données.');
            }
        }

        return self::$instance;
    }
}
