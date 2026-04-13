<?php

namespace Database\Seeders;

use App\Models\Poll;
use App\Models\PollOption;
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
            $user = User::factory()->create();
            $polls = Poll::factory()
                ->count(10)
                ->for($user, 'user')
                ->create();
            
            foreach($polls as $poll) {
                PollOption::factory()
                ->count(3)
                ->for($poll)
                ->create();
            }
        }

        User::updateOrCreate(
            [
                'name' => 'Admin'
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@chatway.com',
                'password' => Hash::make('chatway@admin1'),
            ]
        );
    }
}
