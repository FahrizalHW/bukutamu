<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #202b33; }
    h1 { margin: 0 0 4px; font-size: 18px; }
    p { margin: 0 0 16px; color: #64748b; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 7px; border: 1px solid #cbd5e1; text-align: left; vertical-align: top; }
    th { background: #e8f3ee; }
  </style>
</head>
<body>
  <h1>Rekap Buku Tamu</h1>
  <p>SMKN 4 Tanjungpinang - Dicetak {{ now()->format('d-m-Y H:i') }}</p>
  <table>
    <thead>
      <tr>
        <th>Waktu</th><th>Nama</th><th>Jenis Kelamin</th><th>Nomor HP</th>
        <th>Asal</th><th>Tujuan</th><th>Keterangan</th><th>Sumber</th>
      </tr>
    </thead>
    <tbody>
      @forelse($records as $record)
        <tr>
          <td>{{ $record->tanggal->format('d-m-Y H:i') }}</td>
          <td>{{ $record->nama_tamu }}</td>
          <td>{{ $record->jenis_kelamin === 'L' ? 'Laki-laki' : ($record->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}</td>
          <td>{{ $record->nohp }}</td>
          <td>{{ $record->asal }}</td>
          <td>{{ $record->tujuan }}</td>
          <td>{{ $record->keterangan ?: '-' }}</td>
          <td>{{ $record->sumber === 'qr' ? 'QR Mandiri' : 'Kiosk' }}</td>
        </tr>
      @empty
        <tr><td colspan="8">Tidak ada data sesuai filter.</td></tr>
      @endforelse
    </tbody>
  </table>
</body>
</html>
