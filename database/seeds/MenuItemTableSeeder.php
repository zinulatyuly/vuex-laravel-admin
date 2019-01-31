<?php

use Illuminate\Database\Seeder;

class MenuItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_items')->insert([
            [
                'menu_id' => 1,
                'title' => 'Tree Element',
                'url' => '#',
                'has_children' => 1,
                'parent_id' => 0
            ],
            [
                'menu_id' => 1,
                'title' => 'Tree Element',
                'url' => '#',
                'has_children' => 0,
                'parent_id' => 1
            ]
        ]);
    }
}
