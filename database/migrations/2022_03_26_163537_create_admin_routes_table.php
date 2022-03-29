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
        Schema::create('admin_routes', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('permission_id')->nullable()->unique()->comment('关联权限ID');
            $table->string('controller')->comment('路由的控制器');
            $table->string('action')->comment('路由的动作');
            $table->string('controller_title')->comment('路由的控制器标题');
            $table->string('action_title')->comment('路由的动作标题');

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
        Schema::dropIfExists('admin_routes');
    }
};
