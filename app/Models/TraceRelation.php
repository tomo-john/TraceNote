<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Trace;

class TraceRelation extends Model
{
    protected $fillable = [
        'from_trace_id',
        'to_trace_id',
        'relation_type',
    ];

    public function fromTrace() :BelongsTo
    {
        return $this->belongsTo(Trace::class, 'from_trace_id');
    }

    public function toTrace() :BelongsTo
    {
        return $this->belongsTo(Trace::class, 'to_trace_id');
    }
}
