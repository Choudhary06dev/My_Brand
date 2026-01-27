<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        \App\Models\CompanyInfo::factory(1)->create();
        \App\Models\Service::factory(5)->create();
        \App\Models\ProductCategory::factory(5)->create();
        \App\Models\Product::factory(10)->create()->each(function ($product) {
            \App\Models\ProductGallery::factory(3)->create(['product_id' => $product->id]);
        });
        \App\Models\Blog::factory(10)->create();
        \App\Models\ContactMessage::factory(10)->create();
        \App\Models\JobOpening::factory(5)->create()->each(function ($job) {
            \App\Models\JobApplication::factory(3)->create(['job_id' => $job->id]);
        });
        \App\Models\Slider::factory(3)->create();
        \App\Models\Page::factory(3)->create();
        \App\Models\EmailTemplate::factory(3)->create();
        \App\Models\ActivityLog::factory(10)->create();
    }
}
