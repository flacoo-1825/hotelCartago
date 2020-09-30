<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cityOrigin_certificate');
            $table->string('number_certificate')->nullable();
            $table->string('cityDestination_certificate');
            $table->string('placabike_certificate')->nullable();
            $table->string('placaCar_certificate')->nullable();
            $table->integer('adults_certificate')->nullable();
            $table->integer('children_certificate')->nullable();
            $table->date('entry_certificate')->nullable();
            $table->date('exit_certificate')->nullable();
            $table->text('observation_certificate')->nullable();
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
        Schema::dropIfExists('certificates');
    }
}
