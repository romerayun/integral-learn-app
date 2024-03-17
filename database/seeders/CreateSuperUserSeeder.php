<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateSuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superUser = User::create([
            'surname' => 'Админов',
            'name' => 'Админ',
            'patron' => 'Админович',
            'email' => 'superuser@info.ru',
            'phone' => '+7 (999) 999-99-99',
            'series_passport' => '9999',
            'number_passport' => '999999',
            'date_of_birth' => '1999-12-31',
            'snils' => '999-999-999 99',
            'sex' => 'M',
            'nationality' => '643',
            'password' => Hash::make('1234567890'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Role::create([
            'name' => 'super-user',
            'color' => 'primary',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $superUser->assignRole('super-user');
    }
}
