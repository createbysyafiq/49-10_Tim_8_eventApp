# Sistem Pengelolaan Event & Workshop
**Studi Kasus 08 - Tugas Besar Mata Kuliah Pengembangan Aplikasi Web (PAW)**

---

## 👥 Pembagian 4 Modul Anggota (Team Repository Merge)
1. **Modul Master Event (Individu A):** Pengelolaan agenda workshop, silabus, durasi, kategori (Teknologi/Bisnis).
2. **Modul Pembicara / Speaker (Individu B):** Pengelolaan data narasumber, riwayat institusi, bidang keahlian, topik, portofolio.
3. **Modul Tiket & Kategori (Individu C):** Pengelolaan tipe tiket (Early Bird, Regular, VIP), harga, kuota, benefit, poster.
4. **Modul Peserta & Biodata (Individu D):** Pendaftaran peserta, nomor kontak, kampus/institusi, tiket pilihan, status kehadiran.

---

## 🛡️ Role Access Control & Middleware Architecture

Aplikasi menerapkan sistem keamanan berlapis sesuai materi perkuliahan:
1. **Otentikasi (AuthN):** Registrasi pengguna & Login dengan `password_hash()` + `session_regenerate()`.
2. **Custom Middleware:**
   - `EnsureUserHasRole`: Menolak pengguna yang tidak memiliki peran yang diizinkan (parameterized: `role:admin,panitia`).
   - `EnsureUserIsActive`: Memeriksa apakah status akun aktif (`is_active = true`). Akun nonaktif langsung dilogout dan diblokir dari sistem.
3. **Laravel Gates & Policies:**
   - `Gate::define('manage-users')`, `Gate::define('manage-all')`, `Gate::define('delete-record')`
   - `TicketPolicy`, `PesertaPolicy`, `EventPolicy`, `SpeakerPolicy`
   - **ABAC (Attribute-Based Access Control / Anti-IDOR):** Pada `PesertaPolicy`, peserta hanya dapat melihat dan memperbarui pendaftaran miliknya sendiri (`user_id` / `email` match), sedangkan Admin & Panitia dapat melihat seluruh pendaftar.

---

## 📊 Matriks Otorisasi (Permission Matrix)

| Rute URL | HTTP Method | Guard / Middleware | Role Diizinkan | Expected Status Code |
| :--- | :---: | :--- | :--- | :---: |
| `/login` & `/register` | GET, POST | `guest` | Guest (belum login) | `200` / `302` |
| `/dashboard` | GET | `auth`, `active` | Peserta, Panitia, Admin | `200` (Guest: `302`) |
| `/events` | GET | `auth`, `active` | Peserta, Panitia, Admin | `200` |
| `/events/create` | GET, POST | `auth`, `active`, `role:admin,panitia` | Panitia, Admin | `200` (Peserta: `403`) |
| `/events/{id}` | DELETE | `auth`, `active`, `role:admin` | Admin | `302` (Panitia/Peserta: `403`) |
| `/speakers` | GET | `auth`, `active` | Peserta, Panitia, Admin | `200` |
| `/speakers/create` | GET, POST | `auth`, `active`, `role:admin,panitia` | Panitia, Admin | `200` (Peserta: `403`) |
| `/speakers/{id}` | DELETE | `auth`, `active`, `role:admin` | Admin | `302` (Panitia/Peserta: `403`) |
| `/tickets` | GET | `auth`, `active` | Peserta, Panitia, Admin | `200` |
| `/tickets/create` | GET, POST | `auth`, `active`, `role:admin,panitia` | Panitia, Admin | `200` (Peserta: `403`) |
| `/tickets/{id}` | DELETE | `auth`, `active`, `role:admin` | Admin | `302` (Panitia/Peserta: `403`) |
| `/peserta` | GET | `auth`, `active` | Peserta (own only), Panitia, Admin | `200` |
| `/peserta/create` | GET, POST | `auth`, `active` | Semua pengguna login | `200` / `302` |
| `/peserta/{id}/edit` | GET, PUT | `auth`, `active`, `PesertaPolicy` | Owner (pemilik data), Panitia, Admin | `200` (Bukan owner: `403`) |
| `/peserta/{id}` | DELETE | `auth`, `active`, `role:admin` | Admin | `302` (Panitia/Peserta: `403`) |

---

## 🔑 Akun Demo Pengujian (Seed Data)

Untuk mempermudah pengujian dosen/asisten praktikum:
- **Admin:** `admin@event.test` | Kata sandi: `password123`
- **Panitia:** `panitia@event.test` | Kata sandi: `password123`
- **Peserta:** `peserta@event.test` | Kata sandi: `password123`
- **Akun Nonaktif:** `nonaktif@event.test` | Kata sandi: `password123` (Uji coba penolakan middleware `EnsureUserIsActive`)

---

## 🧪 Hasil Pengujian Otomatis (Feature Tests)
Semua 13 pengujian otomatis lulus:
```bash
php artisan test

   PASS  Tests\Unit\ExampleTest
   PASS  Tests\Feature\ExampleTest
   PASS  Tests\Feature\RoleAccessControlTest
  ✓ guest cannot access dashboard and redirects to login (302)
  ✓ guest can access login and register pages (200)
  ✓ inactive user cannot login (blocked)
  ✓ active user can login and redirects to dashboard (302)
  ✓ peserta can view tickets index (200)
  ✓ peserta cannot access create ticket page returns 403
  ✓ peserta cannot store ticket returns 403
  ✓ panitia can store ticket (302)
  ✓ panitia cannot delete ticket returns 403
  ✓ admin can delete ticket (302)
  ✓ peserta cannot view or edit other peserta submission (403 IDOR prevention)
```
