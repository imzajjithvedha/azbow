<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'Red Glossy Lipstik',
            'product_id' => 'P001',
            'category' => 1,
            'description' => 'Load your lips with long lasting and impeccable red colour to fulfill your makeup requirements.',
            'directions' => '<p>HOW TO USE:</p><p>1. Exfoliate your lips.<br>2. Line your lips with the CCUK Lip definer, then fill them in.<br>3. Blot your lips for an extra-matte finish.<br>*Please note that actual colours may vary slightly.</p>',
            'price' => '2500.00',
            'in_stock' => 150,
            'status' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('products')->insert([
            'name' => 'Red Glossy Lipstik',
            'product_id' => 'P002',
            'category' => 2,
            'description' => 'Load your lips with long lasting and impeccable red colour to fulfill your makeup requirements.',
            'directions' => '<p>HOW TO USE:</p><p>1. Exfoliate your lips.<br>2. Line your lips with the CCUK Lip definer, then fill them in.<br>3. Blot your lips for an extra-matte finish.<br>*Please note that actual colours may vary slightly.</p>',
            'price' => '2500.00',
            'in_stock' => 150,
            'status' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('products')->insert([
            'name' => 'Red Glossy Lipstik',
            'product_id' => 'P003',
            'category' => 3,
            'description' => 'Load your lips with long lasting and impeccable red colour to fulfill your makeup requirements.',
            'directions' => '<p>HOW TO USE:</p><p>1. Exfoliate your lips.<br>2. Line your lips with the CCUK Lip definer, then fill them in.<br>3. Blot your lips for an extra-matte finish.<br>*Please note that actual colours may vary slightly.</p>',
            'price' => '2500.00',
            'in_stock' => 150,
            'status' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('products')->insert([
            'name' => 'Wine Lip Liner',
            'product_id' => 'P004',
            'category' => 1,
            'description' => 'Defines and creates a neat lip outline resulting on full, bold lips.',
            'directions' => '<p>HOW TO USE:</p><p>1. Prime and line lips with lip liner.<br>2. Fill in to wear alone, or apply lipstick to complete the look.<br>3. For an even bolder look, fill in and apply Colour Lipstick on top.</p>',
            'price' => '1200.00',
            'in_stock' => 75,
            'status' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('products')->insert([
            'name' => 'Wine Lip Liner',
            'product_id' => 'P005',
            'category' => 4,
            'description' => 'Defines and creates a neat lip outline resulting on full, bold lips.',
            'directions' => '<p>HOW TO USE:</p><p>1. Prime and line lips with lip liner.<br>2. Fill in to wear alone, or apply lipstick to complete the look.<br>3. For an even bolder look, fill in and apply Colour Lipstick on top.</p>',
            'price' => '1200.00',
            'in_stock' => 75,
            'status' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('products')->insert([
            'name' => 'Wine Lip Liner',
            'product_id' => 'P006',
            'category' => 3,
            'description' => 'Defines and creates a neat lip outline resulting on full, bold lips.',
            'directions' => '<p>HOW TO USE:</p><p>1. Prime and line lips with lip liner.<br>2. Fill in to wear alone, or apply lipstick to complete the look.<br>3. For an even bolder look, fill in and apply Colour Lipstick on top.</p>',
            'price' => '1200.00',
            'in_stock' => 75,
            'status' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('products')->insert([
            'name' => 'Damson Lip Liner',
            'product_id' => 'P007',
            'category' => 1,
            'description' => 'Defines and creates a neat lip outline resulting on full, bold lips.',
            'directions' => '<p>HOW TO USE:</p><p>1. Prime and line lips with lip liner.<br>2. Fill in to wear alone, or apply lipstick to complete the look.<br>3. For an even bolder look, fill in and apply Colour Lipstick on top.</p>',
            'price' => '1400.00',
            'in_stock' => 150,
            'status' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
