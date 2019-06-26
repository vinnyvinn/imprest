<?php

use Carbon\Carbon;
use App\User;
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: koi
 * Date: 12/2/16
 * Time: 8:18 AM
 */
class UserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name'     => 'Admin',
            'fname'     => 'Admin',
            'lname'     => 'Admin',
            'email'    => 'administrator',
            'password' => bcrypt('Qwerty123!'),
            'role_id'  => 1000,
            'emp_payroll_no'=>0,
            'permissions' => '[6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]',
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now()
        ]);
    }
}
