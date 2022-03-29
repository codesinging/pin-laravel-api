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
        Schema::create('admin_roles', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('role_id')->nullable()->unique()->comment('关联权限角色ID');
            $table->string('name')->unique()->comment('角色名称');
            $table->string('description')->nullable()->comment('角色描述');
            $table->unsignedBigInteger('sort')->default(0)->comment('排列序号，升序');
            $table->boolean('status')->default(true)->comment('角色状态');

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
        Schema::dropIfExists('admin_roles');
    }
};
