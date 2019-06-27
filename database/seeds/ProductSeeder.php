<?php

use Illuminate\Database\Seeder;

use App\Models\Product;
use App\Models\Category;
use App\Models\Spec;
use App\Models\SpecItem;
use App\Models\SpecProductPrice;
use App\Models\ProductAttr;
use App\Models\ProductType;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->delete();

        DB::table('product_attrs')->delete();
        DB::table('spec_items')->delete();
        DB::table('specs')->delete();
        DB::table('product_types')->delete();
        
        DB::table('categories')->delete();
        DB::table('brands')->delete();

        $type = ProductType::create(['name' => '手机']);
        $spec = Spec::create(['name' => '内存', 'type_id' => $type->id]);
        SpecItem::create(['name' => '8G', 'spec_id' => $spec->id]);
        SpecItem::create(['name' => '4G', 'spec_id' => $spec->id]);
        $spec_color = Spec::create(['name' => '颜色', 'type_id' => $type->id]);
        SpecItem::create(['name' => '黑色', 'spec_id' => $spec_color->id]);
        SpecItem::create(['name' => '金色', 'spec_id' => $spec_color->id]);
        ProductAttr::create(['name' => '网络', 'isIndex' => '否', 'input_type'=> 0, 'values' => '号 号', 'attr_type' => 0, 'type_id'=> $type->id]);
        ProductAttr::create(['name' => '尺寸', 'isIndex' => '否', 'input_type'=> 0, 'values' => '号 号', 'attr_type' => 0, 'type_id'=> $type->id]);

        $categories = factory(App\Models\Category::class, 30)->create();
        $brands = factory(App\Models\Brand::class, 10)->create();
        $products = factory(App\Models\Product::class, 200)->create();

    }
}
