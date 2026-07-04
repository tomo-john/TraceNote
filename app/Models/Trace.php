<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\Tag;
use App\Models\TraceRelation;
use App\Enums\TraceStatus;
use App\Enums\TraceRelationType;

class Trace extends Model
{
    use HasFactory;

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

    /**
     * Relationships
     */
    public function outgoingRelations() :HasMany
    {
        return $this->HasMany(TraceRelation::class, 'from_trace_id');
    }

    public function incomingRelations() :HasMany
    {
        return $this->HasMany(TraceRelation::class, 'to_trace_id');
    }

    /**
     * Relation Operations
     *
     * TraceRelationを利用してrelation_typeごとのTrace一覧を取得
     */
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

    /**
     * Commnads
     *
     * Trace同士のリレーションを作成・削除
     */
    public function addPrerequisite(Trace $selectedTrace): TraceRelation
    {
        return $this->incomingRelations()
                    ->create([
                        'from_trace_id' => $selectedTrace->id,
                        'relation_type' => TraceRelationType::PREREQUISITE
                    ]);
    }

    public function addChild(Trace $selectedTrace): TraceRelation
    {
        return $this->outgoingRelations()
                    ->create([
                        'to_trace_id' => $selectedTrace->id,
                        'relation_type' => TraceRelationType::CHILD
                    ]);
    }

    public function addRelated(Trace $selectedTrace): TraceRelation
    {
        return $this->outgoingRelations()
                    ->create([
                        'to_trace_id' => $selectedTrace->id,
                        'relation_type' => TraceRelationType::RELATED
                    ]);
    }

    public function addRelation(Trace $selectedTrace, TraceRelationType $relationType): void
    {
        match($relationType) {
            TraceRelationType::PREREQUISITE => $this->addPrerequisite($selectedTrace),
            TraceRelationType::CHILD        => $this->addChild($selectedTrace),
            TraceRelationType::RELATED      => $this->addRelated($selectedTrace),
        };
    }

    public function removeRelation(Trace $relatedTrace): void
    {
        TraceRelation::query()
            ->where(function ($query) use ($relatedTrace) {
                $query->where('from_trace_id', $this->id)
                      ->where('to_trace_id', $relatedTrace->id);
            })
            ->orWhere(function ($query) use ($relatedTrace) {
                $query->where('from_trace_id', $relatedTrace->id)
                      ->where('to_trace_id', $this->id);
            })
            ->delete();
    }

    /**
     * Candidate Query
     *
     * リレーション候補となるTrace一覧を取得
     */
    public function availableRelationTraces(): Collection
    {
        $excludedIds = $this->incomingRelations()
                            ->pluck('from_trace_id')
                            ->merge(
                                $this->outgoingRelations()
                                     ->pluck('to_trace_id')
                            )
                            ->push($this->id)
                            ->unique()
                            ->values();

        return auth()->user()
                     ->traces()
                     ->whereNotIn('id', $excludedIds)
                     ->get();
    }

}
