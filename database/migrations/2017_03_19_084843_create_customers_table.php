<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('idCustomer');
            $table->string('first_name', 45)->index() ;
            $table->string('last_name', 45)->index() ;
            $table->string('email', 128);
            $table->string('username', 20)->index()->nullable();
            $table->bigInteger('idUser')->unsigned();
            $table->foreign('idUser')->references('id')->on('users')->onDelete('no action');
            $table->boolean('active')->default(1)    ;//1 = active, 2 = suspended ,3 = deleted by admin ,4 = expired ,5 = blocked
            $table->string('mobile_number', 15)->nullable();
            $table->date('birthdate')->nullable();
            $table->integer('number_of_children')->nullable()   ;
            $table->string('gender', 2)  ; //  Gender has two param : M = Male , F = Female
            $table->string('profile_image_path', 128)->nullable();
            $table->string('profile_background_path', 45)->nullable();
            $table->bigInteger('idNationality')->unsigned()->nullable() ;
            $table->foreign('idNationality')->references('idCountry')->on('countries')->onDelete('no action');
            $table->bigInteger('idResidential_country')->unsigned()->nullable() ;
            $table->foreign('idResidential_country')->references('idCountry')->on('countries')->onDelete('no action');
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
        Schema::dropIfExists('customers');
    }
}
