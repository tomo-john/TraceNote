<?php

namespace App\Enums;

enum TraceRelationType: string
{
    case PREREQUISITE = 'prerequisite';
    case CHILD = 'child';
    case RELATED = 'related';

    public function label(): string
    {
    }

    public function iconClass(): string
    {
    }

    public static function options(): array
    {
    }
}
