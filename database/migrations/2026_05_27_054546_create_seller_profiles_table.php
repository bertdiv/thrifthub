<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // SKIP IF TABLE EXISTS
        if (Schema::hasTable('seller_profiles')) {
            return;
        }

        Schema::create('seller_profiles', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('user_id');

            $table->string('shop_name')
                  ->nullable();

            $table->text('bio')
                  ->nullable();

            $table->timestamps();

        });

        // ADD FOREIGN KEY SEPARATELY
        Schema::table('seller_profiles', function (Blueprint $table) {

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seller_profiles');
    }
};