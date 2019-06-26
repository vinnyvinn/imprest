<?php

use Illuminate\Database\Seeder;

class AccountSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        App\AccountSetting::create([
            'name'=>'CashBook',
            'account_id'=>App\AccountSetting::CASHBOOK,
        	]);        
        App\AccountSetting::create([
        	'name'=>'Petty Cash',
            'account_id'=>App\AccountSetting::PETTYCASH
        	]);
    }
}
