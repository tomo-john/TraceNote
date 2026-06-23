<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Tag;
use App\Models\TraceRelation;
use App\Enums\TraceStatus;
use App\Enums\TraceRelationType;

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

    public function outgoingRelations() :HasMany
    {
        return $this->HasMany(TraceRelation::class, 'from_trace_id');
    }

    public function incomingRelations() :HasMany
    {
        return $this->HasMany(TraceRelation::class, 'to_trace_id');
    }

    public function prerequisiteTraces()
    {
        return $this->incomingRelations()
                    ->where('relation_type', TraceRelationType::PREREQUISITE)
                    ->with('fromTrace')
                    ->get()
                    ->pluck('fromTrace');
    }

    public function childTraces()
    {
        return $this->outgoingRelations()
                    ->where('relation_type', TraceRelationType::CHILD)
                    ->with('toTrace')
                    ->get()
                    ->pluck('toTrace');
    }

    public function relatedTraces()
    {
        $incoming = $this->incomingRelations()
                         ->where('relation_type', TraceRelationType::RELATED)
                         ->with('fromTrace')
                         ->get()
                         ->pluck('fromTrace');

        $outgoing = $this->outgoingRelations()
                         ->where('relation_type', TraceRelationType::RELATED)
                         ->with('toTrace')
                         ->get()
                         ->pluck('toTrace');

        return $incoming->merge($outgoing)
                        ->unique('id')
                        ->values();

    }
}
