<?php

namespace App\Http\Controllers;

use App\Models\Tamu;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $trendStart = now()->subDays(6)->startOfDay();
        $trendCounts = Tamu::query()
            ->where('tanggal', '>=', $trendStart)
            ->selectRaw('DATE(tanggal) as visit_date, COUNT(*) as total')
            ->groupBy('visit_date')
            ->pluck('total', 'visit_date');

        $trend = collect(range(0, 6))->map(function ($offset) use ($trendStart, $trendCounts) {
            $date = $trendStart->copy()->addDays($offset);

            return [
                'label' => $date->format('d/m'),
                'total' => (int) ($trendCounts[$date->toDateString()] ?? 0),
            ];
        });

        return view('admin.dashboard', [
            'todayCount' => Tamu::whereDate('tanggal', today())->count(),
            'monthCount' => Tamu::whereYear('tanggal', now()->year)
                ->whereMonth('tanggal', now()->month)
                ->count(),
            'totalCount' => Tamu::count(),
            'trend' => $trend,
        ]);
    }
}
