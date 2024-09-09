<?php

// app/Http/Livewire/WebcamCapture.php
namespace App\Http\Livewire;

use Livewire\Component;

class WebcamCapture extends Component
{
    public $image;

    public function render()
    {
        return view('livewire.webcam-capture');
    }

    public function captureImage()
    {
        $imageData = request()->input('imageData');
        $imageName = 'webcam_capture_' . now()->format('Ymd_His') . '.png';

        // Save the captured image to the public directory
        file_put_contents(public_path('uploads/webcam/') . $imageName, base64_decode($imageData));

        $this->image = $imageName;
    }
}
