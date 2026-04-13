<?php

namespace Database\Seeders;

use App\Models\User;
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
        if (app()->environment('local')) {
            User::factory(10)->create();
        }

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@chatway.com',
            'password' => Hash::make('chatway@admin1'),
        ]);
    }
}
