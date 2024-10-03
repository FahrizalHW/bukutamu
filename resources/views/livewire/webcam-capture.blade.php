<!-- resources/views/livewire/webcam-capture.blade.php -->

<div>
    <div x-data="{ camera: null }">
        <video x-ref="video" class="w-full h-full" autoplay></video> <!-- CSS akan ditambahkan dari JS -->

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

    // Menambahkan transformasi setelah kamera dimulai
    document.querySelector('video').style.transform = 'scaleX(-1)';

    function take_snapshot() {
    // Take snapshot and get image data
    Webcam.snap(function(data_uri) {
        // Display result in the results div
        document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';

        // Ensure the captured image takes the correct size
        const resultImage = document.querySelector('#results img');
        resultImage.style.width = '100%'; // Full width of the container
        resultImage.style.height = 'auto'; // Maintain aspect ratio
    });
}

</script>
@endpush
