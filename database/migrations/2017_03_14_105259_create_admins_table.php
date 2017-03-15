<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {

            $table->bigIncrements('idAdmin');
            $table->string('username', 45)->index() ;
            $table->string('email', 255);
            $table->bigInteger('idUser')->unsigned();
            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
            $table->integer('role')   ;//1 = super user , 2 = content authority , 3 = financial  ,4 = meeting calendar
            $table->string('thumbnail', 200)->nullable(); // Profile picture thumbnail
            $table->date('last_login_date');
            $table->string('first_name', 45)->nullable();
            $table->string('last_name', 45)->nullable();
            $table->string('mobile_number', 45)->nullable();
            $table->string('profile_path', 200)->nullable();
            $table->string('gender', 2)->nullable(); //  Gender has two param : M = Male , F = Female
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
        Schema::dropIfExists('admins');
    }
}
