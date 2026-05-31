<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Tag;

class Trace extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'summary',
        'content',
        'status',
    ];

    // status
    const STATUS_DRAFT = 'draft';
    const STATUS_RESEARCHING = 'researching';
    const STATUS_UNDERSTOOD = 'understood';
    const STATUS_PRACTICED = 'practiced';

    public static function statuses(): array
    {
        return[
            self::STATUS_DRAFT => '下書き',
            self::STATUS_RESEARCHING => '調査中',
            self::STATUS_UNDERSTOOD => '理解済み',
            self::STATUS_PRACTICED => '実践済み',
        ];
    }

    public function statusLabel(): string
    {
        return self::statuses()[$this->status] ?? '不明';
    }

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
