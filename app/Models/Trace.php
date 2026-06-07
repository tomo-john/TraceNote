<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;
use App\Models\Tag;
use App\Enums\TraceStatus;

class Trace extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'summary',
        'content',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => TraceStatus::class,
        ];
    }

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
