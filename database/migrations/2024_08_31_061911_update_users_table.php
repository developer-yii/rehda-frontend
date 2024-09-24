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
        // for handling 0000-00-00 records in users table
        DB::statement('SET SESSION sql_mode = ""');

        Schema::table('users', function (Blueprint $table) {
            $table->string('salt')->nullable()->change();
            $table->timestamp('created_at')->nullable()->change();
            $table->timestamp('email_verified_at')->nullable()->after('email');
            $table->rememberToken()->after('password');
            $table->timestamp('updated_at')->default(now())->comment('Record updated date')->after('created_at');
            $table->timestamp('deleted_at')->nullable()->comment('Record deletion date and time')->after('updated_at');
        });

        DB::statement('SET SESSION sql_mode = "ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION"');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('salt')->nullable(false)->change();
            $table->dateTime('created_at')->useCurrent()->change();
            $table->dropColumn(['email_verified_at', 'remember_token', 'updated_at', 'deleted_at']);
        });
    }
};
