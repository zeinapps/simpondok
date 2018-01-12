<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRombelMapelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rombel_mapel', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rombel_id')->unsigned();
            $table->integer('tingkat_mapel_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            
            $table->foreign('rombel_id')->references('id')->on('rombel')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tingkat_mapel_id')->references('id')->on('tingkat_mapel')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('rombel_mapel');
    }
}
