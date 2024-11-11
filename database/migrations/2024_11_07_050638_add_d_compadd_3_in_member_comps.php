<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('SET SESSION sql_mode = ""');

        Schema::table('member_comps', function (Blueprint $table) {
            $table->text('d_compadd_3')->nullable()->after('d_compaddcity');
        });

        Schema::table('member_userprofiles', function (Blueprint $table) {
            $table->text('up_address_3')->nullable()->after('up_city');
        });

        DB::statement('SET SESSION sql_mode = "ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION"');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_comps', function (Blueprint $table) {
            $table->dropColumn('d_compadd_3');
        });

        Schema::table('member_userprofiles', function (Blueprint $table) {
            $table->dropColumn('up_address_3');
        });
    }
};
