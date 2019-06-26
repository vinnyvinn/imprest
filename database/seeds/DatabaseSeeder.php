<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(SettingsTableSeeder::class);
         $this->call(UserTableSeeder::class);
         $this->call(ImprestLimitSeeder::class);
         $this->call(AccountSettingSeeder::class);
    }
}
