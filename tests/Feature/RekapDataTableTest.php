<?php

namespace Tests\Feature;

use App\Models\Tamu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class RekapDataTableTest extends TestCase
{
    use RefreshDatabase;

    public function test_endpoint_requires_a_superadmin(): void
    {
        $this->get(route('rekap.data'))->assertRedirect(route('login'));

        $operator = User::factory()->create(['role' => 'operator']);
        $this->actingAs($operator)->get(route('rekap.data'))->assertForbidden();
    }

    public function test_endpoint_returns_paginated_latest_data_without_contact(): void
    {
        $admin = User::factory()->create();

        foreach (range(1, 30) as $index) {
            $this->makeTamu(
                sprintf('Pengunjung %02d', $index),
                sprintf('2026-09-%02d 08:00:00', $index),
                ['nohp' => '0812'.str_pad((string) $index, 8, '0', STR_PAD_LEFT)]
            );
        }

        $response = $this->actingAs($admin)->getJson(route('rekap.data', $this->parameters()));

        $response
            ->assertOk()
            ->assertJsonStructure(['draw', 'recordsTotal', 'recordsFiltered', 'data'])
            ->assertJsonPath('draw', 1)
            ->assertJsonPath('recordsTotal', 30)
            ->assertJsonPath('recordsFiltered', 30)
            ->assertJsonCount(25, 'data');

        $this->assertStringContainsString('Pengunjung 30', $response->json('data.0.pengunjung'));
        $this->assertStringNotContainsString('nohp', $response->getContent());
        $this->assertStringNotContainsString('0812', $response->getContent());
    }

    public function test_search_only_matches_name_origin_and_purpose(): void
    {
        $admin = User::factory()->create();
        $this->makeTamu('Nama Khusus', '2026-09-10 08:00:00');
        $this->makeTamu('Tamu Asal', '2026-09-11 08:00:00', ['asal' => 'Kantor Unik']);
        $this->makeTamu('Tamu Tujuan', '2026-09-12 08:00:00', ['tujuan' => 'Agenda Rahasia']);
        $this->makeTamu('Tamu Telepon', '2026-09-13 08:00:00', ['nohp' => '089999887777']);

        foreach (['Khusus', 'Kantor Unik', 'Agenda Rahasia'] as $search) {
            $this->dataResponse($admin, ['search' => ['value' => $search, 'regex' => 'false']])
                ->assertJsonPath('recordsFiltered', 1);
        }

        $this->dataResponse($admin, ['search' => ['value' => '089999887777', 'regex' => 'false']])
            ->assertJsonPath('recordsFiltered', 0);
    }

    public function test_month_filter_takes_priority_over_date_range(): void
    {
        $admin = User::factory()->create();
        $this->makeTamu('Kunjungan Januari', '2026-01-15 08:00:00');
        $this->makeTamu('Kunjungan Februari', '2026-02-15 08:00:00');

        $response = $this->dataResponse($admin, [
            'bulan' => '2026-01',
            'tanggal_mulai' => '2026-02-01',
            'tanggal_selesai' => '2026-02-28',
        ]);

        $response
            ->assertJsonPath('recordsFiltered', 1)
            ->assertSee('Kunjungan Januari')
            ->assertDontSee('Kunjungan Februari');
    }

    public function test_date_range_filters_server_side_data(): void
    {
        $admin = User::factory()->create();
        $this->makeTamu('Sebelum Rentang', '2026-03-01 08:00:00');
        $this->makeTamu('Dalam Rentang', '2026-03-15 08:00:00');
        $this->makeTamu('Sesudah Rentang', '2026-04-01 08:00:00');

        $response = $this->dataResponse($admin, [
            'tanggal_mulai' => '2026-03-10',
            'tanggal_selesai' => '2026-03-20',
        ]);

        $response
            ->assertJsonPath('recordsFiltered', 1)
            ->assertSee('Dalam Rentang')
            ->assertDontSee('Sebelum Rentang')
            ->assertDontSee('Sesudah Rentang');
    }

    public function test_generated_html_escapes_visitor_data(): void
    {
        $admin = User::factory()->create();
        $this->makeTamu('<script>alert(1)</script>', '2026-09-19 08:00:00');

        $response = $this->dataResponse($admin);

        $this->assertStringNotContainsString('<script>alert(1)</script>', $response->getContent());
        $this->assertStringContainsString('&lt;script&gt;', $response->json('data.0.pengunjung'));
    }

    private function dataResponse(User $admin, array $overrides = []): TestResponse
    {
        return $this->actingAs($admin)->getJson(route('rekap.data', $this->parameters($overrides)));
    }

    private function parameters(array $overrides = []): array
    {
        return array_replace_recursive([
            'draw' => 1,
            'start' => 0,
            'length' => 25,
            'search' => ['value' => '', 'regex' => 'false'],
            'order' => [['column' => 1, 'dir' => 'desc']],
            'columns' => [
                ['data' => 'pengunjung', 'name' => 'nama_tamu', 'searchable' => 'true', 'orderable' => 'true', 'search' => ['value' => '', 'regex' => 'false']],
                ['data' => 'tanggal', 'name' => 'tanggal', 'searchable' => 'true', 'orderable' => 'true', 'search' => ['value' => '', 'regex' => 'false']],
                ['data' => 'asal', 'name' => 'asal', 'searchable' => 'true', 'orderable' => 'true', 'search' => ['value' => '', 'regex' => 'false']],
                ['data' => 'tujuan', 'name' => 'tujuan', 'searchable' => 'true', 'orderable' => 'true', 'search' => ['value' => '', 'regex' => 'false']],
                ['data' => 'aksi', 'name' => 'aksi', 'searchable' => 'false', 'orderable' => 'false', 'search' => ['value' => '', 'regex' => 'false']],
            ],
        ], $overrides);
    }

    private function makeTamu(string $name, string $date, array $overrides = []): Tamu
    {
        $tamu = Tamu::create(array_merge([
            'nama_tamu' => $name,
            'jenis_kelamin' => 'L',
            'nohp' => '081234567890',
            'asal' => 'Instansi Umum',
            'tujuan' => 'Kunjungan Umum',
            'gambar' => 'foto.jpg',
        ], $overrides));

        $tamu->forceFill(['tanggal' => $date])->save();

        return $tamu;
    }
}
