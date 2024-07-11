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
            $table->string('type_link_service')->nullable();
            $table->string('type_select_service_attr')->nullable();
            $table->json('type_select')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
