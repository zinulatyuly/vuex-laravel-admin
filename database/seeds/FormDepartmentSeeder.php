<?php

use Illuminate\Database\Seeder;

class FormDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('form_departments')->insert([
            'department' => 'Департамент HR'
        ]);
    }
}
