<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMTingkatMapelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_tingkat_mapel', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tingkat_id')->unsigned();
            $table->integer('mapel_id')->unsigned();
            $table->timestamps();
            
            $table->foreign('tingkat_id')->references('id')->on('m_tingkat')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('mapel_id')->references('id')->on('m_mapel')
                ->onUpdate('cascade')->onDelete('cascade');
            
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_tingkat_mapel');
    }
}
