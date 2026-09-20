<?php

namespace App\Exports;

use App\Models\Tamu;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TamuExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping {
  public function __construct(private readonly Collection $records) {
  }

  public function collection(): Collection {
    return $this->records;
  }

  public function headings(): array {
    return ['Waktu', 'Nama', 'Jenis Kelamin', 'Nomor HP', 'Asal', 'Tujuan', 'Keterangan', 'Sumber'];
  }

  public function map($record): array {
    /** @var Tamu $record */
    return [
      $record->tanggal?->format('d-m-Y H:i'),
      $record->nama_tamu,
      match ($record->jenis_kelamin) {
        'L' => 'Laki-laki',
        'P' => 'Perempuan',
        default => '-',
      },
      $record->nohp,
      $record->asal,
      $record->tujuan,
      $record->keterangan,
      $record->sumber === 'qr' ? 'QR Mandiri' : 'Kiosk',
    ];
  }
}
