<?php

use Illuminate\Database\Seeder;

class FormDepartmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('form_department_types')->insert([
            [
                'department_id' => 1,
                'type' => 'Стать партнером'
            ],
            [
                'department_id' => 1,
                'type' => 'Отправить резюме'
            ],
            [
                'department_id' => 1,
                'type' => 'Вопрос о компании'
            ],
        ]);
    }
}
