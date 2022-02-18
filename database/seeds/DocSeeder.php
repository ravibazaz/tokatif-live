<?php

use Illuminate\Database\Seeder;

class DocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('docs')->delete();
        DB::table('docs')->insert([[
            'title'=>'Address Prof',
            'slug'=>'address_prof',
            'desc'=>'Address Prof',
            'user_type'=>'both'
        ],[
            'title'=>'Trade Licence',
            'slug'=>'trade_licence',
            'desc'=>'Trade Licence',
            'user_type'=>'shop'
        ],[
            'title'=>'Driving licence (front)',
            'slug'=>'driving_licence_front',
            'desc'=>'Driving licence ',
            'user_type'=>'agent'
        ],[
            'title'=>'Driving licence (back)',
            'slug'=>'driving_licence_back',
            'desc'=>'Driving licence ',
            'user_type'=>'agent'
        ],[
            'title'=>'Passport',
            'slug'=>'passport',
            'desc'=>'Passport',
            'user_type'=>'both'
        ]]);
    }
}
