<?php

namespace Tests\Feature;

use App\Models\Tamu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_dashboard_displays_statistics_and_trend_without_rekap_exports(): void
    {
        Carbon::setTestNow('2026-09-19 10:00:00');
        $admin = User::factory()->create();

        $this->makeTamuAt(now());
        $this->makeTamuAt(now()->subDays(2));
        $this->makeTamuAt(now()->subMonth());

        $response = $this->actingAs($admin)->get(route('dashboard.index'));

        $response
            ->assertOk()
            ->assertViewIs('admin.dashboard')
            ->assertViewHas('todayCount', 1)
            ->assertViewHas('monthCount', 2)
            ->assertViewHas('totalCount', 3)
            ->assertViewHas('trend', fn ($trend) => $trend->count() === 7 && $trend->sum('total') === 2)
            ->assertSee('Dashboard')
            ->assertSee('sidebar-link active" href="' . route('dashboard.index'), false)
            ->assertSee(route('rekap.index'), false)
            ->assertDontSee(route('rekap.export.excel'), false)
            ->assertDontSee(route('rekap.export.pdf'), false);
    }

    public function test_rekap_displays_table_and_exports_without_dashboard_statistics(): void
    {
        $admin = User::factory()->create();
        $this->makeTamuAt(now(), 'Pengunjung Rekap');

        $this->actingAs($admin)
            ->get(route('rekap.index'))
            ->assertOk()
            ->assertViewIs('admin.rekap')
            ->assertSee('Rekap Kunjungan')
            ->assertSee('sidebar-link active" href="' . route('rekap.index'), false)
            ->assertSee('Pengunjung Rekap')
            ->assertSee(route('rekap.export.excel'), false)
            ->assertSee(route('rekap.export.pdf'), false)
            ->assertDontSee('Tren 7 hari')
            ->assertDontSee('Hari ini');
    }

    public function test_admin_navigation_uses_dashboard_and_preserves_legacy_rekap_redirect(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->get(route('home'))
            ->assertOk()
            ->assertSee(route('dashboard.index'), false);

        $this->actingAs($admin)
            ->get(route('tamu.index'))
            ->assertRedirect('/rekap');
    }
    private function makeTamuAt(Carbon $date, string $name = 'Tamu Statistik'): Tamu
    {
        $tamu = Tamu::create([
            'nama_tamu' => $name,
            'jenis_kelamin' => 'L',
            'nohp' => '081234567890',
            'asal' => 'Instansi',
            'tujuan' => 'Kunjungan',
            'gambar' => 'foto.jpg',
        ]);

        $tamu->forceFill(['tanggal' => $date])->save();

        return $tamu;
    }
}
