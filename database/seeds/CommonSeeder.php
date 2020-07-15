<?php

use App\Models\User\User;
use App\Models\Currency\Currency;
use Illuminate\Database\Seeder;

class CommonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'id' => 1,
                'first_name' => 'Admin',
                'last_name' => 'Yummi',
                'role' => \App\Enums\RoleEnum::ADMIN,
                'email' => 'admin@yummi.com',
                'password' => bcrypt('Admin1234'),
                'email_verified_at' => now(),
                'guest' => 0,
            ],
            [
                'id' => 2,
                'first_name' => 'Customer',
                'last_name' => 'Yummi',
                'role' => \App\Enums\RoleEnum::CUSTOMER,
                'email' => 'customer@yummi.com',
                'password' => bcrypt('Admin1234'),
                'email_verified_at' => now(),
                'guest' => 0,
            ],
        ]);

        Currency::insert([
            [
                'id' => 1,
                'name' => 'Euro',
                'symbol' => '€',
                'iso_code' => 'EUR',
                'numeric_iso_code' => '978',
                'conversion_rate' => 1,
                'active' => 1,
            ],
            [
                'id' => 2,
                'name' => 'US Dollar',
                'symbol' => '$',
                'iso_code' => 'USD',
                'numeric_iso_code' => '840',
                'conversion_rate' => 1.10,
                'active' => 1,
            ],
        ]);
    }
}
