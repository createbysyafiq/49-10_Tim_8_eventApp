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
        Schema::create('peserta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('id_tiket')->constrained('tickets')->cascadeOnDelete();
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('no_hp');
            $table->string('institusi');
            $table->enum('status_pembayaran', ['Menunggu', 'Lunas', 'Batal'])->default('Lunas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta');
    }
};
