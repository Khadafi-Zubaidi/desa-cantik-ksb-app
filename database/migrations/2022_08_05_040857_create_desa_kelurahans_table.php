<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desa_kelurahans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_kecamatan');
            $table->string('kode_wilayah_desa_kelurahan');
            $table->string('nama_desa_kelurahan');
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
        Schema::dropIfExists('desa_kelurahans');
    }
};
