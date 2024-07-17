<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateServicesTable extends Migration
{
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('category_id')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('mainservice')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
