<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMRombelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_rombel', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tingkat_id')->unsigned();
            $table->string('nama',50);
            $table->string('keterangan',50)->nullable();
            $table->smallInteger('max_siswa')->nullable();
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
        Schema::dropIfExists('m_rombel');
    }
}
