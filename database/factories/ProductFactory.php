<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\ProductType::class, function (Faker $faker) {
    return [
	    'name' => $faker->name,
    ];
});

$factory->define(App\Models\Spec::class, function (Faker $faker) {
    return [
	    'name' => $faker->name,
	    'type_id' => function () {
            return factory(App\Models\ProductType::class)->create()->id;
        }
    ];
});

$factory->define(App\Models\SpecItem::class, function (Faker $faker) {
    return [
	    'name' => $faker->name,
	    'spec_id' => function () {
            return factory(App\Models\Spec::class)->create()->id;
        }
    ];
});

$factory->define(App\Models\ProductAttr::class, function (Faker $faker) {
    return [
    	'name' => $faker->name, 
    	'isIndex' => '否', 
    	'input_type'=> $faker->numberBetween(0, 2), 
    	'values' => $faker->name, 
    	'attr_type' => 0, 
    	'type_id' => function () {
            return factory(App\Models\ProductType::class)->create()->id;
        }
    ];
});

$factory->define(App\Models\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->name, 
        'level' => 1,
        'image' => $faker->imageUrl(80, 80),
        'recommend' => $faker->numberBetween(0, 1)
    ];
});

$factory->define(App\Models\Brand::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'image' => $faker->imageUrl(80, 80),
    ];
});

$factory->define(App\Models\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'sn' => str_random(10),
        'price' => $faker->randomDigitNotNull,
        'inventory' => $faker->numberBetween(-1, 200),
        'max_buy' => $faker->numberBetween(1, 200),
        'weight' => $faker->numberBetween(1, 200),
        'weight' => $faker->numberBetween(1, 200),
        'image' => $faker->imageUrl(640, 640),
        'intro' => $faker->paragraph,
        'recommend' => $faker->numberBetween(0, 1),
        'is_new' => $faker->numberBetween(0, 1),
        'is_hot' => $faker->numberBetween(0, 1),
        'views' => $faker->numberBetween(0, 100),
        'shelf' => 1,
        'brand_id' => $faker->numberBetween(1, 10),
        'type_id' => 1,
        'category_id' => $faker->numberBetween(1, 30),

    ];
});
