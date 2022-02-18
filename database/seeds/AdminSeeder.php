<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin')->insert([
            'name'=>'admin',
            'username'=>'admin',
            'email'=>'puspendu.developer@gmail.com',
            'password'=>Hash::make('admin123'),
            'phone'=>'123456890',
            'photo'=>''
        ]);
    }
}
