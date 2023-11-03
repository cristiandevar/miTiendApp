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
            $table->string('code');
            $table->string('name');
            $table->decimal('price', 10, 2)->unsigned();
            $table->integer('stock')->nullable()->unsigned();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('supplier_id');
            $table->tinyInteger('active')->default(1);
            $table->text('description')->nullable(true);
            $table->string('image',100);
            // $table->unsignedBigInteger('seller_id');

            // Creamos la FK category_id que hace referencia al 'id' de la tabla category
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('supplier_id')->references('id')->on('suppliers');

            // Creamos la FK 'vendedor_id' que hace referencia al 'id' de la tabla users
            // $table->foreign('seller_id')->references('id')->on('users');
            
            $table->timestamps();
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
