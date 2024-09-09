@extends ('master-form.master')

@section('content')
    <header>
        <a href="" class="brand">Buku Tamu</a>
        <div class="menu-btn">
        <div class="navigation">
            <div class="navigation-item">
                @auth
                <a href="/Admin">Admin</a>
                @else
                <a href="/login">Login</a>
                @endauth
                
                <a href="/form-tamu">Form</a>
            </div>
        </div>
        </div>
    </header>
    <section class="home">
        <img src="assetsform/img/empty-classroom-due-coronavirus-pandemic.png" alt="" class="imaged">
        <div class="content active">
            <h1>SMKN 4 <span>TPI</span></h1>
            <p>SMKN 4 Tanjungpinang Timur adalah sekolah menengah kejuruan yang terletak di bagian timur Kota Tanjungpinang, menyediakan berbagai program keahlian untuk persiapan karier siswa</p>
            <a href="/form-tamu">Selanjutnya</a>
        <div class="media-icons">
            <a href="https://www.instagram.com/smkn4tgpinang/"><i class="fab fa-instagram"></i></a>
        </div>
    </section>
    @endsection