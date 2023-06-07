<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();

         $user = User::factory()->create([
             //'name' => 'Admin',
             'email' => 'admin@gmail.com',
         ]);
        $role = Role::create(['name' => 'admin']);
        $user->assignRole($role);
        Role::create(['name' => 'customer']);
    }
}
