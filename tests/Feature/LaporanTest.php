<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Laporan;
use App\Models\KategoriLaporan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LaporanTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $kategori;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        // Create test user
        $this->user = User::factory()->create();

        // Create test kategori
        $this->kategori = KategoriLaporan::create([
            'nama_kategori' => 'Test Kategori'
        ]);
    }

    public function test_user_can_view_laporan_index()
    {
        $this->actingAs($this->user);

        $response = $this->get('/laporan');

        $response->assertStatus(200);
        $response->assertViewHas('laporan');
    }

    public function test_user_can_create_laporan()
    {
        $this->actingAs($this->user);

        $laporanData = [
            'judul' => 'Test Laporan',
            'deskripsi' => 'Deskripsi test laporan',
            'lokasi' => 'Gedung A Lantai 2',
            'kategori_id' => $this->kategori->id,
        ];

        $response = $this->post('/laporan', $laporanData);

        $response->assertRedirect('/laporan');
        $this->assertDatabaseHas('laporan', [
            'judul' => 'Test Laporan',
            'deskripsi' => 'Deskripsi test laporan',
            'lokasi' => 'Gedung A Lantai 2',
            'kategori_id' => $this->kategori->id,
        ]);
    }

    public function test_user_can_create_laporan_with_image()
    {
        $this->actingAs($this->user);
        Storage::fake('public');

        $file = UploadedFile::fake()->image('test.jpg');

        $laporanData = [
            'judul' => 'Test Laporan dengan Foto',
            'deskripsi' => 'Deskripsi test laporan dengan foto',
            'lokasi' => 'Gedung B Lantai 1',
            'kategori_id' => $this->kategori->id,
            'foto' => $file,
        ];

        $response = $this->post('/laporan', $laporanData);

        $response->assertRedirect('/laporan');
        $this->assertDatabaseHas('laporan', [
            'judul' => 'Test Laporan dengan Foto',
            'deskripsi' => 'Deskripsi test laporan dengan foto',
            'lokasi' => 'Gedung B Lantai 1',
            'kategori_id' => $this->kategori->id,
        ]);

        // Check if file was stored
        $laporan = Laporan::where('judul', 'Test Laporan dengan Foto')->first();
        Storage::disk('public')->assertExists($laporan->foto);
    }

    public function test_user_can_view_own_laporan()
    {
        $this->actingAs($this->user);

        $laporan = Laporan::create([
            'user_id' => $this->user->id,
            'judul' => 'Test Laporan View',
            'deskripsi' => 'Deskripsi test',
            'lokasi' => 'Test Lokasi',
            'kategori_id' => $this->kategori->id,
        ]);

        $response = $this->get('/laporan/' . $laporan->id);

        $response->assertStatus(200);
        $response->assertViewHas('laporan', $laporan);
    }

    public function test_user_cannot_view_other_users_laporan()
    {
        $this->actingAs($this->user);

        $otherUser = User::factory()->create(['role' => 'mahasiswa']);
        $laporan = Laporan::create([
            'user_id' => $otherUser->id,
            'judul' => 'Other User Laporan',
            'deskripsi' => 'Deskripsi test',
            'lokasi' => 'Test Lokasi',
            'kategori_id' => $this->kategori->id,
        ]);

        $response = $this->get('/laporan/' . $laporan->id);

        $response->assertStatus(403);
    }

    public function test_user_can_edit_own_unprocessed_laporan()
    {
        $this->actingAs($this->user);

        $laporan = Laporan::create([
            'user_id' => $this->user->id,
            'judul' => 'Test Laporan Edit',
            'deskripsi' => 'Deskripsi test',
            'lokasi' => 'Test Lokasi',
            'status' => 'Belum Diproses',
            'kategori_id' => $this->kategori->id,
        ]);

        $response = $this->get('/laporan/' . $laporan->id . '/edit');

        $response->assertStatus(200);
        $response->assertViewHas('laporan', $laporan);
    }

    public function test_user_cannot_edit_processed_laporan()
    {
        $this->actingAs($this->user);

        $laporan = Laporan::create([
            'user_id' => $this->user->id,
            'judul' => 'Test Laporan Processed',
            'deskripsi' => 'Deskripsi test',
            'lokasi' => 'Test Lokasi',
            'status' => 'Diproses',
            'kategori_id' => $this->kategori->id,
        ]);

        $response = $this->get('/laporan/' . $laporan->id . '/edit');

        $response->assertStatus(403);
    }

    public function test_user_can_update_own_unprocessed_laporan()
    {
        $this->actingAs($this->user);

        $laporan = Laporan::create([
            'user_id' => $this->user->id,
            'judul' => 'Test Laporan Update',
            'deskripsi' => 'Deskripsi test',
            'lokasi' => 'Test Lokasi',
            'status' => 'Belum Diproses',
            'kategori_id' => $this->kategori->id,
        ]);

        $updateData = [
            'judul' => 'Updated Test Laporan',
            'deskripsi' => 'Updated deskripsi',
            'lokasi' => 'Updated Lokasi',
            'kategori_id' => $this->kategori->id,
        ];

        $response = $this->put('/laporan/' . $laporan->id, $updateData);

        $response->assertRedirect('/laporan');
        $this->assertDatabaseHas('laporan', array_merge([
            'judul' => 'Updated Test Laporan',
            'deskripsi' => 'Updated deskripsi',
            'lokasi' => 'Updated Lokasi',
            'kategori_id' => $this->kategori->id,
        ], ['id' => $laporan->id]));
    }

    public function test_user_can_delete_own_unprocessed_laporan()
    {
        $this->actingAs($this->user);

        $laporan = Laporan::create([
            'user_id' => $this->user->id,
            'judul' => 'Test Laporan Delete',
            'deskripsi' => 'Deskripsi test',
            'lokasi' => 'Test Lokasi',
            'status' => 'Belum Diproses',
            'kategori_id' => $this->kategori->id,
        ]);

        $response = $this->delete('/laporan/' . $laporan->id);

        $response->assertRedirect('/laporan');
        $this->assertDatabaseMissing('laporan', ['id' => $laporan->id]);
    }

    public function test_user_cannot_delete_processed_laporan()
    {
        $this->actingAs($this->user);

        $laporan = Laporan::create([
            'user_id' => $this->user->id,
            'judul' => 'Test Laporan Processed Delete',
            'deskripsi' => 'Deskripsi test',
            'lokasi' => 'Test Lokasi',
            'status' => 'Diproses',
            'kategori_id' => $this->kategori->id,
        ]);

        $response = $this->delete('/laporan/' . $laporan->id);

        $response->assertStatus(403);
        $this->assertDatabaseHas('laporan', ['id' => $laporan->id]);
    }

    public function test_role_based_access_control()
    {
        // Test without authentication
        $response = $this->get('/laporan');
        $response->assertRedirect('/login');

        // Test with wrong role
        $adminUser = User::factory()->create(['role' => 'admin']);
        $this->actingAs($adminUser);

        $response = $this->get('/laporan');
        $response->assertRedirect('/'); // Should redirect to home due to role middleware
    }
}
