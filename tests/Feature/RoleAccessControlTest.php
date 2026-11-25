<?php

namespace Tests\Feature;

use App\Models\Peserta;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RoleAccessControlTest extends TestCase
{
    protected User $admin;
    protected User $peserta;
    protected User $inactiveUser;
    protected Ticket $ticket;

    protected function setUp(): void
    {
        parent::setUp();

        // Siapkan data user uji coba (2 role: admin & peserta)
        $this->admin = User::firstOrCreate(
            ['email' => 'admin_test@event.test'],
            [
                'nama' => 'Admin Test',
                'nim' => '999001',
                'prodi' => 'S1 SI',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        $this->peserta = User::firstOrCreate(
            ['email' => 'peserta_test@event.test'],
            [
                'nama' => 'Peserta Test',
                'nim' => '999003',
                'prodi' => 'S1 TI',
                'password' => Hash::make('password123'),
                'role' => 'peserta',
                'is_active' => true,
            ]
        );

        $this->inactiveUser = User::firstOrCreate(
            ['email' => 'inactive_test@event.test'],
            [
                'nama' => 'Inactive Test',
                'nim' => '999004',
                'prodi' => 'S1 SI',
                'password' => Hash::make('password123'),
                'role' => 'peserta',
                'is_active' => false,
            ]
        );

        $this->ticket = Ticket::firstOrCreate(
            ['tipe_tiket' => 'VIP Testing'],
            [
                'harga' => 150000,
                'kuota' => 20,
                'benefit' => 'Akses Eksklusif Testing',
            ]
        );
    }

    /**
     * Rule 1 (Guest): Pengguna belum login dialihkan ke halaman login (302).
     */
    public function test_guest_cannot_access_dashboard_and_redirects_to_login(): void
    {
        $response = $this->get('/dashboard');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Rule 2 (Guest): Pengguna belum login dapat mengakses form login & registrasi (200).
     */
    public function test_guest_can_access_login_and_register_pages(): void
    {
        $this->get('/login')->assertStatus(200);
        $this->get('/register')->assertStatus(200);
    }

    /**
     * Rule 2b (Register): Pengguna baru dapat registrasi akun tanpa field NIM dan Prodi.
     */
    public function test_user_can_register_without_nim_and_prodi(): void
    {
        User::where('email', 'userbaru@event.test')->delete();

        $response = $this->post('/register', [
            'nama' => 'User Baru',
            'email' => 'userbaru@event.test',
            'role' => 'peserta',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('users', [
            'email' => 'userbaru@event.test',
            'nama' => 'User Baru',
            'nim' => null,
            'prodi' => null,
            'role' => 'peserta',
        ]);
    }

    /**
     * Rule 3 (Active Account): Pengguna nonaktif diblokir saat mencoba login.
     */
    public function test_inactive_user_cannot_login(): void
    {
        $response = $this->post('/login', [
            'email' => $this->inactiveUser->email,
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Rule 4 (Auth): Pengguna aktif berhasil login dan diarahkan ke dashboard (302).
     */
    public function test_active_user_can_login_and_redirects_to_dashboard(): void
    {
        $response = $this->post('/login', [
            'email' => $this->peserta->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($this->peserta);
    }

    /**
     * Rule 5 (RBAC Read): Peserta diizinkan melihat katalog tiket (200).
     */
    public function test_peserta_can_view_tickets_index(): void
    {
        $response = $this->actingAs($this->peserta)->get('/tickets');
        $response->assertStatus(200);
    }

    /**
     * Rule 6 (RBAC Create Deny): Peserta DITOLAK saat membuka form tambah tiket (403 Forbidden).
     */
    public function test_peserta_cannot_access_create_ticket_page_returns_403(): void
    {
        $response = $this->actingAs($this->peserta)->get('/tickets/create');
        $response->assertStatus(403);
    }

    /**
     * Rule 7 (RBAC Store Deny): Peserta DITOLAK saat mencoba menyimpan tiket baru via POST (403 Forbidden).
     */
    public function test_peserta_cannot_store_ticket_returns_403(): void
    {
        $response = $this->actingAs($this->peserta)->post('/tickets', [
            'tipe_tiket' => 'Hacker Pass',
            'harga' => 1000,
            'kuota' => 10,
            'benefit' => 'Illegal benefit',
        ]);

        $response->assertStatus(403);
    }

    /**
     * Rule 8 (RBAC Delete Deny): Peserta DITOLAK saat mencoba menghapus tiket (403 Forbidden).
     */
    public function test_peserta_cannot_delete_ticket_returns_403(): void
    {
        $response = $this->actingAs($this->peserta)->delete('/tickets/' . $this->ticket->id);
        $response->assertStatus(403);
    }

    /**
     * Rule 9 (RBAC Create Allow): Admin DISETUJUI menambah tiket baru (302).
     */
    public function test_admin_can_store_ticket(): void
    {
        $response = $this->actingAs($this->admin)->post('/tickets', [
            'tipe_tiket' => 'Regular Admin Test',
            'harga' => 90000,
            'kuota' => 25,
            'benefit' => 'Benefit Resmi Admin',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('tickets.index'));
        $this->assertDatabaseHas('tickets', ['tipe_tiket' => 'Regular Admin Test']);

        // Bersihkan data uji agar tidak menumpuk
        Ticket::where('tipe_tiket', 'Regular Admin Test')->delete();
    }

    /**
     * Rule 10 (RBAC Delete Allow): Admin DISETUJUI menghapus tiket (302).
     */
    public function test_admin_can_delete_ticket(): void
    {
        $ticketToDelete = Ticket::create([
            'tipe_tiket' => 'Ticket To Delete',
            'harga' => 50000,
            'kuota' => 5,
            'benefit' => 'Test',
        ]);

        $response = $this->actingAs($this->admin)->delete('/tickets/' . $ticketToDelete->id);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('tickets', ['id' => $ticketToDelete->id]);
    }

    /**
     * Rule 11 (ABAC Ownership Check): Peserta hanya boleh melihat datanya sendiri, ditolak jika akses milik orang lain.
     */
    public function test_peserta_cannot_view_or_edit_other_peserta_submission(): void
    {
        $pesertaA = Peserta::create([
            'user_id' => $this->peserta->id,
            'id_tiket' => $this->ticket->id,
            'nama_lengkap' => 'Peserta A (Budi)',
            'email' => $this->peserta->email,
            'no_hp' => '0812345678',
            'institusi' => 'Telkom University',
        ]);

        $userOther = User::firstOrCreate(
            ['email' => 'other_user@event.test'],
            [
                'nama' => 'Other User',
                'nim' => '999888',
                'prodi' => 'S1 SI',
                'password' => Hash::make('password123'),
                'role' => 'peserta',
                'is_active' => true,
            ]
        );

        $pesertaB = Peserta::create([
            'user_id' => $userOther->id,
            'id_tiket' => $this->ticket->id,
            'nama_lengkap' => 'Peserta B (Siti)',
            'email' => $userOther->email,
            'no_hp' => '0898765432',
            'institusi' => 'ITB',
        ]);

        // Peserta A mencoba mengakses edit data Peserta B -> DITOLAK 403 Forbidden (Anti-IDOR)
        $response = $this->actingAs($this->peserta)->get('/peserta/' . $pesertaB->id . '/edit');
        $response->assertStatus(403);

        // Peserta A mengakses datanya sendiri -> DIIZINKAN 200 OK
        $responseSelf = $this->actingAs($this->peserta)->get('/peserta/' . $pesertaA->id . '/edit');
        $responseSelf->assertStatus(200);

        // Bersihkan data uji
        $pesertaA->delete();
        $pesertaB->delete();
    }
}
