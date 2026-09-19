<?php

namespace App\Http\Controllers;

use App\Exports\TamuExport;
use App\Http\Requests\UpdateTamuRequest;
use App\Models\Tamu;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RekapController extends Controller
{
    private const FILTERS = ['search', 'tanggal_mulai', 'tanggal_selesai', 'bulan', 'jenis_kelamin'];

    public function index(Request $request): View
    {
        $filters = $request->only(self::FILTERS);
        $perPage = in_array((int) $request->query('per_page'), [25, 50, 100], true)
            ? (int) $request->query('per_page')
            : 25;

        $visitor = Tamu::query()
            ->filtered($filters)
            ->latest('tanggal')
            ->paginate($perPage)
            ->withQueryString();

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

        return view('admin.index', [
            'visitor' => $visitor,
            'filters' => $filters,
            'perPage' => $perPage,
            'todayCount' => Tamu::whereDate('tanggal', today())->count(),
            'monthCount' => Tamu::whereYear('tanggal', now()->year)
                ->whereMonth('tanggal', now()->month)
                ->count(),
            'totalCount' => Tamu::count(),
            'trend' => $trend,
        ]);
    }

    public function show(Tamu $tamu): View
    {
        return view('admin.show', compact('tamu'));
    }

    public function edit(Tamu $tamu): View
    {
        return view('admin.edit', compact('tamu'));
    }

    public function update(UpdateTamuRequest $request, Tamu $tamu): RedirectResponse
    {
        $tamu->update($request->validated());

        return redirect()->route('rekap.show', $tamu)->with('success', 'Data tamu berhasil diperbarui.');
    }

    public function destroy(Tamu $tamu): RedirectResponse
    {
        $photoPath = $tamu->gambar ? 'visitor-photos/' . $tamu->gambar : null;
        $tamu->delete();

        if ($photoPath && Storage::disk('local')->exists($photoPath)
            && ! Storage::disk('local')->delete($photoPath)) {
            Log::warning('Foto tamu gagal dihapus.', ['path' => $photoPath]);
        }

        return redirect()->route('rekap.index')->with('success', 'Data tamu berhasil dihapus.');
    }

    public function photo(Tamu $tamu): StreamedResponse
    {
        abort_unless($tamu->gambar, 404);
        $path = 'visitor-photos/' . $tamu->gambar;
        abort_unless(Storage::disk('local')->exists($path), 404);

        return Storage::disk('local')->response($path);
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        $records = Tamu::query()
            ->filtered($request->only(self::FILTERS))
            ->latest('tanggal')
            ->get();

        return Excel::download(new TamuExport($records), 'rekap-tamu-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $records = Tamu::query()
            ->filtered($request->only(self::FILTERS))
            ->latest('tanggal')
            ->get();

        return Pdf::loadView('admin.exports.pdf', compact('records'))
            ->setPaper('a4', 'landscape')
            ->download('rekap-tamu-' . now()->format('Y-m-d') . '.pdf');
    }
}
