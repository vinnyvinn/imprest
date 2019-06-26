<?php

use App\Setting;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('settings')->insert([
            [
                'name' => Setting::DEPARTMENT_UDF,
                'value' => 'Physical1',
                'default' => 'Physical1',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => Setting::DESIGNATION_UDF,
                'value' => 'Physical2',
                'default' => 'Physical2',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => Setting::PERSONAL_NUMBER_UDF,
                'value' => 'Physical3',
                'default' => 'Physical3',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);


    }
}
