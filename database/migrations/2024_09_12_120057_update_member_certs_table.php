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
        // for handling 0000-00-00 records in member_certs table
        DB::statement('SET SESSION sql_mode = ""');

        Schema::table('member_certs', function (Blueprint $table) {
            $table->timestamp('mc_deleted')->nullable()->comment('Record deletion date and time')->after('mc_created');
        });

        DB::statement('SET SESSION sql_mode = "ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION"');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_certs', function (Blueprint $table) {
            $table->dropColumn('mc_deleted');
        });
    }
};
