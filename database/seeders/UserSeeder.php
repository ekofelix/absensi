<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => Carbon::now()->toDateTimeString(),
                'is_admin' => '1',
                'password' => bcrypt('12345678'),
            ]
        );
        User::create(
            [
                'name' => 'karyawan',
                'email' => 'karyawan@gmail.com',
                'email_verified_at' => Carbon::now()->toDateTimeString(),
                'is_admin' => NULL,
                'password' => bcrypt('12345678'),
            ]
        );
    }
}
