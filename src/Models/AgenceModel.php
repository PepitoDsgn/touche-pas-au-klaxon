<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Modèle de gestion des agences.
 */
class AgenceModel extends Model
{
    protected string $table = 'agences';

    /** Crée une nouvelle agence. */
    public function create(string $nom): bool
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (nom) VALUES (:nom)");
        return $stmt->execute(['nom' => $nom]);
    }

    /** Met à jour le nom d'une agence. */
    public function update(int $id, string $nom): bool
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET nom = :nom WHERE id = :id");
        return $stmt->execute(['nom' => $nom, 'id' => $id]);
    }

    /** Vérifie si le nom d'agence est déjà utilisé (pour un autre id). */
    public function nameExists(string $nom, ?int $excludeId = null): bool
    {
        if ($excludeId !== null) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM {$this->table} WHERE nom = :nom AND id != :id");
            $stmt->execute(['nom' => $nom, 'id' => $excludeId]);
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM {$this->table} WHERE nom = :nom");
            $stmt->execute(['nom' => $nom]);
        }

        return (int) $stmt->fetchColumn() > 0;
    }
}
