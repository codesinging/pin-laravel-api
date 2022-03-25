<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_menus', function (Blueprint $table) {
            $table->id();

            $table->nestedSet();

            $table->string('name')->comment('菜单名称');
            $table->string('path')->nullable()->comment('菜单路由路径');
            $table->string('url')->nullable()->comment('外部链接地址');
            $table->string('icon')->nullable()->comment('图标');
            $table->bigInteger('sort')->default(0)->comment('排列序号，升序排列');
            $table->boolean('default')->default(false)->comment('默认选中菜单');
            $table->boolean('opened')->default(false)->comment('默认展开菜单');
            $table->boolean('status')->default(true)->comment('菜单可用状态');

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
        Schema::dropIfExists('admin_menus');
    }
};
