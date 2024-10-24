<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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

        Schema::table('newsletter', function (Blueprint $table) {
            $table->timestamp('bu_updated_at')->nullable()->comment('Record update date and time')->after('bu_created_at');
            $table->timestamp('bu_deleted_at')->nullable()->comment('Record deletion date and time')->after('bu_updated_at');
        });

        DB::statement('SET SESSION sql_mode = "ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION"');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('newsletter', function (Blueprint $table) {
            $table->dropColumn(['bu_updated_at','bu_deleted_at']);
        });
    }
};
