<?php

use Illuminate\Database\Seeder;


use App\Models\SingelPage;



class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //关注我们
        SingelPage::create(['name'=>'关注我们','slug'=>'weixin']);
        //店铺信息
        SingelPage::create(['name'=>'店铺信息','slug'=>'shopinfo']);
    }
}
