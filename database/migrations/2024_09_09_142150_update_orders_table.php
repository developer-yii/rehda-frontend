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
        // for handling 0000-00-00 records in orders table
        DB::statement('SET SESSION sql_mode = ""');

        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('order_updated_at')->nullable()->comment('Record update date and time')->after('order_created_at');
            $table->timestamp('order_deleted_at')->nullable()->comment('Record deletion date and time')->after('order_updated_at');
        });

        DB::statement('SET SESSION sql_mode = "ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION"');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['order_updated_at','order_deleted_at']);
        });
    }
};
