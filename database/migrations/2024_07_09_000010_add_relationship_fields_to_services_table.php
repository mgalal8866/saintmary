<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToServicesTable extends Migration
{
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->unsignedBigInteger('service_id')->nullable();
            $table->foreign('service_id', 'service_fk_9932863')->references('id')->on('services');
            $table->unsignedBigInteger('subservies_id')->nullable();
            $table->foreign('subservies_id', 'subservies_fk_9932864')->references('id')->on('services');
        });
    }
}
