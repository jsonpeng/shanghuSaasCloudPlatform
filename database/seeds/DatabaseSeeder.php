<?php

use Illuminate\Database\Seeder;

use App\Role;
use App\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        // $this->call(RolePemessionSeeder::class);
        //$this->call(SettingSeeder::class);
        //$this->call(ProductSeeder::class);
        // $this->call(CitiesSeeder::class);
        //$this->call(PageSeeder::class);
    }
}
