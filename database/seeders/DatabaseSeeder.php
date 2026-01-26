<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Employee
        $employee = User::create([
            'name' => 'Employee User',
            'email' => 'employee@example.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
        ]);

        $task = Task::create([
            'title' => 'Sample Task',
            'description' => 'This is a sample task.',
            'assigned_to' => $employee->id,
            'status' => 'pending',
            'priority' => 'high',
            'due_datetime' => now()->addDays(7),
        ]);

        Event::create([
            'name' => 'Sample Event',
            'date' => now()->addDays(3),
            'start_time' => '09:00:00',
            'end_time' => '10:00:00',
            'task_id' => $task->id,
            'assigned_to' => $employee->id,
        ]);
    }
}
