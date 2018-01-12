<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRiwayatPendidikanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riwayat_pendidikan', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('jenjang_id')->unsigned();
            $table->string('nama_sekolah',50);
            $table->string('tahun_masuk',4)->nullable();
            $table->string('tahun_lulus',4);
            $table->timestamps();
            $table->foreign('jenjang_id')->references('id')->on('m_jenjang')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['user_id', 'jenjang_id']);
            
            
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
        Schema::dropIfExists('riwayat_pendidikan');
    }
}
