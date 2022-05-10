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
        Schema::create('setting_options', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('group_id');
            $table->bigInteger('setting_id')->nullable();
            $table->string('name')->unique();
            $table->string('type')->default('input');
            $table->json('default')->nullable();
            $table->json('attributes')->nullable();
            $table->json('options')->nullable();
            $table->unsignedBigInteger('sort')->default(0);
            $table->boolean('status')->default(true);

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
        Schema::dropIfExists('setting_options');
    }
};
