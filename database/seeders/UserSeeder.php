<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->create([
            'name' => 'Shahlo',
            'email' => 'shahlo@gmail.com',
            'password' => Hash::make('wife'),
        ]);
        User::query()->create([
            'name' => 'Sherzod',
            'email' => 'sherzod@gmail.com',
            'password' => Hash::make('husband'),
        ]);
    }
}
