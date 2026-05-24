<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trace extends Model
{
    protected $fillable = [
        'title',
        'summary',
        'content',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
