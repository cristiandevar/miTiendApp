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
            $table->decimal('precio', 10, 2);
            $table->string('imagen',100);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('seller_id');

            // Creamos la FK category_id que hace referencia al 'id' de la tabla category
            $table->foreign('category_id')->references('id')->on('categories');

            // Creamos la FK 'vendedor_id' que hace referencia al 'id' de la tabla users
            $table->foreign('seller_id')->references('id')->on('users');
            
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
