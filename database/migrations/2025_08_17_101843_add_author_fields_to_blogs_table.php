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
      //  $table->unsignedBigInteger('author_id')->nullable()->after('id');
        $table->string('author_type')->nullable()->after('author_id');
    });
}

public function down()
{
    Schema::table('blogs', function (Blueprint $table) {
        $table->dropColumn(['author_id', 'author_type']);
    });
}

};
