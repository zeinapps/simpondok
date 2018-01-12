<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRombelSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rombel_siswa', function (Blueprint $table) {
            
            $table->integer('rombel_id')->unsigned();
            $table->integer('siswa_id')->unsigned();
            $table->timestamps();
            
            $table->foreign('rombel_id')->references('id')->on('rombel')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('siswa_id')->references('id')->on('siswa')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['rombel_id', 'siswa_id']);
            
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
        Schema::dropIfExists('rombel_siswa');
    }
}
