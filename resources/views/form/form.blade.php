@extends ('master-form.master')

@section('content')
<header>
    <a href="" class="brand">Buku Tamu</a>
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

<section class="home">
    <img src="assetsform/img/hand-painted-watercolor-background-with-sky-clouds-shape.png" alt="background image" class="imaged img-fluid">
    <div class="content">
        <div class="guestbook-form">
            <h3>Form Buku Tamu</h3>
            
            <form action="{{route('tamu.store')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}

                <!-- Step 1: Personal Information -->
                <div id="step-1">
                    <h4>Informasi Pribadi</h4>

                    <label for="name">Name:</label>
                    <input type="text" id="name" name="nama_tamu" required>

                    <label for="gender">Gender:</label>
                    <select id="gender" name="jenis_kelamin" required>
                        <option value="" hidden selected>Pilih Jenis Kelamin</option>
                        <option value="male">Laki-Laki</option>
                        <option value="female">Perempuan</option>
                    </select>

                    <label for="phone">No HP:</label>
                    <input type="text" id="phone" name="nohp" required>

                    <label for="institution">Asal Instansi:</label>
                    <input type="text" id="institution" name="asal" required>

                    <button type="button" id="next-step-1">Next</button>
                </div>

                <!-- Step 2: Purpose Information -->
                <div id="step-2" style="display:none;">
                    <h4>Informasi Tujuan</h4>

                    <label for="tujuan">Tujuan:</label>
                    <input type="text" id="tujuan" name="tujuan" required>

                    <label for="purpose">Keterangan:</label>
                    <textarea id="purpose" name="keterangan" rows="4" required></textarea>

                    <button type="button" id="prev-step-2">Previous</button>
                    <button type="button" id="next-step-2">Next</button>
                </div>

                <!-- Step 3: Snapshot and Signature -->
                <div id="step-3" style="display:none;">
                    <h4>Foto dan Tanda Tangan</h4>

                    <label for="webcam">Camera</label>
                    <div id="my_camera"></div>
                    <br />
                    <input type=button value="Take Snapshot" onClick="take_snapshot()">
                    <input type="hidden" name="gambar" class="image-tag">
                    <div id="results">Gambar akan muncul di sini</div>

                    <label for="signature">Tanda Tangan:</label>
                    <div class="signature-container">
                        <canvas class="signature-canvas" id="signature"></canvas>
                        <button type="button" id="clear-signature">Hapus Tanda Tangan</button>
                    </div>

                    <button type="button" id="prev-step-3">Previous</button>
                    <button type="submit">Done</button>
                </div>

                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
            </form>
        </div>
    </div>
</section>

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
    document.addEventListener('DOMContentLoaded', resizeCanvas);

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

    canvas.addEventListener('touchstart', function(evt) {
        drawing = true;
        var touch = evt.touches[0];
        var pos = getMousePos(canvas, touch);
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
    });

    canvas.addEventListener('touchmove', function(evt) {
        if (drawing) {
            var touch = evt.touches[0];
            var pos = getMousePos(canvas, touch);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
        }
    });

    canvas.addEventListener('touchend', function() {
        drawing = false;
        ctx.closePath();
    });

    document.getElementById('clear-signature').addEventListener('click', function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    });
</script>

@endsection
