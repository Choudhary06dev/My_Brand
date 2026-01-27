<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('slug')->unique();
            $table->string('product_type')->nullable()->default('1 Piece');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->unsignedBigInteger('child_subcategory_id')->nullable();
            $table->foreignId('fabric_category_id')->nullable()->constrained('fabric_categories')->onDelete('set null');
            $table->foreignId('fabric_id')->nullable()->constrained('fabrics')->onDelete('set null');
            $table->longText('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->string('special_effects')->nullable();
            $table->string('washing_dyeing_category')->nullable();
            $table->string('main_image')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->boolean('is_sale')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('product_categories')->onDelete('set null');
            $table->foreign('subcategory_id')->references('id')->on('product_categories')->onDelete('set null');
            $table->foreign('child_subcategory_id')->references('id')->on('product_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
