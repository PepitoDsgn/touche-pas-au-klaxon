<?php

declare(strict_types=1);

namespace Core;

/**
 * Gestion de la session PHP et des messages flash.
 */
class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public static function destroy(): void
    {
        session_destroy();
        $_SESSION = [];
    }

    /** Enregistre un message flash (affiché une seule fois). */
    public static function setFlash(string $key, string $message): void
    {
        $_SESSION['_flash'][$key] = $message;
    }

    /** Récupère et supprime un message flash. */
    public static function getFlash(string $key): ?string
    {
        $message = $_SESSION['_flash'][$key] ?? null;
        unset($_SESSION['_flash'][$key]);
        return $message;
    }

    public static function hasFlash(string $key): bool
    {
        return isset($_SESSION['_flash'][$key]);
    }

    /** Retourne l'utilisateur connecté ou null. */
    public static function getUser(): ?array
    {
        /** @var array<string, mixed>|null */
        return $_SESSION['user'] ?? null;
    }

    /** Indique si un utilisateur est connecté. */
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }

    /** Indique si l'utilisateur connecté est administrateur. */
    public static function isAdmin(): bool
    {
        return ($_SESSION['user']['role'] ?? '') === 'admin';
    }
}
