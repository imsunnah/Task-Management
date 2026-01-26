<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Task;
use App\Models\Event;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Employees
        $emp1 = User::create([
            'name' => 'Employee 1',
            'email' => 'emp1@example.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
        ]);

        $emp2 = User::create([
            'name' => 'Employee 2',
            'email' => 'emp2@example.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
        ]);

        // Tasks
        $task1 = Task::create([
            'title' => 'Task 1',
            'description' => 'Description 1',
            'assigned_to' => $emp1->id,
            'status' => 'pending',
            'priority' => 'high',
            'due_datetime' => now()->addDays(3),
        ]);

        $task2 = Task::create([
            'title' => 'Task 2',
            'description' => 'Description 2',
            'assigned_to' => $emp2->id,
            'status' => 'in_progress',
            'priority' => 'medium',
            'due_datetime' => now()->addDays(5),
        ]);

        // Events
        Event::create([
            'name' => 'Event 1',
            'date' => now()->addDays(1),
            'start_time' => '09:00',
            'end_time' => '10:00',
            'task_id' => $task1->id,
            'assigned_to' => $emp1->id,
        ]);

        Event::create([
            'name' => 'Event 2',
            'date' => now()->addDays(2),
            'start_time' => '14:00',
            'end_time' => '15:00',
            'task_id' => null,
            'assigned_to' => $emp2->id,
        ]);
    }
}
