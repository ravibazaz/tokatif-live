<?php

use Illuminate\Database\Seeder;

class ShopCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        DB::table('shop_categories')->delete();
        DB::table('shop_categories')->insert([[
            'category_name'=>'Grocery Shop',
            'category_desc'=>'Grocery Shop',
            
        ],[
            'category_name'=>'Restaurant',
            'category_desc'=>'Restaurant',
            
        ],[
            'category_name'=>'Wine Shop',
            'category_desc'=>'Wine Shop',
            
        ]]);
    }
}
