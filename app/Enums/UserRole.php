<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case EDITOR = 'editor';
    case SOCIO = 'socio';
    case VISITANTE = 'visitante';

    /**
     * Human-friendly label for UI selects/badges.
     */
    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrador',
            self::EDITOR => 'Editor',
            self::SOCIO => 'Sócio',
            self::VISITANTE => 'Visitante',
        };
    }

    /**
     * All backing values — the single source of truth for validation.
     *
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Roles allowed into the admin panel.
     *
     * @return array<int, string>
     */
    public static function staff(): array
    {
        return [self::ADMIN->value, self::EDITOR->value];
    }
}
