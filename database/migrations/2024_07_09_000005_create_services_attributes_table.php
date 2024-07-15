<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesAttributesTable extends Migration
{
    public function up()
    {
        Schema::create('services_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('value');
            $table->string('type');

            $table->string('linkservice')->nullable();
            $table->json('selecttype')->nullable();
            $table->boolean('main')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
