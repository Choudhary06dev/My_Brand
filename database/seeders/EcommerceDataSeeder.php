<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Slider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class EcommerceDataSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks to truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        Product::truncate();
        ProductCategory::truncate();
        Slider::truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Create Main Categories
        $towelsCat = ProductCategory::create([
            'category_name' => 'Beach Towels',
            'slug' => 'beach-towels',
            'image' => 'categories/towels.png',
            'sequence' => 1
        ]);

        $umbrellasCat = ProductCategory::create([
            'category_name' => 'Beach Umbrellas',
            'slug' => 'beach-umbrellas',
            'image' => 'categories/umbrellas.png',
            'sequence' => 2
        ]);

        $chairsCat = ProductCategory::create([
            'category_name' => 'Beach Chairs',
            'slug' => 'beach-chairs',
            'image' => 'categories/chairs.png',
            'sequence' => 3
        ]);

        $coolersCat = ProductCategory::create([
            'category_name' => 'Cooler Bags',
            'slug' => 'cooler-bags',
            'image' => 'categories/coolers.png',
            'sequence' => 4
        ]);

        $tentsCat = ProductCategory::create([
            'category_name' => 'Beach Tents',
            'slug' => 'beach-tents',
            'image' => 'categories/umbrellas.png', // Re-using image
            'sequence' => 5
        ]);

        $accCat = ProductCategory::create([
            'category_name' => 'Accessories',
            'slug' => 'accessories',
            'image' => 'categories/coolers.png', // Re-using image
            'sequence' => 6
        ]);

        // 2. Create Sub Categories
        $stripedTowels = ProductCategory::create([
            'category_name' => 'Striped Towels',
            'slug' => 'striped-towels',
            'parent_id' => $towelsCat->id,
            'sequence' => 1
        ]);

        $premiumTowels = ProductCategory::create([
            'category_name' => 'Premium Oversized',
            'slug' => 'premium-oversized',
            'parent_id' => $towelsCat->id,
            'sequence' => 2
        ]);

        $cabanas = ProductCategory::create([
            'category_name' => 'Premium Cabanas',
            'slug' => 'premium-cabanas',
            'parent_id' => $tentsCat->id,
            'sequence' => 1
        ]);

        $sandTools = ProductCategory::create([
            'category_name' => 'Sand Anchors',
            'slug' => 'sand-anchors',
            'parent_id' => $accCat->id,
            'sequence' => 1
        ]);

        // 3. Create Products
        // Towels
        Product::create([
            'product_name' => 'The Beach Towel - Lauren\'s Navy',
            'slug' => 'laurens-navy-towel',
            'category_id' => $towelsCat->id,
            'subcategory_id' => $stripedTowels->id,
            'description' => '100% Cotton, ultra-soft, absorbent, and features a vintage-inspired stripe pattern.',
            'price' => 79.00,
            'discount_price' => 59.00,
            'main_image' => 'products/striped_towel.png',
            'is_sale' => 1,
            'status' => 1
        ]);

        Product::create([
            'product_name' => 'The Oversized Towel - Pink Stripe',
            'slug' => 'pink-stripe-oversized',
            'category_id' => $towelsCat->id,
            'subcategory_id' => $premiumTowels->id,
            'description' => 'Luxuriously large and soft, perfect for sharing or extra comfort.',
            'price' => 99.00,
            'main_image' => 'products/striped_towel.png',
            'is_sale' => 0,
            'status' => 1
        ]);

        // Umbrellas
        Product::create([
            'product_name' => 'The Premium Beach Umbrella - Navy Stripe',
            'slug' => 'premium-navy-umbrella',
            'category_id' => $umbrellasCat->id,
            'description' => 'Large 6ft canopy with UV protection, cotton fringe detailing, and a timber pole.',
            'price' => 299.00,
            'discount_price' => 249.00,
            'main_image' => 'products/blue_umbrella.png',
            'is_sale' => 1,
            'status' => 1
        ]);

        // Chairs
        Product::create([
            'product_name' => 'The Holiday Beach Chair - Sage',
            'slug' => 'holiday-chair-sage',
            'category_id' => $chairsCat->id,
            'description' => 'Lightweight, portable chair with 5-position reclining and a slim design.',
            'price' => 149.00,
            'main_image' => 'products/sage_chair.png',
            'is_sale' => 0,
            'status' => 1
        ]);

        Product::create([
            'product_name' => 'The Tommy Chair - Navy Stripe',
            'slug' => 'tommy-chair-navy',
            'category_id' => $chairsCat->id,
            'description' => 'The classic beach chair, upgraded with premium materials and vintage styling.',
            'price' => 189.00,
            'main_image' => 'products/sage_chair.png',
            'is_sale' => 0,
            'status' => 1
        ]);

        // Tents
        Product::create([
            'product_name' => 'The Premium Cabana - Navy Stripe',
            'slug' => 'premium-cabana-navy',
            'category_id' => $tentsCat->id,
            'subcategory_id' => $cabanas->id,
            'description' => 'A large, stylish cabana providing maximum sun protection and effortless style.',
            'price' => 499.00,
            'discount_price' => 399.00,
            'main_image' => 'products/blue_umbrella.png',
            'is_sale' => 1,
            'status' => 1
        ]);

        // Accessories
        Product::create([
            'product_name' => 'The Sand Anchor - Timber',
            'slug' => 'sand-anchor-timber',
            'category_id' => $accCat->id,
            'subcategory_id' => $sandTools->id,
            'description' => 'Keep your umbrella secure in the strongest winds with our signature timber sand anchor.',
            'price' => 49.00,
            'main_image' => 'products/yellow_cooler.png',
            'is_sale' => 0,
            'status' => 1
        ]);

        // 4. Create Slider
        Slider::create([
            'title' => 'Summer Collection 2026',
            'subtitle' => 'Premium Beach Essentials for the Sun-Drenched Soul',
            'image' => 'sliders/hero_1.png',
            'button_text' => 'Shop Collection',
            'button_link' => '/products',
            'sequence' => 1,
            'status' => 1
        ]);
    }
}
