<!-- resources/views/livewire/webcam-capture.blade.php -->

<div>
    <div x-data="{ camera: null }">
        <video x-ref="video" class="w-full h-full" autoplay></video>

        <button x-on:click="capture">Capture Image</button>

        <input type="hidden" name="imageData" id="imageData" wire:model="image">

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

    document.addEventListener('DOMContentLoaded', function () {
        Livewire.emit('captureImage', document.getElementById('imageData').value);
    });
</script>
@endpush
