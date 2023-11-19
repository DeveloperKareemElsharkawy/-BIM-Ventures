<?php

namespace App\Enums;

/**
 * Enum representing different user roles.
 */
enum RoleEnum: int
{
    public const SuperAdmin = 1;
    public const Admin = 2;

    /**
     * Get the string representation of the role.
     */
    public function toString(): string
    {
        return match ($this) {
            self::SuperAdmin => 'SuperAdmin',
            self::Admin => 'Admin',
            default => 'Unknown',
        };
    }

    /**
     * Get the role as a constant string.
     */
    public function toConstantString(): string
    {
        return match ($this) {
            self::SuperAdmin => self::SuperAdmin,
            self::Admin => self::Admin,
            default => 'Unknown',
        };
    }
}

