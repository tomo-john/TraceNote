<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
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

    public function prerequisiteTraces(): Collection
    {
        return $this->incomingRelations()
                    ->where('relation_type', TraceRelationType::PREREQUISITE)
                    ->with('fromTrace')
                    ->get()
                    ->pluck('fromTrace');
    }

    public function childTraces(): Collection
    {
        return $this->outgoingRelations()
                    ->where('relation_type', TraceRelationType::CHILD)
                    ->with('toTrace')
                    ->get()
                    ->pluck('toTrace');
    }

    public function relatedTraces(): Collection
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

    // 検証
    public function addPrerequisite(Trace $selectedTrace): TraceRelation
    {
        return $this->incomingRelations()
                    ->create([
                        'from_trace_id' => $selectedTrace->id,
                        'relation_type' => TraceRelationType::PREREQUISITE
                    ]);
    }

    // テスト用
    public function test(Trace $selectedTrace): TraceRelation
    {
        return $this->incomingRelations()
                    ->create([
                        'from_trace_id' => $selectedTrace->id,
                        'relation_type' => TraceRelationType::PREREQUISITE
                    ]);
    }
}
