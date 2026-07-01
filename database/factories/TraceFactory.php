<?php

namespace Database\Factories;

use App\Models\Trace;
use App\Models\User;
use App\Enums\TraceStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Trace>
 */
class TraceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::find(1),
            'title' => 'タイトル',
            'summary' => '概要',
            'content' => '本文',
            'status' => TraceStatus::DRAFT,
        ];
    }
}
