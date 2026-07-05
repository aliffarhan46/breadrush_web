<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - BreadRush</title>
    <link rel="stylesheet" href="{{ asset('stylehome.css') }}">
</head>
<body>

<div class="navbar">
    <b>BreadRush</b>

    <div class="nav-links">
        <a href="{{ route('home') }}">Home</a>
        <a href="menu inject operator.php">Menu</a>
        <a href="chekout.php">Checkout</a>
        <a href="Tracking.php">Riwayat</a>
    </div>

    <div class="nav-right">
        <div class="search-container">
            <input type="text" placeholder="Cari roti favoritmu...">
        </div>
        <button class="cart-btn" aria-label="Keranjang Belanja">🛒</button>
        <button id="darkToggle" aria-label="Toggle Tema">🌙</button>

        <div class="user-profile">
            <span class="user-name">Halo, {{ Auth::user()->nama }}!</span>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <button type="button" class="logout-btn" onclick="document.getElementById('logout-form').submit();">
                Keluar
            </button>
        </div>
    </div>
</div>

<div class="hero">
    <div class="hero-text">
        <p>BreadRush Bakery</p>
        <h1>
            DI SINILAH RASA,<br>
            TEKSTUR, DAN KEHANGATAN<br>
            ROTI BERSATU.
        </h1>
        <p>
            BreadRush menghadirkan roti berkualitas tinggi yang fresh dari oven setiap hari. 
            Dibuat dengan bahan premium untuk cita rasa terbaik keluarga Anda.
        </p>
        <a href="produk.html">
            <button class="btn">
                Beli Produk
            </button>
        </a>
    </div>
    <img src="{{ asset('Gambar/Image.jpg') }}" alt="BreadRush Hero Bread Bag">
</div>

<h2 class="section-title">
    Kategori Produk
</h2>

<div class="categories">
    <!-- Card 1 -->
    <div class="card">
        <img src="{{ asset('Gambar/a257ac19e1857c615740b6ae7a45d3e18e146278.png') }}" alt="Pastry Signature">
        <div class="card-content">
            <b>Pastry Signature <span>→</span></b>
            <p>Jelajahi Sekarang!</p>
        </div>
    </div>

    <div class="card">
        <img src="{{ asset('Gambar/99bdc6bc3b34c9bfb12e4c8d05fa8f324e443b7a.png') }}" alt="Sweet Selection">
        <div class="card-content">
            <b>Sweet Selection <span>→</span></b>
            <p>Jelajahi Sekarang!</p>
        </div>
    </div>

    <div class="card">
        <img src="{{ asset('Gambar/e43d81df3865f0cdf6f468b46d75315f4353d160.png') }}" alt="Savory Breads">
        <div class="card-content">
            <b>Savory Breads <span>→</span></b>
            <p>Jelajahi Sekarang!</p>
        </div>
    </div>
</div>

<div class="promo">
    <img src="{{ asset('Gambar/af922c14fb4905fafd4892cc9c1f8616622e22b7.jpg') }}" alt="Promo Spesial BreadRush">
    <div class="promo-text">
        <h2>Diskon Spesial</h2>
        <p>
            Dapatkan roti pilihan favorit Anda dengan penawaran harga spesial, 
            eksklusif hanya setiap hari pukul 21.00–22.30 WIB. Jangan sampai kehabisan!
        </p>
        <p><a href="produk.html"><u>Lihat Produk Promo</u></a></p>
    </div>
</div>

<div class="footer">
    <div>
        <h3>BreadRush</h3>
        <p>Tempat cita rasa premium dan kehangatan gaya hidup modern bertemu.</p>
    </div>

    <div>
        <b>KONTAK KAMI</b>
        <p>📞 081574844308</p>
        <p>✉️ breadrush@gmail.com</p>
    </div>

    <div>
        <b>BANTUAN</b>
        <p><a href="#">Pusat Bantuan</a></p>
        <p><a href="#">Cek Pengiriman Order</a></p>
        <p><a href="#">Hubungi Kami</a></p>
    </div>

    <div>
        <b>Ikuti Kami</b>
        <p>Dapatkan update promo terbaru dari oven kami:</p>
        <div style="margin-top: 10px;">
            <input type="email" placeholder="Alamat Email Anda" aria-label="Email Newsletter">
            <button type="button">Subscribe</button>
        </div>
    </div>
</div>

<script>
const toggle = document.getElementById("darkToggle");

// Load preferred theme from localStorage
if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark");
    toggle.innerText = "☀️";
} else {
    document.body.classList.remove("dark");
    toggle.innerText = "🌙";
}

toggle.addEventListener("click", () => {
    document.body.classList.toggle("dark");

    if (document.body.classList.contains("dark")) {
        localStorage.setItem("theme", "dark");
        toggle.innerText = "☀️";
    } else {
        localStorage.setItem("theme", "light");
        toggle.innerText = "🌙";
    }
});
</script>

@if (session('alert_success'))
    <script>
        alert("{{ session('alert_success') }}");
    </script>
@endif

</body>
</html>
