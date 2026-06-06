<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;
use App\Models\Trace;

class Tag extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'color',
    ];

    public static function colors(): array
    {
        return [
            'gray'   => 'グレー',
            'red'    => 'レッド',
            'blue'   => 'ブルー',
            'green'  => 'グリーン',
            'orange' => 'オレンジ',
            'pink'   => 'ピンク',
            'purple' => 'パープル',
        ];
    }

    public function colorClasses(): array
    {
        return [
            'gray'    => 'bg-slate-100 text-slate-700'
            'red'     => 'bg-red-100 text-red-700',
            'blue'    => 'bg-blue-100 text-blue-700',
            'green'   => 'bg-green-100 text-green-700',
            'orange'  => 'bg-orange-100 text-orange-700',
            'pink'    => 'bg-pink-100 text-pink-700',
            'purple'  => 'bg-purple-100 text-purple-700',
        ];
    }

    public function colorClass(): string
    {
        return self::colorClasses()[$this->color] ?? self::colorClasses()['gray'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function traces(): BelongsToMany
    {
        return $this->belongsToMany(Trace::class);
    }
}
