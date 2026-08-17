<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Modèle de gestion des trajets.
 */
class TrajetModel extends Model
{
    protected string $table = 'trajets';

    /**
     * Retourne tous les trajets futurs avec places disponibles,
     * enrichis des noms d'agences et de l'auteur, triés par date de départ.
     *
     * @return array<int, array<string, mixed>>
     */
    public function findAvailable(): array
    {
        $sql = "
            SELECT
                t.*,
                a_dep.nom  AS agence_depart,
                a_arr.nom  AS agence_arrivee,
                u.nom      AS user_nom,
                u.prenom   AS user_prenom,
                u.telephone AS user_telephone,
                u.email    AS user_email
            FROM trajets t
            JOIN agences a_dep ON t.agence_depart_id  = a_dep.id
            JOIN agences a_arr ON t.agence_arrivee_id = a_arr.id
            JOIN users   u     ON t.user_id           = u.id
            WHERE t.gdh_depart > NOW()
              AND t.places_disponibles > 0
            ORDER BY t.gdh_depart ASC
        ";

        return $this->db->query($sql)->fetchAll();
    }

    /**
     * Retourne tous les trajets futurs (y compris complets) pour un utilisateur connecté.
     *
     * @return array<int, array<string, mixed>>
     */
    public function findAllForUser(): array
    {
        $sql = "
            SELECT
                t.*,
                a_dep.nom  AS agence_depart,
                a_arr.nom  AS agence_arrivee,
                u.nom      AS user_nom,
                u.prenom   AS user_prenom,
                u.telephone AS user_telephone,
                u.email    AS user_email
            FROM trajets t
            JOIN agences a_dep ON t.agence_depart_id  = a_dep.id
            JOIN agences a_arr ON t.agence_arrivee_id = a_arr.id
            JOIN users   u     ON t.user_id           = u.id
            WHERE t.gdh_depart > NOW()
            ORDER BY t.gdh_depart ASC
        ";

        return $this->db->query($sql)->fetchAll();
    }

    /**
     * Retourne un trajet complet (avec agences et auteur) par son id.
     *
     * @return array<string, mixed>|null
     */
    public function findByIdFull(int $id): ?array
    {
        $sql = "
            SELECT
                t.*,
                a_dep.nom  AS agence_depart,
                a_arr.nom  AS agence_arrivee,
                u.nom      AS user_nom,
                u.prenom   AS user_prenom,
                u.telephone AS user_telephone,
                u.email    AS user_email
            FROM trajets t
            JOIN agences a_dep ON t.agence_depart_id  = a_dep.id
            JOIN agences a_arr ON t.agence_arrivee_id = a_arr.id
            JOIN users   u     ON t.user_id           = u.id
            WHERE t.id = :id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result !== false ? $result : null;
    }

    /**
     * Retourne tous les trajets pour l'admin (passés et futurs).
     *
     * @return array<int, array<string, mixed>>
     */
    public function findAllAdmin(): array
    {
        $sql = "
            SELECT
                t.*,
                a_dep.nom  AS agence_depart,
                a_arr.nom  AS agence_arrivee,
                u.prenom   AS user_prenom,
                u.nom      AS user_nom
            FROM trajets t
            JOIN agences a_dep ON t.agence_depart_id  = a_dep.id
            JOIN agences a_arr ON t.agence_arrivee_id = a_arr.id
            JOIN users   u     ON t.user_id           = u.id
            ORDER BY t.gdh_depart DESC
        ";

        return $this->db->query($sql)->fetchAll();
    }

    /**
     * Crée un nouveau trajet.
     *
     * @param array<string, mixed> $data
     */
    public function create(array $data): bool
    {
        $sql = "
            INSERT INTO {$this->table}
                (agence_depart_id, agence_arrivee_id, gdh_depart, gdh_arrivee,
                 places_totales, places_disponibles, user_id)
            VALUES
                (:agence_depart_id, :agence_arrivee_id, :gdh_depart, :gdh_arrivee,
                 :places_totales, :places_disponibles, :user_id)
        ";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    /**
     * Met à jour un trajet.
     *
     * @param array<string, mixed> $data
     */
    public function update(int $id, array $data): bool
    {
        $sql = "
            UPDATE {$this->table}
            SET agence_depart_id  = :agence_depart_id,
                agence_arrivee_id = :agence_arrivee_id,
                gdh_depart        = :gdh_depart,
                gdh_arrivee       = :gdh_arrivee,
                places_totales    = :places_totales,
                places_disponibles = :places_disponibles
            WHERE id = :id AND user_id = :user_id
        ";

        $data['id'] = $id;
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    /** Supprime un trajet (uniquement si l'utilisateur en est l'auteur). */
    public function deleteByIdAndUser(int $id, int $userId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id AND user_id = :user_id");
        return $stmt->execute(['id' => $id, 'user_id' => $userId]);
    }
}
