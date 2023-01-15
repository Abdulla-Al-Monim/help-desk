<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->longText('name')->nullable();
            $table->longText('username')->nullable();
            $table->string('gender')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('email')->unique();
            $table->string('status')->nullable();
            $table->string('phone')->nullable();
            $table->longText('image')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('verified')->default(false);
            $table->string('password')->nullable();
            $table->string('country')->nullable();
            $table->string('userType')->nullable();
            $table->string('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->string('timezone')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
