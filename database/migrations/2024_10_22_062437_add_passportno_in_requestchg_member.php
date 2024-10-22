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
        Schema::table('requestchg_member', function (Blueprint $table) {
            $table->string('rc_passportno')->nullable()->after('rc_mykad');
            $table->string('rc_oldpassportno')->nullable()->after('rc_oldmykad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requestchg_member', function (Blueprint $table) {
            $table->dropColumn(['rc_passportno', 'rc_oldpassportno']);
        });
    }
};
