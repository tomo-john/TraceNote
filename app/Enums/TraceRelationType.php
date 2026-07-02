<?php

namespace App\Enums;

enum TraceRelationType: string
{
    case PREREQUISITE = 'prerequisite';
    case CHILD = 'child';
    case RELATED = 'related';

    public function label(): string
    {
        return match($this) {
            self::PREREQUISITE => '前提知識',
            self::CHILD => '子知識',
            self::RELATED => '関連知識',
        };
    }

    public function iconClass(): string
    {
    }

    public static function options(): array
    {
    }
}
