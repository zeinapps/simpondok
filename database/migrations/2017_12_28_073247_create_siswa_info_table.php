<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiswaInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswa_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('siswa_id')->unsigned();
            //keterangan siswa
            $table->string('tempat_lahir',100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('kelamin', ['L', 'P']);
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu', 'Lainnya'])->default('Islam');
            $table->enum('status_keluarga', ['Kandung', 'Tiri', 'Angkat'])->default('Kandung');
            $table->smallInteger('anak_ke')->nullable();
            $table->smallInteger('jml_saudara_kandung')->nullable();
            $table->smallInteger('jml_saudara_tiri')->nullable();
            $table->smallInteger('jml_saudara_angkat')->nullable();
            $table->enum('yatim', ['Yatim', 'Yatim Piatu', 'Tidak'])->nullable();
            $table->string('kewarganegaraan',100)->nullable();
            $table->string('bahasa',100)->nullable();
            //keterangan tempat tinggal
            $table->string('alamat',255)->nullable();
            $table->string('kelurahan',100)->nullable();
            $table->string('kecamatan',100)->nullable();
            $table->string('kota',100)->nullable();
            $table->string('kode_pos',10)->nullable();
            $table->string('telp',20)->nullable();
            $table->string('tinggal_dengan',100)->nullable();
            $table->string('jarak_sekolah',100)->nullable();
            //keterangan kesehatan
            $table->string('golongan_darah',5)->nullable();
            $table->string('penyakit',100)->nullable();
            $table->string('kelainan',100)->nullable();
            $table->smallInteger('tinggi')->nullable();
            $table->smallInteger('berat')->nullable();
            //keterangan pendidikan Sebelumnya
            $table->string('lulus_dari',255)->nullable(); //nama sekolah
            $table->string('no_ijazah_sebelum',100)->nullable();
            $table->date('tanggal_ijazah_sebelum')->nullable();
            $table->string('no_shus_sebelum',100)->nullable();
            $table->smallInteger('tanggal_shus_sebelum')->nullable();
            //keterangan pendidikan Mutasi Masuk
            $table->string('sekolah_asal',255)->nullable();
            $table->string('keterangan_lain',20)->nullable();
            //keterangan pendidikan sekolah ini
            $table->string('di_kelas',255)->nullable();
            $table->date('tanggal_diterima')->nullable();
            //keterangan tentang ayah kandung
            $table->string('nama_ayah',255)->nullable();
            $table->string('tempat_lahir_ayah',255)->nullable();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->enum('agama_ayah', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu', 'Lainnya'])->default('Islam');
            $table->string('kewarganegaraan_ayah',100)->nullable();
            $table->enum('pendidikan_ayah',['SD','SMP','SMA','S1','S2','S3'])->nullable();
            $table->string('pekerjaan_ayah',100)->nullable();
            $table->string('penghasilan_ayah',255)->nullable();
            $table->string('telp_ayah',20)->nullable();
            $table->enum('is_hidup_ayah',['0','1'])->nullable();
            $table->string('tahun_meninggal_ayah',4)->nullable();
            $table->string('nik_ayah',16)->nullable();
            //keterangan tentang ibu kandung
            $table->string('nama_ibu',255)->nullable();
            $table->string('tempat_lahir_ibu',255)->nullable();
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->enum('agama_ibu', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu', 'Lainnya'])->default('Islam');
            $table->string('kewarganegaraan_ibu',100)->nullable();
            $table->enum('pendidikan_ibu',['SD','SMP','SMA','S1','S2','S3'])->nullable();
            $table->string('pekerjaan_ibu',100)->nullable();
            $table->string('penghasilan_ibu',255)->nullable();
            $table->string('telp_ibu',20)->nullable();
            $table->enum('is_hidup_ibu',['0','1'])->nullable();
            $table->string('tahun_meninggal_ibu',4)->nullable();
            $table->string('nik_ibu',16)->nullable();
            
            //keterangan tentang wali
            $table->string('nama_wali',255)->nullable();
            $table->string('tempat_lahir_wali',255)->nullable();
            $table->date('tanggal_lahir_wali')->nullable();
            $table->enum('agama_wali', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu', 'Lainnya'])->default('Islam');
            $table->string('kewarganegaraan_wali',100)->nullable();
            $table->enum('pendidikan_wali',['SD','SMP','SMA','S1','S2','S3'])->nullable();
            $table->string('pekerjaan_wali',100)->nullable();
            $table->string('penghasilan_wali',255)->nullable();
            $table->string('telp_wali',20)->nullable();
            $table->enum('is_hidup_wali',['0','1'])->nullable();
            $table->string('tahun_meninggal_wali',4)->nullable();
            $table->string('nik_wali',16)->nullable();
            //kegemaran siswa
            $table->string('kesenian',100)->nullable();
            $table->string('olah_raga',100)->nullable();
            $table->string('organisasi',100)->nullable();
            $table->string('kegemaran_lain',100)->nullable();
            //perkembangan siswa
            $table->string('tahun_beasiswa',4)->nullable();
            $table->date('tanggal_pindah')->nullable();
            $table->string('alasan_pindah',255)->nullable();
             $table->string('no_ijazah',100)->nullable();
            $table->date('tanggal_ijazah')->nullable();
             $table->string('no_shun',100)->nullable();
            $table->date('tanggal_shun')->nullable();
            //keterangan lulus
            $table->string('melanjutkan_ke',100)->nullable();
            $table->date('tanggal_mulai_kerja')->nullable();
            $table->string('nama_perusahaan',100)->nullable();
            $table->string('penghasilan',100)->nullable();
            
            $table->string('lain_lain',255)->nullable();
            
            $table->timestamps();
            
            $table->foreign('siswa_id')->references('id')->on('siswa')
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
        Schema::dropIfExists('siswa_info');
    }
}
