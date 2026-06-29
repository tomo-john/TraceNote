<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trace_relations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('from_trace_id')
              ->constrained('traces')
              ->cascadeOnDelete();

            $table->foreignId('to_trace_id')
              ->constrained('traces')
              ->cascadeOnDelete();

            $table->string('relation_type');

            $table->timestamps();

            $table->unique([
                'from_trace_id',
                'to_trace_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trace_relations');
    }
};
