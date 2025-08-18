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
    Schema::table('blogs', function (Blueprint $table) {
        // Ensure 'author' column exists and is unsigned big integer
        $table->unsignedBigInteger('author')->change();

        // Add foreign key
        $table->foreign('author')->references('id')->on('users')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('blogs', function (Blueprint $table) {
        $table->dropForeign(['author']);
    });
}


    /**
     * Reverse the migrations.
     */

};
