<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\MenuCategories;

class MenuCategoriesSeeder extends Seeder
{
    protected $menu;

    public function __construct(MenuCategories $menu){
        $this->menu = $menu;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'category_name' => 'Burgers',
                'status' => 1
            ],
            [
                'category_name' => 'Beverages',
                'status' => 1
            ],
            [
                'category_name' => 'Combo Meals',
                'status' => 1
            ]
        ];

        foreach($data as $k => $val){
            $this->menu->create($val);
        }
    }
}
