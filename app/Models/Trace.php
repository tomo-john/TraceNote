<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trace extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'summary',
        'content',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
