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
            $table->string('ProductName');
            $table->string('SKU');
            $table->string('Description');
            $table->integer('UnitsInInventory');
            $table->integer('MinStockLevel');
            $table->decimal('Price');
            $table->string('Image');
            $table->timestamps();
            $table->bigInteger('categories_id')->unsigned();
            $table->foreign('categories_id')->references('id')->on('categories');
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
