<div>
    <div x-data="{ camera: null }">
        <video x-ref="video" class="w-full h-full" autoplay></video>

        <button x-on:click="camera = null">Stop Camera</button>
        <button x-on:click="capture">Capture Image</button>

        <input type="file" wire:model="image" x-show="image">

        <div x-show="camera === null">
            <button x-on:click="startCamera">Start Camera</button>
        </div>
    </div>

    @if ($image)
        <img src="{{ asset('uploads/webcam/' . $image) }}" alt="Captured Image">
    @endif
</div>

@push('scripts')
<script>
    window.addEventListener('livewire:load', function () {
        Livewire.on('captureImage', imageData => {
            Livewire.emit('captureImage', imageData);
        });
    });
</script>
@endpush