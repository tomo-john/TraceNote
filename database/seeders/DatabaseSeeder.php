<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Trace;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User
        User::factory()->create([
            'name' => 'john',
            'email' => 'john@gmail.com',
            'password' => Hash::make('john1234'),
        ]);

        User::factory()->create([
            'name' => 'pyon',
            'email' => 'pyon@gmail.com',
            'password' => Hash::make('pyon1234'),
        ]);

        // Trace
        Trace::factory()->create(); // デフォルト1件

        $user = User::find(1);

        Trace::factory()->create([
            'title' => 'PHP Array',
            'summary' => '2',
        ]);

        Trace::factory()->create([
            'title' => 'Collection',
            'summary' => '3',
        ]);

        Trace::factory()->create([
            'title' => 'map()',
            'summary' => '4',
        ]);

    }
}
