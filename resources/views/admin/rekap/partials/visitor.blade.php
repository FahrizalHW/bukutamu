<div class="d-flex align-items-center gap-3">
  <img src="{{ route('rekap.photo', $tamu) }}" alt="Foto {{ $tamu->nama_tamu }}"
    class="visitor-thumb" loading="lazy">
  <div>
    <strong class="d-block">{{ $tamu->nama_tamu }}</strong>
    <span class="text-muted small">
      {{ $tamu->jenis_kelamin === 'L' ? 'Laki-laki' : ($tamu->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
    </span>
  </div>
</div>