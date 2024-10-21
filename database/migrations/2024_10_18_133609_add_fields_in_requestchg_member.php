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
            $table->string('rc_contactno')->nullable()->after('rc_mykad');
            $table->string('rc_emailadd')->nullable()->after('rc_contactno');
            $table->string('rc_oldcontactno')->nullable()->after('rc_oldmykad');
            $table->string('rc_oldemailadd')->nullable()->after('rc_oldcontactno');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requestchg_member', function (Blueprint $table) {
            $table->dropColumn(['rc_contactno','rc_emailadd','rc_oldcontactno','rc_oldemailadd']);
        });
    }
};
