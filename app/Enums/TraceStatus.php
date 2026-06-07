<?php

namespace App\Enums;

enum TraceStatus: string
{
    case DRAFT = 'draft';

    case RESEARCHING = 'researching';

    case UNDERSTOOD = 'understood';

    case PRACTICED = 'practiced';

    public function label(): string
    {
        return match($this) {
            self::DRAFT => '下書き',
            self::RESEARCHING => '調査中',
            self::UNDERSTOOD => '理解済み',
            self::PRACTICED => '実践済み',
        };
    }

    public function colorClass(): string
    {
        return match($this) {
            self::DRAFT => 'bg-slate-100 text-slate-700',
            self::RESEARCHING => 'bg-green-100 text-green-700',
            self::UNDERSTOOD => 'bg-blue-100 text-blue-700',
            self::PRACTICED => 'bg-red-100 text-red-700',
        };
    }

    public function iconClass(): string
    {
        return match($this) {
            self::DRAFT => 'fa-solid fa-file-pen',
            self::RESEARCHING => 'fa-solid fa-magnifying-glass',
            self::UNDERSTOOD => 'fa-regular fa-lightbulb',
            self::PRACTICED => 'fa-solid fa-dog',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn (self $status) => [
                'value' => $status->value,
                'label' => $status->label(),
            ],
            self::cases()
        );
    }

}
