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
        $role = Role::create(['name' => 'Admin']);
        $user->assignRole($role);
        Role::create(['name' => 'Paiements DVT|DDI']);
        Role::create(['name' => "Exonerations"]);
        Role::create(['name' => "Paiements TM|CT"]);
        Role::create(['name' => "Livraison"]);
        Role::create(['name' => 'Customer']);
    }
}
