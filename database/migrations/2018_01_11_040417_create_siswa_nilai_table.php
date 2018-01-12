<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiswaNilaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswa_nilai', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('siswa_id')->unsigned();
            $table->integer('tingkat_mapel_id')->unsigned();
            $table->double('nilai');
            $table->timestamps();
            
            $table->foreign('siswa_id')->references('id')->on('siswa')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tingkat_mapel_id')->references('id')->on('tingkat_mapel')
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
        Schema::dropIfExists('siswa_nilai');
    }
}
