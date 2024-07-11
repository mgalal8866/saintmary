<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToViewServicesTable extends Migration
{
    public function up()
    {
        Schema::table('view_services', function (Blueprint $table) {
            $table->unsignedBigInteger('service_id')->nullable();
            $table->foreign('service_id', 'service_fk_9932786')->references('id')->on('services');
            $table->unsignedBigInteger('service_attribute_id')->nullable();
            $table->foreign('service_attribute_id', 'service_attribute_fk_9932787')->references('id')->on('services_attributes');
        });
    }
}
