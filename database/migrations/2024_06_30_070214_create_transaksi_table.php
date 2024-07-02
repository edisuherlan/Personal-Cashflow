<?php
// Aplikasi ini dikembangkan oleh Edi Suherlan
// mail: edisuherlan@gmail.com -->
// GitHub: https://github.com/edisuherlan

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('deskripsi');
            $table->decimal('uang_masuk', 15, 2)->nullable();
            $table->decimal('uang_keluar', 15, 2)->nullable();
            $table->string('foto_transaksi')->nullable();
            $table->string('email');
            $table->foreign('email')->references('email')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('transaksi');
    }
}
