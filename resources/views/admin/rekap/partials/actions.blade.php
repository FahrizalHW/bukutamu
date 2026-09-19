<div class="d-flex justify-content-end gap-2 action-buttons">
  <a href="{{ route('rekap.show', $tamu) }}" class="btn action-button-primary" title="Lihat detail" aria-label="Lihat detail {{ $tamu->nama_tamu }}">
    <i class="ti ti-eye"></i>
  </a>
  <a href="{{ route('rekap.edit', $tamu) }}" class="btn action-button-primary" title="Edit data" aria-label="Edit data {{ $tamu->nama_tamu }}">
    <i class="ti ti-edit"></i>
  </a>
  <form action="{{ route('rekap.destroy', $tamu) }}" method="POST" class="delete-visit-form" data-name="{{ $tamu->nama_tamu }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn action-button-danger" title="Hapus data" aria-label="Hapus data {{ $tamu->nama_tamu }}">
      <i class="ti ti-trash"></i>
    </button>
  </form>
</div>