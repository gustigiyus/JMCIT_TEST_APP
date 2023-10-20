<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penduduks', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('nik', 25);
            $table->date('tgl_lahir');
            $table->enum('jns_kelamin', ['Laki-laki', 'Perempuan']);
            $table->text('alamat');
            $table->foreignId('provinsi_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('kabupaten_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduks');
    }
};
