<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelajaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelajarans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pembelajaran');
            $table->string('periode_id');
            $table->string('rombel_id');
            $table->string('guru_id');
            $table->boolean('is_tematik');
            $table->boolean('tema_id')->nullable();
            $table->boolean('subtema_id')->nullable();
            $table->string('rpp')->nullable();
            $table->string('materi')->nullable();
            $table->string('video')->nullable();
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('pembelajarans');
    }
}
