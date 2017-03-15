<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_notifications', function (Blueprint $table) {
//          , , timestamp, last_update_date
            $table->bigIncrements('idNotification');
            $table->integer('type')   ;// 1 = comment on article to be reviewed ,2 = comment on question to be reviewed ,
            //3 = reminder to meeting ,4 = answer to question to be published ,5 = survey done by customer ,
            //6 = meeting accepted by consultant ,7 = meeting rejected by consultant ,8 = consultant updated profile picture,
            // 9 = payment success by customer ,10= payment failed by customer ,11= customer uploaded profile picture ,
            //12 = new consultant registered on the system ,13 = customer write on consultant recommendation wall

            $table->integer('idType')   ; // Based on the type - transaction ID will be put into this table
            $table->bigInteger('idAdmin')->unsigned();
            $table->foreign('idAdmin')->references('id')->on('admins')->onDelete('cascade');
            $table->bigInteger('idLanguage')->unsigned();
            $table->foreign('idLanguage')->references('id')->on('languages')->onDelete('cascade');
            $table->string('text', 200)  ;
            $table->integer('status')   ; //1 = pending to be send to customer , 2 = attempt to send and failed - no retry ,
            //3 = succeed , 4 = retry

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
        Schema::dropIfExists('admin_notifications');
    }
}
