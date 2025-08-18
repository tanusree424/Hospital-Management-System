<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->decimal('pricing', 8, 2)->change(); // now allows 999,999.99
        });
    }

    public function down()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->decimal('pricing', 5, 2)->change(); // revert if needed
        });
    }
};
