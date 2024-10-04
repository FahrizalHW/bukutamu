@extends ('master-form.master')

@section('content')
<header>
    <a href="{{ route('form.index') }}" class="brand">Buku Tamu</a>
        <div class="menu-btn" onclick="toggleMenu()">
        <div class="navigation">
            <div class="navigation-item">
                @auth
                <a href="/Admin">Admin</a>
                @else
                <a href="/login">Login</a>
                @endauth
                
                <a href="{{ route('tamu.umum') }}">Daftar Tamu</a>
            </div>
        </div>
        </div>
</header>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tamu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="home">
        <img src="assetsform/img/hand-painted-watercolor-background-with-sky-clouds-shape.png" alt="background image" class="imaged img-fluid">
        <div class="content container">
            <div class="guestbook-form">
                <h3>Form Buku Tamu</h3>
                <form action="{{route('tamu.store')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    
                    <!-- Step 1: Personal Information -->
                    <div id="step-1">
                        <h4>Informasi Pribadi</h4>

                        <div class="mb-3">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="nama_tamu" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="gender">Gender:</label>
                            <select id="gender" name="jenis_kelamin" class="form-select" required>
                                <option value="" hidden selected>Pilih Jenis Kelamin</option>
                                <option value="male">Laki-Laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="phone">No HP:</label>
                            <input type="text" id="phone" name="nohp" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="institution">Asal Instansi:</label>
                            <input type="text" id="institution" name="asal" class="form-control" required>
                        </div>

                        <button type="button" id="next-step-1" class="btn btn-primary">Next</button>
                    </div>

                    <!-- Step 2: Purpose Information -->
                    <div id="step-2" style="display:none;">
                        <h4>Informasi Tujuan</h4>

                        <div class="mb-3">
                            <label for="tujuan">Tujuan:</label>
                            <input type="text" id="tujuan" name="tujuan" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="purpose">Keterangan:</label>
                            <textarea id="purpose" name="keterangan" rows="4" class="form-control" required></textarea>
                        </div>

                        <button type="button" id="prev-step-2" class="btn btn-secondary">Previous</button>
                        <button type="button" id="next-step-2" class="btn btn-primary">Next</button>
                    </div>

                    <!-- Step 3: Snapshot and Signature -->
                    <div id="step-3" style="display:none;">
                        <h4>Foto dan Tanda Tangan</h4>

                        <label for="webcam">Camera</label>
                        <div id="my_camera"></div>
                        <br />
                        <input type=button value="Take Snapshot" onClick="take_snapshot()" class="btn btn-warning">
                        <input type="hidden" name="gambar" class="image-tag">
                        <div id="results" class="mt-3">Gambar akan muncul di sini</div>

                        <div class="signature-container">
                            <label for="signature">Tanda Tangan:</label>
                            <canvas class="signature-canvas" id="signature"></canvas>
                            <button type="button" id="clear-signature" class="btn btn-danger mt-3">Hapus Tanda Tangan</button>
                        </div>

                        <button type="button" id="prev-step-3" class="btn btn-secondary">Previous</button>
                        <button type="submit" class="btn btn-success">Done</button>
                    </div>

                    @if(session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </section>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<script>
    // JavaScript to handle step navigation
    document.getElementById('next-step-1').addEventListener('click', function() {
        document.getElementById('step-1').style.display = 'none';
        document.getElementById('step-2').style.display = 'block';
    });

    document.getElementById('prev-step-2').addEventListener('click', function() {
        document.getElementById('step-2').style.display = 'none';
        document.getElementById('step-1').style.display = 'block';
    });

    document.getElementById('next-step-2').addEventListener('click', function() {
        document.getElementById('step-2').style.display = 'none';
        document.getElementById('step-3').style.display = 'block';
    });

    document.getElementById('prev-step-3').addEventListener('click', function() {
        document.getElementById('step-3').style.display = 'none';
        document.getElementById('step-2').style.display = 'block';
    });

    // JavaScript tambahan untuk membuat canvas tanda tangan responsif
    function resizeCanvas() {
        var canvas = document.getElementById('signature');
        var container = document.querySelector('.signature-container');
        canvas.width = container.offsetWidth;
        canvas.height = container.offsetHeight;
    }

    window.addEventListener('resize', resizeCanvas);
    document.addEventListener('DOMContentLoaded', function() {
        // Tambahkan delay untuk memastikan elemen sudah di-render sepenuhnya di mobile
        setTimeout(resizeCanvas, 100);
    });

    // Setup signature drawing functionality
    var canvas = document.getElementById('signature');
    var ctx = canvas.getContext('2d');
    var drawing = false;

    canvas.width = canvas.getBoundingClientRect().width;
    canvas.height = 300;

    function getMousePos(canvas, evt) {
        var rect = canvas.getBoundingClientRect();
        return {
            x: evt.clientX - rect.left,
            y: evt.clientY - rect.top
        };
    }

    function getTouchPos(canvas, touchEvent) {
        var rect = canvas.getBoundingClientRect();
        var touch = touchEvent.touches[0];
        return {
            x: touch.clientX - rect.left,
            y: touch.clientY - rect.top
        };
    }

    // Prevent scrolling when touching the canvas
    canvas.addEventListener('touchstart', function(evt) {
        evt.preventDefault();
        drawing = true;
        var pos = getTouchPos(canvas, evt);
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
    }, false);

    canvas.addEventListener('touchmove', function(evt) {
        evt.preventDefault();
        if (drawing) {
            var pos = getTouchPos(canvas, evt);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
        }
    }, false);

    canvas.addEventListener('touchend', function(evt) {
        evt.preventDefault();
        drawing = false;
        ctx.closePath();
    }, false);

    // Mouse events for desktop
    canvas.addEventListener('mousedown', function(evt) {
        drawing = true;
        var pos = getMousePos(canvas, evt);
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
    });

    canvas.addEventListener('mousemove', function(evt) {
        if (drawing) {
            var pos = getMousePos(canvas, evt);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
        }
    });

    canvas.addEventListener('mouseup', function() {
        drawing = false;
        ctx.closePath();
    });

    canvas.addEventListener('mouseleave', function() {
        drawing = false;
    });

    document.getElementById('clear-signature').addEventListener('click', function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    });

    // Function to toggle the navigation menu
    function toggleMenu() {
        const navigation = document.querySelector('.navigation');
        navigation.classList.toggle('active');
    }
</script>


@endsection
