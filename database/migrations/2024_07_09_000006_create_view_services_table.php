<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewServicesTable extends Migration
{
    public function up()
    {
        Schema::create('view_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }
}
