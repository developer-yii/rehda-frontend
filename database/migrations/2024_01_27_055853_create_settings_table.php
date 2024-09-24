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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('value')->nullable();
            $table->timestamp('deleted_at')->nullable()->comment('Record deletion date and time');
            $table->unsignedBigInteger('creator_id')->nullable()->comment('user_id of the creator');
            $table->timestamp('created_at')->default(now())->comment('Record created date');
            $table->timestamp('updated_at')->default(now())->comment('Record updated date');
            $table->unsignedBigInteger('updater_id')->nullable()->comment('user_id of the updater');
            $table->index('creator_id');
            $table->index('updater_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
