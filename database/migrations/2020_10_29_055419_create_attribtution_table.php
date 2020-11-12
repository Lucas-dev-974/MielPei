<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttribtutionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('attributions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('horraire');
            $table->bigInteger('id_client')->unsigned()->nullable();
            $table->bigInteger('id_ordi')->unsigned()->nullable();

            $table->foreign('id_ordi')->references('id')->on('ordinateurs')->onDelete('cascade');
            $table->foreign('id_client')->references('id')->on('clients')->onDelete('cascade');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('attributions');
    }
}
