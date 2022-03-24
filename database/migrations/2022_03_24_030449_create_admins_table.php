<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();

            $table->string('username')->unique()->comment('登录账号');
            $table->string('name')->unique()->comment('用户名称');
            $table->string('password')->comment('登录密码');
            $table->boolean('super')->default(false)->comment('是否超级管理员');
            $table->boolean('status')->default(true)->comment('用户状态');

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
        Schema::dropIfExists('admins');
    }
};
