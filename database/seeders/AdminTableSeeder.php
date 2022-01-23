<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminRecords = [
            [
                'id' =>1,
                'name' => 'admin',
                'type' => 'admin',
                'mobile' => '01798939226',
                'email' => 'admin@example.com',
                'password' => Hash::make('12345'),
                'image' => '',
                'status' => 1,
            ],
        ];

        foreach($adminRecords as $key => $record){
            Admin::create($record);
        }
        
    }
}
