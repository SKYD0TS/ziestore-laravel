<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Core\Barcode;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $barcode = new Barcode();
        // \App\Models\User::factory(10)->create();

        if (!(\App\Models\User\Staff::find('00admin00'))) {
            \App\Models\User\Staff::create([
                'staff_code' => 'O2312171034',
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'role' => 'owner',
                'password' => bcrypt('password'),
            ]);

            \App\Models\Unit::create([
                'name' => 'piece'
            ]);

            \App\Models\Unit::create([
                'name' => 'box'
            ]);

            \App\Models\Unit::create([
                'name' => 'pack'
            ]);

            \App\Models\Category::create([
                'name' => 'Sanitary'
            ]);

            \App\Models\Category::create([
                'name' => 'Food'
            ]);

            \App\Models\PaymentType::create([
                'name' => 'cash'
            ]);

            \App\Models\PaymentType::create([
                'name' => 'debit'
            ]);


            \App\Models\Product::create([
                'barcode' => $barcode->ean8(),
                'name' => 'Sabun 5kg',
                'description' => 'sbun',
                'category_id' => 2,
                'unit_id' => 2,
                'price' => 8.6
            ]);

            \App\Models\Product::create([
                'barcode' => $barcode->ean8(),
                'name' => 'Baygon 120ml Spray',
                'description' => 'batnyamuk',
                'category_id' => 1,
                'unit_id' => 1,
                'price' => 8.6
            ]);

            \App\Models\Product::create([
                'barcode' => $barcode->ean8(),
                'name' => 'Baygon 120ml Spray',
                'description' => 'batnyamuk',
                'category_id' => 2,
                'unit_id' => 1,
                'price' => 8.6
            ]);

            \App\Models\Product::create([
                'barcode' => $barcode->ean8(),
                'name' => 'Sabun Colek 9L',
                'description' => 'batnyamuk',
                'category_id' => 1,
                'unit_id' => 2,
                'price' => 8.6
            ]);

            \App\Models\PaymentType::create([
                'name' => 'cash'
            ]);

            \App\Models\PaymentType::create([
                'name' => 'credit'
            ]);
        };
    }
}
