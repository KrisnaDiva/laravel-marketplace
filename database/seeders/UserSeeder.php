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
        User::create([
            'name' => 'krisna',
            'email' => 'krisnadiva04@gmail.com',
            'phone_number'=>'089658444101',
            'email_verified_at'=>now(),
            'password'=>Hash::make('12345678'),
        ]);
        User::create([
            'name' => 'enog',
            'email' => 'krisnadiva1234@gmail.com',
            'phone_number'=>'089658444102',
            'email_verified_at'=>now(),
            'password'=>Hash::make('12345678'),
        ]);
        User::create([
            'name' => 'inu',
            'email' => 'krisnadiva@gmail.com',
            'phone_number'=>'089658444103',
            'email_verified_at'=>now(),
            'password'=>Hash::make('12345678'),
        ]);
    }
}
