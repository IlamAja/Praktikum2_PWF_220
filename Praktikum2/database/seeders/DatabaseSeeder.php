<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        $users = User::factory(100)->create();

        Todo::factory()->count(100)->make()->each(function ($todo) use ($admin) {
            $todo->user_id = $admin->id;
            $todo->save();
        });

        Todo::factory()->count(400)->make()->each(function ($todo) use ($users) {
            $todo->user_id = $users->random()->id;
            $todo->save();
        });
    }
}
