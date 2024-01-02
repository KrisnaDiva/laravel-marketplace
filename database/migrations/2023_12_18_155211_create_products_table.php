<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->unsignedBigInteger('price');
            $table->unsignedInteger('stock');
            $table->unsignedInteger('weight');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('condition_id');
            $table->unsignedBigInteger('store_id');
            // $table->foreignId('category_id')->constrained();
            // $table->foreignId('subcategory_id')->constrained();
            // $table->foreignId('condition_id')->constrained();
            // $table->foreignId('store_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
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
