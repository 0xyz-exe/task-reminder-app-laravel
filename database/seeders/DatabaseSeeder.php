<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Reminder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Due reminders
        Reminder::create([
            'user_id' => $user->id,
            'title' => 'Submit quarterly report',
            'description' => 'Q3 financial report due to management',
            'due_date' => now()->subHours(2),
            'remind_at' => now()->subHours(3),
        ]);

        Reminder::create([
            'user_id' => $user->id,
            'title' => 'Team meeting preparation',
            'description' => 'Prepare slides for tomorrow meeting',
            'due_date' => now()->subHour(),
            'remind_at' => now()->subHours(2),
        ]);

        // Upcoming reminders
        Reminder::create([
            'user_id' => $user->id,
            'title' => 'Client presentation',
            'description' => 'Final pitch to ABC Corp',
            'due_date' => now()->addDays(2),
            'remind_at' => now()->addDay(),
        ]);

        Reminder::create([
            'user_id' => $user->id,
            'title' => 'Project milestone review',
            'description' => 'Review sprint progress with team',
            'due_date' => now()->addDays(5),
            'remind_at' => now()->addDays(4),
        ]);

        Reminder::create([
            'user_id' => $user->id,
            'title' => 'Annual performance review',
            'description' => 'Complete self-assessment form',
            'due_date' => now()->addWeek(),
        ]);

        // Completed reminders
        Reminder::create([
            'user_id' => $user->id,
            'title' => 'Update documentation',
            'description' => 'API docs updated to v2.0',
            'due_date' => now()->subDays(2),
            'completed' => true,
        ]);

        Reminder::create([
            'user_id' => $user->id,
            'title' => 'Code review',
            'description' => 'Review PR #123',
            'due_date' => now()->subDay(),
            'completed' => true,
        ]);
    }
}
