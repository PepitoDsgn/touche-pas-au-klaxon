<?php

declare(strict_types=1);

namespace App\Models;

use Core\Database;
use PDO;

/**
 * Modèle de base : fournit la connexion PDO et les méthodes CRUD génériques.
 */
abstract class Model
{
    protected PDO $db;

    /** @var string Nom de la table associée au modèle */
    protected string $table = '';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Retourne tous les enregistrements de la table.
     *
     * @return array<int, array<string, mixed>>
     */
    public function findAll(string $orderBy = 'id', string $direction = 'ASC'): array
    {
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY {$orderBy} {$direction}");
        return $stmt->fetchAll();
    }

    /**
     * Retourne un enregistrement par son id.
     *
     * @return array<string, mixed>|null
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result !== false ? $result : null;
    }

    /** Supprime un enregistrement par son id. */
    public function deleteById(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
