<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama',255);
            $table->integer('nomor_induk')->nullable();
            $table->integer('tingkat_id')->unsigned()->nullable();
            $table->enum('is_lulus', ['0', '1'])->default('0');
            $table->string('foto',100)->default('0.png');
            $table->timestamps();
            
            $table->foreign('tingkat_id')->references('id')->on('m_tingkat')
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
        Schema::dropIfExists('siswa');
    }
}
