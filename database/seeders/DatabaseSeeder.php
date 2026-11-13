<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Peserta;
use App\Models\Speaker;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Pengguna (Role: Admin, Panitia, Peserta, Akun Nonaktif)
        $admin = User::updateOrCreate(
            ['email' => 'admin@event.test'],
            [
                'nama'      => 'Administrator Utama',
                'nim'       => '102022400001',
                'prodi'     => 'S1 Sistem Informasi',
                'password'  => Hash::make('password123'),
                'role'      => 'admin',
                'is_active' => true,
            ]
        );

        $panitia = User::updateOrCreate(
            ['email' => 'panitia@event.test'],
            [
                'nama'      => 'Panitia Pelaksana',
                'nim'       => '102022400002',
                'prodi'     => 'S1 Informatika',
                'password'  => Hash::make('password123'),
                'role'      => 'panitia',
                'is_active' => true,
            ]
        );

        $pesertaUser = User::updateOrCreate(
            ['email' => 'peserta@event.test'],
            [
                'nama'      => 'Peserta Event (Budi)',
                'nim'       => '102022400003',
                'prodi'     => 'S1 Teknologi Informasi',
                'password'  => Hash::make('password123'),
                'role'      => 'peserta',
                'is_active' => true,
            ]
        );

        $inactiveUser = User::updateOrCreate(
            ['email' => 'nonaktif@event.test'],
            [
                'nama'      => 'User Akun Diblokir',
                'nim'       => '102022400099',
                'prodi'     => 'S1 Sistem Informasi',
                'password'  => Hash::make('password123'),
                'role'      => 'peserta',
                'is_active' => false, // Nonaktif untuk testing EnsureUserIsActive middleware
            ]
        );

        // Akun Praktikan lama tetap ada sebagai Admin
        User::updateOrCreate(
            ['email' => 'praktikan@student.telkomuniversity.ac.id'],
            [
                'nama'      => 'Praktikan WAD',
                'nim'       => '102022400088',
                'prodi'     => 'S1 Sistem Informasi',
                'password'  => Hash::make('password123'),
                'role'      => 'admin',
                'is_active' => true,
            ]
        );

        // 2. Modul Master Event (Individu A)
        if (Event::count() === 0) {
            Event::create([
                'judul_event'   => 'Workshop Fullstack Web Development Modern 2026',
                'deskripsi'     => 'Pelatihan intensif pengembangan aplikasi web berbasis MVC Laravel 10 dan Tailwind CSS.',
                'kategori'      => 'Teknologi',
                'silabus'       => "1. Arsitektur RESTful API & Relational Database\n2. Otentikasi & Role-Based Middleware\n3. Blade Templating & Dynamic CRUD",
                'durasi_sesi'   => '2 Hari (12 Jam)',
                'tanggal_mulai' => '2026-11-20',
                'lokasi'        => 'Auditorium Gd. Damar Telkom University',
            ]);

            Event::create([
                'judul_event'   => 'Seminar Nasional Cyber Security & Cloud Defense',
                'deskripsi'     => 'Membahas ancaman keamanan siber modern, OWASP Top 10, dan implementasi cloud security.',
                'kategori'      => 'Teknologi',
                'silabus'       => "1. Pengenalan OWASP Top 10 Vulnerabilities\n2. Praktik Pengamanan Endpoints & Authorization\n3. Cloud Hardening Architecture",
                'durasi_sesi'   => '1 Hari (4 Jam)',
                'tanggal_mulai' => '2026-12-05',
                'lokasi'        => 'Hybrid (Zoom & Hall B Telkom University)',
            ]);

            Event::create([
                'judul_event'   => 'Masterclass Startup Business Model & Monetization',
                'deskripsi'     => 'Strategi validasi ide bisnis, perancangan revenue stream, dan pitching investor untuk tech startup.',
                'kategori'      => 'Bisnis',
                'silabus'       => "1. Lean Canvas Formulation\n2. Customer Acquisition Strategy\n3. Financial Projection & Investor Pitch",
                'durasi_sesi'   => '1 Hari (5 Jam)',
                'tanggal_mulai' => '2026-12-12',
                'lokasi'        => 'Ruang Seminar FRI Lt. 3',
            ]);
        }

        // 3. Modul Pembicara / Speaker (Individu B)
        if (Speaker::count() === 0) {
            Speaker::create([
                'nama'       => 'Dr. Ir. Syafiq Ahmad',
                'email'      => 'syafiq@expert.com',
                'topik'      => 'AI & Machine Learning dalam Industri Modern',
                'keahlian'   => 'Artificial Intelligence, Big Data',
                'institusi'  => 'Universitas Indonesia',
                'portofolio' => 'https://linkedin.com/in/syafiq-ahmad',
                'no_hp'      => '081122334455',
            ]);

            Speaker::create([
                'nama'       => 'Maya Putri, M.T.',
                'email'      => 'maya.putri@tech.id',
                'topik'      => 'Pengembangan Web Modern dengan Laravel & MySQL',
                'keahlian'   => 'Fullstack Web Development, Cloud Architecture',
                'institusi'  => 'Tech Innovators Academy',
                'portofolio' => 'https://github.com/mayaputri',
                'no_hp'      => '085566778899',
            ]);
        }

        // 4. Modul Tiket & Kategori (Individu C)
        if (Ticket::count() === 0) {
            Ticket::create([
                'tipe_tiket' => 'Early Bird',
                'harga'      => 75000,
                'kuota'      => 30,
                'benefit'    => "E-Sertifikat Resmi\nSnack Box\nAkses Materi Workshop Lengkap",
            ]);

            Ticket::create([
                'tipe_tiket' => 'Regular',
                'harga'      => 100000,
                'kuota'      => 50,
                'benefit'    => "E-Sertifikat Resmi\nSnack Box\nAkses Materi Workshop Lengkap\nSeminar Kit Eksklusif",
            ]);

            Ticket::create([
                'tipe_tiket' => 'VIP',
                'harga'      => 150000,
                'kuota'      => 20,
                'benefit'    => "E-Sertifikat Resmi\nLunch & Premium Snack\nAkses Kursi Baris Depan\nGoodie Bag & Merchandise Eksklusif",
            ]);
        }

        // 5. Modul Peserta & Biodata (Individu D)
        if (Peserta::count() === 0) {
            $ticket1 = Ticket::first();
            $ticket2 = Ticket::skip(1)->first() ?? $ticket1;
            $ticket3 = Ticket::skip(2)->first() ?? $ticket1;

            Peserta::create([
                'user_id'           => $pesertaUser->id,
                'id_tiket'          => $ticket1 ? $ticket1->id : 1,
                'nama_lengkap'      => 'Budi Santoso',
                'email'             => 'peserta@event.test',
                'no_hp'             => '081234567890',
                'institusi'         => 'Universitas Indonesia',
                'status_pembayaran' => 'Lunas',
            ]);

            Peserta::create([
                'user_id'           => null,
                'id_tiket'          => $ticket2 ? $ticket2->id : 1,
                'nama_lengkap'      => 'Siti Rahma',
                'email'             => 'siti.rahma@yahoo.com',
                'no_hp'             => '081987654321',
                'institusi'         => 'Institut Teknologi Bandung',
                'status_pembayaran' => 'Lunas',
            ]);

            Peserta::create([
                'user_id'           => null,
                'id_tiket'          => $ticket3 ? $ticket3->id : 1,
                'nama_lengkap'      => 'Andi Pratama',
                'email'             => 'andi.pratama@gmail.com',
                'no_hp'             => '085712345678',
                'institusi'         => 'Telkom University',
                'status_pembayaran' => 'Menunggu',
            ]);
        }
    }
}
