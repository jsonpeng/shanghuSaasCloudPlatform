<?php

use Illuminate\Database\Seeder;

use App\Models\Admin;
use App\Role;
use App\Permission;

class RolePemessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   
    public function run()
    {
        
    	DB::table('admins')->delete();
        DB::table('permission_role')->delete();
        DB::table('permissions')->delete();
        DB::table('role_admin')->delete();
        DB::table('roles')->delete();

        $super_admin_user = Admin::create([
            'name' => '超级管理员',
            'email' => 'yyjz@foxmail.com',
            'password'=>Hash::make('zcjy123'),
            'type' => '超级管理员',
            'system_tag'=>1
        ]);


        $super_admin = Role::create([
            'name'=>'超级管理员',
            'display_name'=>'超级管理员',
            'description'=>'拥有最高权限，能控制一切'
        ]);


        /*系统下设置*/

        //网站设置
        $web_info_set=Permission::create(['name'=>'settings.*','slug'=>'system_web_info_settings', 'display_name'=>'网站信息设置', 'description'=>'所有页面和操作','tid'=>1,'model'=>'系统']);

        //横幅设置
        $banner_set=Permission::create(['name'=>'banners.*','slug'=>'system_banners_set', 'display_name'=>'横幅设置', 'description'=>'所有页面和操作','tid'=>1,'model'=>'系统']);
        $bannerItems_set=Permission::create(['name'=>'bannerItems.*','slug'=>'system_bannerItems_set', 'display_name'=>'横幅内页设置', 'description'=>'所有页面和操作','tid'=>1,'model'=>'系统']);
        //单页面
        $single_page_set=Permission::create(['name'=>'singelPages.*','slug'=>'system_single_page_set', 'display_name'=>'单页面设置', 'description'=>'所有页面和操作','tid'=>1,'model'=>'系统']);

        //客服设置
        $customer_service_set=Permission::create(['name'=>'customerServices.*','slug'=>'system_customer_service_set', 'display_name'=>'客服设置', 'description'=>'所有页面和操作','tid'=>1,'model'=>'系统']);

        //通知消息
        $notices_set=Permission::create(['name'=>'notices.*','slug'=>'notices_set', 'display_name'=>'通知设置', 'description'=>'所有页面和操作','tid'=>1,'model'=>'通知消息']);

        //钱包用户操作记录
        $withDrawls=Permission::create(['name'=>'withDrawls.*','slug'=>'system_withDrawls_set', 'display_name'=>'钱包用户操作记录', 'description'=>'所有页面和操作','tid'=>30,'model'=>'系统']);

        //会员管理
        $user_add=Permission::create(['name'=>'users.create','slug'=>'system_users_add', 'display_name'=>'添加会员页面', 'description'=>'页面','tid'=>3,'model'=>'系统']);
        $user_store=Permission::create(['name'=>'users.store','slug'=>'system_users_store', 'display_name'=>'添加会员操作', 'description'=>'操作','tid'=>3,'model'=>'系统']);
        $user_del=Permission::create(['name'=>'users.destroy','slug'=>'system_users_del', 'display_name'=>'删除会员操作', 'description'=>'操作','tid'=>3,'model'=>'系统']);
        $user_edit=Permission::create(['name'=>'users.edit','slug'=>'system_users_edit', 'display_name'=>'修改会员页面', 'description'=>'页面','tid'=>3,'model'=>'系统']);
        $user_update=Permission::create(['name'=>'users.update','slug'=>'system_users_update', 'display_name'=>'修改会员操作', 'description'=>'操作','tid'=>3,'model'=>'系统']);
        $user_list_show=Permission::create(['name'=>'users.index','slug'=>'system_users_list_show', 'display_name'=>'查看会员列表页面', 'description'=>'页面','tid'=>3,'model'=>'系统']);
        $user_show=Permission::create(['name'=>'users.show','slug'=>'system_users_show', 'display_name'=>'查看会员页面', 'description'=>'页面','tid'=>3,'model'=>'系统']);


        //会员等级管理
        $user_level_add=Permission::create(['name'=>'userLevels.create','slug'=>'system_userLevels_add', 'display_name'=>'添加会员等级页面', 'description'=>'页面','tid'=>4,'model'=>'系统']);
        $user_level_store=Permission::create(['name'=>'userLevels.store','slug'=>'system_userLevels_store', 'display_name'=>'添加会员等级操作', 'description'=>'操作','tid'=>4,'model'=>'系统']);
        $user_level_update=Permission::create(['name'=>'userLevels.update','slug'=>'system_userLevels_update', 'display_name'=>'修改会员等级操作', 'description'=>'操作','tid'=>4,'model'=>'系统']);
        $user_level_del=Permission::create(['name'=>'userLevels.destroy','slug'=>'system_userLevels_del', 'display_name'=>'删除会员等级操作', 'description'=>'操作','tid'=>4,'model'=>'系统']);
        $user_level_edit=Permission::create(['name'=>'userLevels.edit','slug'=>'system_userLevels_edit', 'display_name'=>'修改会员等级页面', 'description'=>'页面','tid'=>4,'model'=>'系统']);
        $user_level_list_show=Permission::create(['name'=>'userLevels.index','slug'=>'system_userLevels_list_show', 'display_name'=>'查看会员等级列表页面', 'description'=>'页面','tid'=>4,'model'=>'系统']);

        //微信菜单设置
        $wechat_menu_set=Permission::create(['name'=>'wechat.menu.*','slug'=>'system_wechat_menu_set', 'display_name'=>'微信菜单设置', 'description'=>'所有页面和操作','tid'=>5,'model'=>'系统']);

        //微信回复消息设置
        $wechat_reply_message_set=Permission::create(['name'=>'wechat.reply.*','slug'=>'system_wechat_reply_message_set', 'display_name'=>'微信回复消息设置', 'description'=>'所有页面和操作','tid'=>5,'model'=>'系统']);

        //银行卡设置
        $bank_set=Permission::create(['name'=>'bankSets.*','slug'=>'system_bank_set', 'display_name'=>'银行卡设置', 'description'=>'所有页面和操作','tid'=>1,'model'=>'系统']);

        //产地
        $countries=Permission::create(['name'=>'countries.*','slug'=>'system_countries_set', 'display_name'=>'产地设置', 'description'=>'所有页面和操作','tid'=>1,'model'=>'系统']);
        //移动端广告
        $advertiseMobiles=Permission::create(['name'=>'advertiseMobiles.*','slug'=>'system_bank_set', 'display_name'=>'移动端广告设置', 'description'=>'所有页面和操作','tid'=>1,'model'=>'系统']);

        //管理员设置
        $managers_add=Permission::create(['name'=>'managers.create','slug'=>'system_managers_add', 'display_name'=>'添加管理员页面', 'description'=>'页面','tid'=>8,'model'=>'系统']);
        $managers_del=Permission::create(['name'=>'managers.destroy','slug'=>'system_managers_del', 'display_name'=>'删除管理员操作', 'description'=>'操作','tid'=>8,'model'=>'系统']);
        $managers_store=Permission::create(['name'=>'managers.store','slug'=>'system_managers_store', 'display_name'=>'添加管理员操作', 'description'=>'操作','tid'=>8,'model'=>'系统']);
        $managers_update=Permission::create(['name'=>'managers.update','slug'=>'system_managers_update', 'display_name'=>'修改管理员操作', 'description'=>'操作','tid'=>8,'model'=>'系统']);
        $managers_edit=Permission::create(['name'=>'managers.edit','slug'=>'system_managers_edit', 'display_name'=>'修改管理员页面', 'description'=>'页面','tid'=>8,'model'=>'系统']);
        $managers_list_show=Permission::create(['name'=>'managers.index','slug'=>'system_managers_list_show', 'display_name'=>'查看管理员列表页面', 'description'=>'页面','tid'=>8,'model'=>'系统']);

        //角色设置
        $role_add=Permission::create(['name'=>'roles.create','slug'=>'system_roles_add', 'display_name'=>'添加角色页面', 'description'=>'页面','tid'=>9,'model'=>'系统']);
        $role_store=Permission::create(['name'=>'roles.store','slug'=>'system_roles_store', 'display_name'=>'添加角色操作', 'description'=>'操作','tid'=>9,'model'=>'系统']);  
        $role_del=Permission::create(['name'=>'roles.destroy','slug'=>'system_roles_del', 'display_name'=>'删除角色操作', 'description'=>'操作','tid'=>9,'model'=>'系统']);
        $role_update=Permission::create(['name'=>'roles.update','slug'=>'system_roles_update', 'display_name'=>'更新角色操作', 'description'=>'操作','tid'=>9,'model'=>'系统']);
        $role_edit=Permission::create(['name'=>'roles.edit','slug'=>'system_roles_edit', 'display_name'=>'修改角色页面', 'description'=>'页面','tid'=>9,'model'=>'系统']);
        $role_list_show=Permission::create(['name'=>'roles.index','slug'=>'system_roles_list_show', 'display_name'=>'查看角色列表页面', 'description'=>'页面','tid'=>9,'model'=>'系统']);

        //权限设置
        $perm_add=Permission::create(['name'=>'permissions.create','slug'=>'system_permissions_add', 'display_name'=>'添加权限页面', 'description'=>'页面','tid'=>24,'model'=>'系统']);
        $perm_store=Permission::create(['name'=>'permissions.store','slug'=>'system_permissions_store', 'display_name'=>'添加权限操作', 'description'=>'操作','tid'=>24,'model'=>'系统']);
        $perm_list_show=Permission::create(['name'=>'permissions.index','slug'=>'system_permissions_show', 'display_name'=>'查看权限列表页面', 'description'=>'页面','tid'=>24,'model'=>'系统']);

        //地区设置
        $cities_set=Permission::create(['name'=>'cities.*','slug'=>'system_cities_set', 'display_name'=>'地区设置', 'description'=>'所有页面和操作','tid'=>1,'model'=>'系统']);

        //运费模板设置
        $freightTems_set=Permission::create(['name'=>'freightTems.*','slug'=>'system_freightTems_set', 'display_name'=>'运费模板设置', 'description'=>'所有页面和操作','tid'=>1,'model'=>'系统']);

        //文章模板
        
        //模板文章分类设置
        $article_cat_set=Permission::create(['name'=>'articlecats.*','slug'=>'system_articlecats_set', 'display_name'=>'模板分类设置', 'description'=>'所有页面和操作','tid'=>31,'model'=>'系统']);
        //模板文章设置
        $article_set=Permission::create(['name'=>'posts.*','slug'=>'system_posts_set', 'display_name'=>'模板文章设置', 'description'=>'所有页面和操作','tid'=>31,'model'=>'系统']);
        //模板自定义文章设置
        $customPostTypes_set=Permission::create(['name'=>'customPostTypes.*','slug'=>'system_customPostTypes_set', 'display_name'=>'模板自定义文章设置', 'description'=>'所有页面和操作','tid'=>31,'model'=>'系统']);
        //模板自定义文章详情设置
        $customPostTypeItems_set=Permission::create(['name'=>'customPostTypeItems.*','slug'=>'system_customPostTypeItems_set', 'display_name'=>'模板自定义文章详情设置', 'description'=>'所有页面和操作','tid'=>31,'model'=>'系统']);
        //模板单页设置
        $pages_set=Permission::create(['name'=>'pages.*','slug'=>'system_pages_set', 'display_name'=>'模板单页设置', 'description'=>'所有页面和操作','tid'=>31,'model'=>'系统']);
        //模板自定义单页设置
        $customPageTypes_set=Permission::create(['name'=>'customPageTypes.*','slug'=>'system_customPageTypes_set', 'display_name'=>'模板自定义单页设置', 'description'=>'所有页面和操作','tid'=>31,'model'=>'系统']);
         //模板自定义单页详情设置
        $pageItems_set=Permission::create(['name'=>'pageItems.*','slug'=>'system_pageItems_set', 'display_name'=>'模板自定义单页详情设置', 'description'=>'所有页面和操作','tid'=>31,'model'=>'系统']);


        /*
         * 分销下
         */
        //分销设置
        $distributions_set=Permission::create(['name'=>'distributions.*','slug'=>'system_distributions_set', 'display_name'=>'分销设置', 'description'=>'所有页面和操作','tid'=>27,'model'=>'分销']);
        //分销日志
        $distributionLogs_set=Permission::create(['name'=>'distributionLogs.*','slug'=>'system_distributionLogs_set', 'display_name'=>'分销日志设置', 'description'=>'所有页面和操作','tid'=>27,'model'=>'分销']);

        /*商城下*/

        //商城统计信息
        $all_statics_show=Permission::create(['name'=>'stat.*','slug'=>'shop_all_statics_show', 'display_name'=>'查看商城统计信息页面', 'description'=>'页面','tid'=>10,'model'=>'商城','model'=>'商城']);
        //订单管理
        $order_del=Permission::create(['name'=>'orders.destroy','slug'=>'shop_orders_del', 'display_name'=>'删除订单操作', 'description'=>'操作','tid'=>11,'model'=>'商城']);
        $order_one_show=Permission::create(['name'=>'orders.show','slug'=>'shop_orders_edit', 'display_name'=>'详细订单页面', 'description'=>'页面','tid'=>11,'model'=>'商城']);
        $order_edit=Permission::create(['name'=>'orders.edit','slug'=>'shop_orders_edit', 'display_name'=>'修改订单页面', 'description'=>'页面','tid'=>11,'model'=>'商城']);
        $order_update=Permission::create(['name'=>'orders.update','slug'=>'shop_orders_update', 'display_name'=>'修改订单操作', 'description'=>'操作','tid'=>11,'model'=>'商城']);
        $order_list_show=Permission::create(['name'=>'orders.index','slug'=>'shop_orders_list_show', 'display_name'=>'查看订单列表页面', 'description'=>'页面','tid'=>11,'model'=>'商城']);
        $order_orderCancels=Permission::create(['name'=>'orderCancels.*','slug'=>'shop_orders_orderCancels', 'display_name'=>'订单退款管理', 'description'=>'所有页面和操作','tid'=>11,'model'=>'商城']);
        $order_orderRefunds=Permission::create(['name'=>'orderRefunds.*','slug'=>'shop_orders_orderRefunds', 'display_name'=>'订单退换货管理', 'description'=>'所有页面和操作','tid'=>11,'model'=>'商城']);
        $order_refundMoneys=Permission::create(['name'=>'refundMoneys.*','slug'=>'shop_orders_orderRefundMoneys', 'display_name'=>'订单退款记录', 'description'=>'所有页面和操作','tid'=>11,'model'=>'商城']);

        //商品管理
        $product_add=Permission::create(['name'=>'products.create','slug'=>'shop_products_add', 'display_name'=>'添加商品页面', 'description'=>'页面','tid'=>12,'model'=>'商城']);
        $product_store=Permission::create(['name'=>'products.store','slug'=>'shop_products_store', 'display_name'=>'添加商品操作', 'description'=>'操作','tid'=>12,'model'=>'商城']);
        $product_update=Permission::create(['name'=>'products.update','slug'=>'shop_products_update', 'display_name'=>'修改商品操作', 'description'=>'操作','tid'=>12,'model'=>'商城']);
        $product_del=Permission::create(['name'=>'products.destroy','slug'=>'shop_products_del', 'display_name'=>'删除商品', 'description'=>'操作','tid'=>12,'model'=>'商城']);
        $product_edit=Permission::create(['name'=>'products.edit','slug'=>'shop_products_edit', 'display_name'=>'修改商品页面', 'description'=>'页面','tid'=>12,'model'=>'商城']);
        $product_list_show=Permission::create(['name'=>'products.index','slug'=>'shop_products_list_show', 'display_name'=>'查看商品列表页面', 'description'=>'页面','tid'=>12,'model'=>'商城']);
        //商品库存
        $product_list_alllow=Permission::create(['name'=>'products.alllow','slug'=>'shop_products_alllow', 'display_name'=>'查看商品库存报警列表页面', 'description'=>'页面','tid'=>12,'model'=>'商城']);
        //商品附加字段
        $product_word_list=Permission::create(['name'=>'wordlist.*','slug'=>'shop_products_wordlist', 'display_name'=>'查看商品附加字段列表页面', 'description'=>'页面','tid'=>12,'model'=>'商城']);
        //商品分类管理
        $product_category_add=Permission::create(['name'=>'categories.create','slug'=>'shop_product_categories_add', 'display_name'=>'添加商品分类页面', 'description'=>'页面','tid'=>13,'model'=>'商城']);
        $product_category_store=Permission::create(['name'=>'categories.store','slug'=>'shop_product_categories_store', 'display_name'=>'添加商品分类操作', 'description'=>'操作','tid'=>13,'model'=>'商城']);
        $product_category_update=Permission::create(['name'=>'categories.update','slug'=>'shop_product_categories_update', 'display_name'=>'修改商品分类操作', 'description'=>'操作','tid'=>13,'model'=>'商城']);
        $product_category_del=Permission::create(['name'=>'categories.destroy','slug'=>'shop_product_categories_del', 'display_name'=>'删除商品分类操作', 'description'=>'操作','tid'=>13,'model'=>'商城']);
        $product_category_edit=Permission::create(['name'=>'categories.edit','slug'=>'shop_product_categories_edit', 'display_name'=>'修改商品分类页面', 'description'=>'页面','tid'=>13,'model'=>'商城']);
        $product_category_list_show=Permission::create(['name'=>'categories.index','slug'=>'shop_product_categories_list_show', 'display_name'=>'查看商品分类列表页面', 'description'=>'页面','tid'=>13,'model'=>'商城']);

        //商品品牌管理
        $product_brand_add=Permission::create(['name'=>'brands.create','slug'=>'shop_product_brand_add', 'display_name'=>'添加商品品牌页面', 'description'=>'页面','tid'=>14,'model'=>'商城']);
        $product_brand_store=Permission::create(['name'=>'brands.store','slug'=>'shop_product_brand_store', 'display_name'=>'添加商品品牌操作', 'description'=>'操作','tid'=>14,'model'=>'商城']);
        $product_brand_update=Permission::create(['name'=>'brands.update','slug'=>'shop_product_brand_update', 'display_name'=>'修改商品品牌操作', 'description'=>'操作','tid'=>14,'model'=>'商城']);
        $product_brand_del=Permission::create(['name'=>'brands.destroy','slug'=>'shop_product_brand_del', 'display_name'=>'删除商品品牌操作', 'description'=>'操作','tid'=>14,'model'=>'商城']);
        $product_brand_edit=Permission::create(['name'=>'brands.edit','slug'=>'shop_product_brand_edit', 'display_name'=>'修改商品品牌页面', 'description'=>'页面','tid'=>14,'model'=>'商城']);
        $product_brand_list_show=Permission::create(['name'=>'brands.index','slug'=>'shop_product_brand_list_show', 'display_name'=>'查看商品品牌列表页面', 'description'=>'页面','tid'=>14,'model'=>'商城']);

        //商品模型管理
        $product_types_add=Permission::create(['name'=>'productTypes.create','slug'=>'shop_productTypes_add', 'display_name'=>'添加商品模型页面', 'description'=>'页面','tid'=>15,'model'=>'商城']);
        $product_types_store=Permission::create(['name'=>'productTypes.store','slug'=>'shop_productTypes_store', 'display_name'=>'添加商品模型操作', 'description'=>'操作','tid'=>15,'model'=>'商城']);
        $product_types_update=Permission::create(['name'=>'productTypes.update','slug'=>'shop_productTypes_update', 'display_name'=>'修改商品模型操作', 'description'=>'操作','tid'=>15,'model'=>'商城']);
        $product_types_del=Permission::create(['name'=>'productTypes.destroy','slug'=>'shop_productTypes_del', 'display_name'=>'删除商品模型操作', 'description'=>'操作','tid'=>15,'model'=>'商城']);
        $product_types_edit=Permission::create(['name'=>'productTypes.edit','slug'=>'shop_productTypes_edit', 'display_name'=>'修改商品模型页面', 'description'=>'页面','tid'=>15,'model'=>'商城']);
        $product_types_list_show=Permission::create(['name'=>'productTypes.index','slug'=>'shop_productTypes_list_show', 'display_name'=>'查看商品模型列表页面', 'description'=>'页面','tid'=>15,'model'=>'商城']);

        //商品规格管理
        $product_specs_add=Permission::create(['name'=>'specs.create','slug'=>'shop_product_specs_add', 'display_name'=>'添加商品规格页面', 'description'=>'页面','tid'=>16,'model'=>'商城']);
        $product_specs_store=Permission::create(['name'=>'specs.store','slug'=>'shop_product_specs_store', 'display_name'=>'添加商品规格操作', 'description'=>'操作','tid'=>16,'model'=>'商城']);
        $product_specs_update=Permission::create(['name'=>'specs.update','slug'=>'shop_product_specs_update', 'display_name'=>'修改商品规格操作', 'description'=>'操作','tid'=>16,'model'=>'商城']);
        $product_specs_del=Permission::create(['name'=>'specs.destroy','slug'=>'shop_product_specs_del', 'display_name'=>'删除商品规格操作', 'description'=>'操作','tid'=>16,'model'=>'商城']);
        $product_specs_edit=Permission::create(['name'=>'specs.edit','slug'=>'shop_product_specs_edit', 'display_name'=>'修改商品规格', 'description'=>'页面','tid'=>16,'model'=>'商城']);
        $product_specs_list_show=Permission::create(['name'=>'specs.index','slug'=>'shop_product_specs_list_show', 'display_name'=>'查看商品规格列表页面', 'description'=>'页面','tid'=>16,'model'=>'商城']);

        //商品属性管理
        $product_attrs_add=Permission::create(['name'=>'productAttrs.create','slug'=>'shop_productAttrs_add', 'display_name'=>'添加商品属性页面', 'description'=>'页面','tid'=>17,'model'=>'商城']);
        $product_attrs_store=Permission::create(['name'=>'productAttrs.store','slug'=>'shop_productAttrs_store', 'display_name'=>'添加商品属性操作', 'description'=>'操作','tid'=>17,'model'=>'商城']);
        $product_attrs_update=Permission::create(['name'=>'productAttrs.update','slug'=>'shop_productAttrs_update', 'display_name'=>'修改商品属性操作', 'description'=>'操作','tid'=>17,'model'=>'商城']);
        $product_attrs_del=Permission::create(['name'=>'productAttrs.destroy','slug'=>'shop_productAttrs_del', 'display_name'=>'删除商品属性操作', 'description'=>'操作','tid'=>17,'model'=>'商城']);
        $product_attrs_edit=Permission::create(['name'=>'productAttrs.edit','slug'=>'shop_productAttrs_edit', 'display_name'=>'修改商品属性页面', 'description'=>'页面','tid'=>17,'model'=>'商城']);
        $product_attrs_list_show=Permission::create(['name'=>'productAttrs.index','slug'=>'shop_productAttrs_list_show', 'display_name'=>'查看商品属性列表页面', 'description'=>'页面','tid'=>17,'model'=>'商城']);

        /*促销下*/

        //商品促销设置
        $product_promps_set=Permission::create(['name'=>'productPromps.*','slug'=>'product_promps_set', 'display_name'=>'商品促销设置', 'description'=>'所有页面和操作','tid'=>18,'model'=>'促销']);

        //订单促销设置
        $order_promps_set=Permission::create(['name'=>'orderPromps.*','slug'=>'order_promps_set', 'display_name'=>'订单促销设置', 'description'=>'所有页面和操作','tid'=>18,'model'=>'促销']);

        //优惠券设置
        $coupons_set=Permission::create(['name'=>'coupons.*','slug'=>'coupons_promps_set', 'display_name'=>'优惠券设置', 'description'=>'所有页面和操作','tid'=>18,'model'=>'促销']);
        $coupons_auto_rules=Permission::create(['name'=>'couponRules.*','slug'=>'coupons_promps_auto_rules', 'display_name'=>'优惠券自动发放', 'description'=>'所有页面和操作','tid'=>18,'model'=>'促销']);

        //秒杀设置
        $flash_sales_set=Permission::create(['name'=>'flashSales.*','slug'=>'promps_flashSales_set', 'display_name'=>'秒杀设置', 'description'=>'所有页面和操作','tid'=>18,'model'=>'促销']);

        //拼团设置
        $team_sales_set=Permission::create(['name'=>'teamSales.*','slug'=>'promps_teamSales_set', 'display_name'=>'拼团设置', 'description'=>'所有页面和操作','tid'=>18,'model'=>'促销']);

        


        $super_admin->perms()->sync(array(
           $pageItems_set->id,$customPageTypes_set->id,$pages_set->id,$customPostTypeItems_set->id,$customPostTypes_set->id,$article_set->id,$article_cat_set->id,$withDrawls->id,$bannerItems_set->id,$customer_service_set->id,$single_page_set->id,$product_word_list->id,$product_list_alllow->id,$order_refundMoneys->id,$coupons_auto_rules->id,$distributions_set->id,$distributionLogs_set->id,$cities_set->id,$freightTems_set->id,$perm_add->id,$perm_store->id,$perm_list_show->id,$web_info_set->id, $banner_set->id,$user_add->id,$user_store->id,$user_update->id,$user_del->id,$user_edit->id,$user_show->id,$user_list_show->id,$user_level_add->id,$user_level_store->id,$user_level_update->id,$user_level_del->id,$user_level_edit->id,$user_level_list_show->id,$wechat_menu_set->id,$wechat_reply_message_set->id,$bank_set->id,$managers_add->id,$managers_store->id,$managers_update->id,$managers_del->id,$managers_edit->id,$managers_list_show->id,$role_add->id,$role_store->id,$role_update->id,$role_del->id,$role_edit->id,$role_list_show->id,$all_statics_show->id,$order_del->id,$order_one_show->id,$order_edit->id,$order_update->id,$order_list_show->id,$order_orderCancels->id,$order_orderRefunds->id,$product_add->id,$product_store->id,$product_update->id,$product_del->id,$product_edit->id,$product_list_show->id,$product_category_add->id,$product_category_store->id,$product_category_update->id,$product_category_del->id,$product_category_edit->id,$product_category_list_show->id,$product_brand_add->id,$product_brand_store->id,$product_brand_update->id,$product_brand_del->id,$product_brand_edit->id,$product_brand_list_show->id,$product_types_add->id,$product_types_store->id,$product_types_update->id,$product_types_del->id,$product_types_edit->id,$product_types_list_show->id,$product_specs_add->id,$product_specs_store->id,$product_specs_update->id,$product_specs_del->id,$product_specs_edit->id,$product_specs_list_show->id,$product_attrs_add->id,$product_attrs_store->id,$product_attrs_update->id,$product_attrs_del->id,$product_attrs_edit->id,$product_attrs_list_show->id,$product_promps_set->id,$order_promps_set->id,$coupons_set->id,$flash_sales_set->id,$team_sales_set->id,$countries->id,$advertiseMobiles->id, $notices_set->id
        ));

        $super_admin_user->attachRole($super_admin);

    }
}
