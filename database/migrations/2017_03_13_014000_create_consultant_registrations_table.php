<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultantRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultant_registrations', function (Blueprint $table) {

            $table->bigIncrements('idConsultantRegistration');
            $table->string('first_name', 45)->index() ;
            $table->string('last_name', 45)->index() ;
            $table->string('gender', 2)  ; //  Gender has two param : M = Male , F = Female
            $table->string('email', 45);
            $table->bigInteger('idAdmin_notified')->nullable();    // idAdmin_notified : Name of administrator will be notified

            $table->bigInteger('idCountry_nationality')->unsigned()  ;
            $table->foreign('idCountry_nationality')->references('idCountry')->on('countries')->onDelete('no action');
            $table->bigInteger('idCountry_residential')->unsigned()  ;
            $table->foreign('idCountry_residential')->references('idCountry')->on('countries')->onDelete('no action');

            $table->text('about')  ;
            $table->string('mobile_number', 15)  ;
            $table->text('comments_by_admin')->nullable();
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
        Schema::dropIfExists('consultant_registrations');
    }
}
