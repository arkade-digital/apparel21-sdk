<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->string('id');
            $table->string('shopify_slug');
            $table->string('shopify_token')->nullable();
            $table->string('shopify_scopes')->nullable();
            $table->datetime('shopify_updated_at')->nullable();
            $table->string('ap21_username')->nullable();
            $table->string('ap21_password')->nullable();
            $table->datetime('ap21_updated_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('shops');
    }
}
