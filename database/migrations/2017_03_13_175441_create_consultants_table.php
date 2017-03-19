<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultants', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('idConsultant');
            $table->string('first_name', 45)->index() ;
            $table->string('last_name', 45)->index() ;
            $table->string('username', 45)->index() ;
            $table->bigInteger('idUser')->unsigned();
            $table->foreign('idUser')->references('id')->on('users')->onDelete('no action');;
            $table->boolean('status')->default(1);//1 = active  ,   2 = suspended  , 3 = left the company , 4 = no time slots available
            $table->string('email', 150);
            $table->string('mobile_number', 15)  ;
            $table->string('phone_number', 15)  ;
            $table->date('birthdate');
            $table->text('brief_description')  ;
            $table->bigInteger('no_of_views')   ;
            $table->bigInteger('no_of_followers')   ;
            $table->bigInteger('no_of_questions')   ;
            $table->bigInteger('no_of_articles')   ;
            $table->bigInteger('no_of_reviews')   ;
            $table->bigInteger('no_of_answers')   ;
            $table->boolean('is_premium')->default(0); //0 = No  Not premium ,  1 = Yes Premium
            $table->string('cv_path', 200)  ;
            $table->boolean('rate')->default(0);
            $table->string('gender', 2)  ; //  Gender has two param : M = Male , F = Female
            $table->string('title', 45)->index() ;
            $table->text('about')  ;
            $table->integer('idCategory')   ;
            $table->text('education')  ;
            $table->integer('idCountry_residential')   ;
            $table->integer('idCountry_nationality')   ;
            $table->string('profile_image_path', 200);
            $table->string('profile_background_path', 200);
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
        Schema::dropIfExists('consultants');
    }
}
