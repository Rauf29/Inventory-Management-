<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        User::create( [
            'name'     => 'Admin',
            'email'    => 'admin.com',
            'mobile'   => '12345543221',
            'password' => '12345',
        ] );
    }
}
