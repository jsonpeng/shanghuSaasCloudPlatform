<?php

use Illuminate\Database\Seeder;

use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          $super_admin_user = Admin::create([
            'nickname' => '超级管理员',
            'mobile' => '13125110550',
            'password'=>Hash::make('zcjy123'),
            'type' => '管理员',
            'account'=>'zcjy'
        ]);
    }


}
