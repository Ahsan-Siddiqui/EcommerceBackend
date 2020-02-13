<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        DB::table('users')->truncate();

        $batch = [];

        $batch[0]['role_id'] = 1;
        $batch[0]['name'] = "Admin";
        $batch[0]['email'] = "admin@admin.com";
        $batch[0]['password'] = Hash::make('admin');

        $batch[1]['role_id'] = 2;
        $batch[1]['name'] = "Vendor";
        $batch[1]['email'] = "vendor@admin.com";
        $batch[1]['password'] = Hash::make('admin');

        $batch[2]['role_id'] = 1;
        $batch[2]['name'] = "Customer";
        $batch[2]['email'] = "customer@admin.com";
        $batch[2]['password'] = Hash::make('admin');
        
        User::insert($batch);
    }
}
