<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRombelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rombels', function (Blueprint $table) {
            $table->id();
            $table->string('kode_rombel', 60);
            $table->string('label', 30);
            $table->string('kelas_id', 30);
            $table->string('guru_id');
            $table->string('periode_id');
            $table->foreign('kelas_id')->nullable()->references('kode_kelas')->on('kelas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('guru_id')->nullable()->references('nip')->on('gurus')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('periode_id')->nullable()->references('kode_periode')->on('periodes')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('rombels');
    }
}
