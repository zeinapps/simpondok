<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRombelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rombel', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tingkat_id')->unsigned();
            $table->string('nama',50);
            $table->string('keterangan',50)->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('tahun_id')->unsigned();
            $table->smallInteger('max_siswa')->nullable();
            $table->timestamps();
            
            $table->foreign('tingkat_id')->references('id')->on('m_tingkat')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('tahun_id')->references('id')->on('m_tahun_ajaran')
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
        Schema::dropIfExists('rombel');
    }
}
