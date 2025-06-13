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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('user_id')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('dob');
            $table->unsignedTinyInteger('gender_id');
            $table->string('current_address');
            $table->string('avatar');
            $table->unsignedTinyInteger('account_status_id');
            $table->unsignedTinyInteger('account_role_id');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('gender_id')->references('gender_id')->on('genders')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('account_status_id')->references('account_status_id')->on('account_statues')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreign('account_role_id')->references('account_role_id')->on('account_roles')->restrictOnDelete()->cascadeOnUpdate();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
