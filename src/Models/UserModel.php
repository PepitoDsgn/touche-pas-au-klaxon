<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Modèle de gestion des utilisateurs.
 */
class UserModel extends Model
{
    protected string $table = 'users';

    /**
     * Trouve un utilisateur par son email.
     *
     * @return array<string, mixed>|null
     */
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        return $result !== false ? $result : null;
    }

    /**
     * Vérifie les identifiants et retourne l'utilisateur si valides.
     *
     * @return array<string, mixed>|null
     */
    public function authenticate(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);

        if ($user === null) {
            return null;
        }

        if (!password_verify($password, $user['password'])) {
            return null;
        }

        return $user;
    }
}
