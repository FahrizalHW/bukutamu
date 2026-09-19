<?php

namespace App\Http\Controllers;

use App\Exports\TamuExport;
use App\Http\Requests\UpdateTamuRequest;
use App\Models\Tamu;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Yajra\DataTables\Facades\DataTables;

class RekapController extends Controller
{
    private const FILTERS = ['search', 'tanggal_mulai', 'tanggal_selesai', 'bulan'];

    public function index(): View
    {
        return view('admin.rekap');
    }

    public function data(Request $request): JsonResponse
    {
        $filters = $this->filters($request);
        $search = $filters['search'] ?? null;
        unset($filters['search']);

        $query = Tamu::query()
            ->select(['id', 'nama_tamu', 'jenis_kelamin', 'gambar', 'tanggal', 'asal', 'tujuan'])
            ->filtered($filters);

        return DataTables::eloquent($query)
            ->filter(function ($query) use ($search) {
                if (! $search) {
                    return;
                }

                $query->where(function ($query) use ($search) {
                    $query->where('nama_tamu', 'like', "%{$search}%")
                        ->orWhere('asal', 'like', "%{$search}%")
                        ->orWhere('tujuan', 'like', "%{$search}%");
                });
            })
            ->addColumn('pengunjung', fn (Tamu $tamu) => view('admin.rekap.partials.visitor', compact('tamu'))->render())
            ->editColumn('tanggal', fn (Tamu $tamu) => view('admin.rekap.partials.date', compact('tamu'))->render())
            ->addColumn('aksi', fn (Tamu $tamu) => view('admin.rekap.partials.actions', compact('tamu'))->render())
            ->rawColumns(['pengunjung', 'tanggal', 'aksi'])
            ->toJson();
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
        $photoPath = $tamu->gambar ? 'visitor-photos/'.$tamu->gambar : null;
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
        $path = 'visitor-photos/'.$tamu->gambar;
        abort_unless(Storage::disk('local')->exists($path), 404);

        return Storage::disk('local')->response($path);
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        $records = Tamu::query()
            ->filtered($this->filters($request))
            ->latest('tanggal')
            ->get();

        return Excel::download(new TamuExport($records), 'rekap-tamu-'.now()->format('Y-m-d').'.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $records = Tamu::query()
            ->filtered($this->filters($request))
            ->latest('tanggal')
            ->get();

        return Pdf::loadView('admin.exports.pdf', compact('records'))
            ->setPaper('a4', 'landscape')
            ->download('rekap-tamu-'.now()->format('Y-m-d').'.pdf');
    }

    private function filters(Request $request): array
    {
        $search = $request->input('search');
        if (is_array($search)) {
            $search = $search['value'] ?? null;
        }

        $filters = $request->only(self::FILTERS);
        $filters['search'] = is_string($search) ? trim($search) : null;

        if (! empty($filters['bulan'])) {
            $filters['tanggal_mulai'] = null;
            $filters['tanggal_selesai'] = null;
        }

        return $filters;
    }
}
