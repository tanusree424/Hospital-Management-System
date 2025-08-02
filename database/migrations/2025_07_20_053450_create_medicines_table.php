<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('medicines', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('category');
        $table->integer('stock');
        $table->string('manufacturer')->nullable();
        $table->date('expiry_date')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
