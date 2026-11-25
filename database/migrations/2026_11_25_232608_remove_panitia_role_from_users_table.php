<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah akun ber-role 'panitia' yang ada agar tidak error saat enum dipersempit
        DB::table('users')->where('role', 'panitia')->update(['role' => 'admin']);

        // Ubah enum kolom role menjadi hanya 'admin' dan 'peserta'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'peserta') NOT NULL DEFAULT 'peserta'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'panitia', 'peserta') NOT NULL DEFAULT 'peserta'");
    }
};
