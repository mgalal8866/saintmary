<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('value', 15, 2);
            $table->string('type');
            $table->integer('service_id')->nullable();
            $table->integer('service_att')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
