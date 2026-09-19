<?php

namespace Tests\Feature;

use App\Models\Tamu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TamuFlowTest extends TestCase
{
    use RefreshDatabase;

    private function pngDataUri(): string
    {
        $image = imagecreatetruecolor(10, 10);
        imagefill($image, 0, 0, imagecolorallocate($image, 24, 121, 78));
        ob_start();
        imagepng($image);
        $contents = ob_get_clean();
        imagedestroy($image);

        return 'data:image/png;base64,'.base64_encode($contents);
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'nama_tamu' => 'Budi Santoso',
            'jenis_kelamin' => 'L',
            'nohp' => '081234567890',
            'asal' => 'Dinas Pendidikan',
            'tujuan' => 'Pertemuan sekolah',
            'keterangan' => 'Ruang kepala sekolah',
            'gambar' => $this->pngDataUri(),
        ], $overrides);
    }

    private function makeTamu(array $overrides = []): Tamu
    {
        return Tamu::create(array_merge([
            'nama_tamu' => 'Budi Santoso',
            'jenis_kelamin' => 'L',
            'nohp' => '081234567890',
            'asal' => 'Dinas Pendidikan',
            'tujuan' => 'Pertemuan sekolah',
            'keterangan' => null,
            'gambar' => 'foto.jpg',
        ], $overrides));
    }

    public function test_public_form_accepts_valid_visit_and_stores_private_photo(): void
    {
        Storage::fake('local');

        $this->post(route('tamu.store'), $this->validPayload())
            ->assertRedirect(route('tamu.create'))
            ->assertSessionHas('success');

        $record = Tamu::sole();
        Storage::disk('local')->assertExists('visitor-photos/'.$record->gambar);
        $this->assertStringEndsWith('.jpg', $record->gambar);
        $this->assertSame('Pertemuan sekolah', $record->tujuan);
    }

    public function test_form_rejects_missing_or_invalid_photo(): void
    {
        $this->from(route('tamu.create'))
            ->post(route('tamu.store'), $this->validPayload(['gambar' => 'bukan-gambar']))
            ->assertRedirect(route('tamu.create'))
            ->assertSessionHasErrors('gambar');

        $this->assertDatabaseCount('tamu', 0);
    }

    public function test_guest_cannot_access_records_or_photos(): void
    {
        $record = $this->makeTamu();

        $this->get(route('dashboard.index'))->assertRedirect(route('login'));
        $this->get(route('rekap.index'))->assertRedirect(route('login'));
        $this->get(route('rekap.data'))->assertRedirect(route('login'));
        $this->get(route('rekap.show', $record))->assertRedirect(route('login'));
        $this->get(route('rekap.photo', $record))->assertRedirect(route('login'));
        $this->get(route('rekap.export.excel'))->assertRedirect(route('login'));
        $this->get(route('tamu.index'))->assertRedirect(route('login'));
    }

    public function test_admin_can_filter_update_and_delete_visit_without_changing_timestamp(): void
    {
        Storage::fake('local');
        $admin = User::factory()->create();
        $record = $this->makeTamu(['nama_tamu' => 'Target Filter', 'gambar' => 'target.jpg']);
        $other = $this->makeTamu(['nama_tamu' => 'Nama Lain', 'gambar' => 'other.jpg']);
        Storage::disk('local')->put('visitor-photos/target.jpg', 'photo');
        Storage::disk('local')->put('visitor-photos/other.jpg', 'photo');
        $originalTimestamp = $record->refresh()->tanggal;

        $this->actingAs($admin)
            ->getJson(route('rekap.data', [
                'draw' => 1,
                'start' => 0,
                'length' => 25,
                'search' => ['value' => 'Target', 'regex' => 'false'],
            ]))
            ->assertOk()
            ->assertJsonPath('recordsFiltered', 1)
            ->assertSee('Target Filter')
            ->assertDontSee('Nama Lain');

        $this->actingAs($admin)
            ->put(route('rekap.update', $record), [
                'nama_tamu' => 'Target Diperbarui',
                'jenis_kelamin' => 'P',
                'nohp' => '081111111111',
                'asal' => 'Instansi Baru',
                'tujuan' => 'Koordinasi',
                'keterangan' => 'Selesai',
            ])
            ->assertRedirect(route('rekap.show', $record));

        $record->refresh();
        $this->assertSame('Target Diperbarui', $record->nama_tamu);
        $this->assertTrue($originalTimestamp->equalTo($record->tanggal));

        $this->actingAs($admin)
            ->delete(route('rekap.destroy', $record))
            ->assertRedirect(route('rekap.index'));

        $this->assertModelMissing($record);
        Storage::disk('local')->assertMissing('visitor-photos/target.jpg');
        $this->assertModelExists($other);
    }

    public function test_admin_can_download_filtered_excel_and_pdf(): void
    {
        $admin = User::factory()->create();
        $this->makeTamu(['nama_tamu' => 'Ekspor Tamu']);

        $this->actingAs($admin)
            ->get(route('rekap.export.excel', ['search' => 'Ekspor']))
            ->assertOk()
            ->assertDownload();

        $this->actingAs($admin)
            ->get(route('rekap.export.pdf', ['search' => 'Ekspor']))
            ->assertOk()
            ->assertDownload();
    }

    public function test_private_photo_is_available_to_admin(): void
    {
        Storage::fake('local');
        $admin = User::factory()->create();
        $record = $this->makeTamu(['gambar' => 'private.jpg']);
        Storage::disk('local')->put('visitor-photos/private.jpg', 'private-image');

        $this->actingAs($admin)
            ->get(route('rekap.photo', $record))
            ->assertOk();
    }
}
