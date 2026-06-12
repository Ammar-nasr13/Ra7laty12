<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::firstOrCreate(
            ['email' => 'admin@rahalaty.com'],
            [
                'name'     => 'المدير العام',
                'password' => Hash::make('123456789'),
                'role'     => 'super_admin',
            ]
        );
    }
}
