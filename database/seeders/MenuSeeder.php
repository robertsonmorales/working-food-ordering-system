<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    protected $menu;

    public function __construct(Menu $menu){
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
            // BURGER
            [
                'menu_category_id' => 1,
                'menu_img' => 'https://media-cldnry.s-nbcnews.com/image/upload/newscms/2020_27/1586837/hotdogs-te-main-200702.jpg',
                'menu_name' => 'Hotdog',
                'price' => 20,
                'status' => 1
            ],
            [
                'menu_category_id' => 1,
                'menu_img' => 'https://assets.epicurious.com/photos/5c745a108918ee7ab68daf79/5:4/w_3129,h_2503,c_limit/Smashburger-recipe-120219.jpg',
                'menu_name' => 'Cheeseburger',
                'price' => 26,
                'status' => 1
            ],
            [
                'menu_category_id' => 1,
                'menu_img' => 'https://static.toiimg.com/thumb/54659021.cms?imgsize=275086&width=800&height=800',
                'menu_name' => 'Fries',
                'price' => 35,
                'status' => 1
            ],
            // ENDS HERE

            // BEVERAGES
            [
                'menu_category_id' => 2,
                'menu_img' => 'https://cdn.shopify.com/s/files/1/2141/9909/products/Coke_Zero_330mL_1024x.png?v=1591901397',
                'menu_name' => 'Coke',
                'price' => 18,
                'status' => 1
            ],
            [
                'menu_category_id' => 2,
                'menu_img' => 'https://sc04.alicdn.com/kf/U54238631433c4e11ace6c7242c6026dd7.jpg',
                'menu_name' => 'Sprite',
                'price' => 18,
                'status' => 1
            ],
            [
                'menu_category_id' => 2,
                'menu_img' => 'https://www.aicr.org/wp-content/uploads/2020/06/peppermint-tea-on-teacup-1417945-1200x826.jpg.webp',
                'menu_name' => 'Tea',
                'price' => 20,
                'status' => 1
            ],
            // ENDS HERE

            // COMBO MEALS
            [
                'menu_category_id' => 3,
                'menu_img' => 'https://d1sag4ddilekf6.azureedge.net/compressed/items/PHGFSTI000000r9-C2BJJFTVNYCKJ2/photo/5ee15ce7597e48549b24fe7c859adfc7_1603364961963529733.jpeg',
                'menu_name' => 'Chicken Combo Meal',
                'price' => 90,
                'status' => 1
            ],
            [
                'menu_category_id' => 3,
                'menu_img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTGGe_44E31zA2w0PQoM1GY5k9kih5kbBiY0AjiJOYqghC1N0wo4WpB-VeS3I7s-10vnRk&usqp=CAU',
                'menu_name' => 'Pork Combo',
                'price' => 110,
                'status' => 1
            ],
            [
                'menu_category_id' => 3,
                'menu_img' => 'https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/delish-191907-air-fryer-fish-0282-portrait-pf-1565020342.png?crop=1.00xw:0.667xh;0,0.272xh&resize=480:*',
                'menu_name' => 'Fish Combo',
                'price' => 80,
                'status' => 1
            ]
        ];

        foreach($data as $k => $val){
            $this->menu->create($val);
        }
    }
}
