<?php

namespace Database\Seeders;

use App\Models\CustomerType;
use Illuminate\Database\Seeder;

class CustomerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomerType::create(['name' => 'Retail Customer']);
        CustomerType::create(['name' => 'Wholesale Customer']);
        CustomerType::create(['name' => 'Contractor']);
        CustomerType::create(['name' => 'Interior Designer']);
        CustomerType::create(['name' => 'Builder']);
    }
}