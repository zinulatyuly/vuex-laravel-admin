<?php

use Illuminate\Database\Seeder;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('forms')->insert([
            'department_id' => 1,
            'type_id' => 1,
            'name' => 'Хотите сотрудничать?'
        ]);
    }
}
