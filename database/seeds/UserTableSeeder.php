<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Models\UserLevel;

use App\Role;
use App\Permission;
use App\Models\Coupon;
use App\Models\CouponRule;
use App\Models\CouponUsed;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('user_levels')->delete();

        // $user_level1 = UserLevel::create([
        //     'name' => '注册会员',
        //     'amount' => 0,
        //     'discount' => 100,
        //     'discribe' => '注册会员',
        //     'price' => 0,
        //     'account' => 0
        // ]);
        // UserLevel::create([
        //     'name' => '铜牌会员',
        //     'amount' => 1000,
        //     'discount' => 98,
        //     'discribe' => '铜牌会员',
        // ]);
        // UserLevel::create([
        //     'name' => '白银会员',
        //     'amount' => 3000,
        //     'discount' => 95,
        //     'discribe' => '白银会员',
        // ]);
        // UserLevel::create([
        //     'name' => '黄金会员',
        //     'amount' => 10000,
        //     'discount' => 92,
        //     'discribe' => '黄金会员',
        // ]);
        // UserLevel::create([
        //     'name' => '钻石会员',
        //     'amount' => 50000,
        //     'discount' => 88,
        //     'discribe' => '钻石会员',
        // ]);

        // $user2 = User::create([
        //     'name' => 'user',
        //     'mobile' => '18717160163',
        //     // 'email' => '18717160163@qq.com',
        //     'openid' => 'odh7zsgI75iT8FRh0fGlSojc9PWM',
        //     'password'=>Hash::make('123456*'),
        //     'user_level' => $user_level1->id,
        //     'account' => 0
        // ]);
    }
}
