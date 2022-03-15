<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'first_name' => 'Mohiuddin',
            'last_name' => 'Sagor',
            'gender' => 'm',
            'email' => 'admin@3dClub.com',
            'password' => bcrypt('12345678'),
            'role' => 1,
            'email_verified_at' => now()
        ];
        User::create($user);
    }
}
