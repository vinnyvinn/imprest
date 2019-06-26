<?php

use Illuminate\Database\Seeder;

class ImprestLimitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\ImprestLimit::create([
        	'imprest_limit' => 1,
        	'description' => 'The number of imprests one can request before surrender'
        	]);
    }
}
