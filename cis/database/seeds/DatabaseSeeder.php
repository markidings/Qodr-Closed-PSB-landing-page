<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Role;
use App\Models\City;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->runSuperAdminSeeder();
        $this->runCitySeeder();
    }

    public function runSuperAdminSeeder()
    {
        $adminSystem = User::create([
            'role' => Role::ADMIN_SYSTEM,
            'email' => 'superadmin@mail.com',
            'password' => 'password',
            'is_verified' => true,
            'name' => 'Superadmin'
        ]);
    }

    public function runCitySeeder()
    {
        $citiesData = [
            [
                'name' => 'Kota Yogyakarta'
            ], [
                'name' => 'Kota Surakarta'
            ], [
                'name' => 'Kabupaten Sleman'
            ], [
                'name' => 'Kabupaten Bandung'
            ], [
                'name' => 'Kota Bandung'
            ]
        ];

        City::insert($citiesData);
    }
}
