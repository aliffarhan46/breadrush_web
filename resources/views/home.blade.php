<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - BreadRush</title>
    <link rel="stylesheet" href="{{ asset('stylehome.css') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <style>
        /* Toast notification */
        .toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 14px 22px;
            border-radius: var(--radius-md);
            font-family: var(--font-body);
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 30px var(--shadow-color);
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 9999;
        }
        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        /* Promo countdown styling */
        .promo-countdown {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 14px;
            font-family: var(--font-heading);
        }
        .countdown-box {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(4px);
            border-radius: var(--radius-sm);
            padding: 6px 12px;
            text-align: center;
            min-width: 50px;
        }
        .countdown-num {
            font-size: 22px;
            font-weight: 800;
            line-height: 1;
        }
        .countdown-label {
            font-size: 10px;
            font-weight: 600;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .countdown-sep {
            font-size: 20px;
            font-weight: 800;
            opacity: 0.6;
        }
        .promo-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
            margin-top: 10px;
        }
        .promo-status-badge.active {
            background: rgba(46, 204, 113, 0.2);
            color: #27ae60;
        }
        .promo-status-badge.inactive {
            background: rgba(231, 76, 60, 0.15);
            color: #e74c3c;
        }
        .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            animation: pulseDot 1.5s ease infinite;
        }
        .pulse-dot.green { background: #27ae60; }
        .pulse-dot.red { background: #e74c3c; }
        @keyframes pulseDot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.7); }
        }
    </style>
</head>
<body>

<div class="navbar">
    <b>BreadRush</b>

    <div class="nav-links">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('menu') }}">Menu</a>
        <a href="{{ route('checkout') }}">Checkout</a>
        <a href="{{ route('tracking') }}">Riwayat</a>
    </div>

    <div class="nav-right">
        <div class="search-container">
            <input type="text" id="homeSearchInput" placeholder="Cari roti favoritmu..." onkeydown="handleSearch(event)">
        </div>
        <button class="cart-btn" aria-label="Keranjang Belanja" onclick="window.location.href='{{ route('checkout') }}'">🛒</button>
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
        <a href="{{ route('menu') }}">
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
    <a href="{{ route('menu') }}?category=pastry" class="card" style="text-decoration: none; color: inherit; display: block;">
        <img src="{{ asset('Gambar/a257ac19e1857c615740b6ae7a45d3e18e146278.png') }}" alt="Pastry Signature">
        <div class="card-content">
            <b>Pastry Signature <span>→</span></b>
            <p>Jelajahi Sekarang!</p>
        </div>
    </a>

    <a href="{{ route('menu') }}?category=roti-manis" class="card" style="text-decoration: none; color: inherit; display: block;">
        <img src="{{ asset('Gambar/99bdc6bc3b34c9bfb12e4c8d05fa8f324e443b7a.png') }}" alt="Sweet Selection">
        <div class="card-content">
            <b>Sweet Selection <span>→</span></b>
            <p>Jelajahi Sekarang!</p>
        </div>
    </a>

    <a href="{{ route('menu') }}?category=savory" class="card" style="text-decoration: none; color: inherit; display: block;">
        <img src="{{ asset('Gambar/e43d81df3865f0cdf6f468b46d75315f4353d160.png') }}" alt="Savory Breads">
        <div class="card-content">
            <b>Savory Breads <span>→</span></b>
            <p>Jelajahi Sekarang!</p>
        </div>
    </a>
</div>

<div class="promo">
    <img src="{{ asset('Gambar/af922c14fb4905fafd4892cc9c1f8616622e22b7.jpg') }}" alt="Promo Spesial BreadRush">
    <div class="promo-text">
        <h2>Diskon Spesial 35%</h2>
        <p>
            Dapatkan roti pilihan favorit Anda dengan penawaran harga spesial, 
            eksklusif setiap hari pukul <strong>21.00–22.30 WIB</strong>. Jangan sampai kehabisan!
        </p>
        <div id="promoStatusContainer">
            <!-- Diisi oleh JavaScript berdasarkan waktu -->
        </div>
        <p style="margin-top: 14px;"><a href="{{ route('menu') }}"><u>Lihat Produk Promo</u></a></p>
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
        <p><a href="{{ route('menu') }}">Pusat Bantuan</a></p>
        <p><a href="{{ route('tracking') }}">Cek Pengiriman Order</a></p>
        <p><a href="mailto:breadrush@gmail.com">Hubungi Kami</a></p>
    </div>

    <div>
        <b>Ikuti Kami</b>
        <p>Dapatkan update promo terbaru dari oven kami:</p>
        <div style="margin-top: 10px;">
            <input type="email" id="subscribeEmail" placeholder="Alamat Email Anda" aria-label="Email Newsletter">
            <button type="button" onclick="handleSubscribe()">Subscribe</button>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="toast" id="toast">
    <span id="toastIcon">✅</span>
    <span id="toastMsg">Berhasil!</span>
</div>

<script>
/* =======================
   SEARCH - Navigate to menu
======================= */
function handleSearch(e) {
    if (e.key === 'Enter') {
        const query = document.getElementById('homeSearchInput').value.trim();
        if (query) {
            window.location.href = "{{ route('menu') }}?search=" + encodeURIComponent(query);
        } else {
            window.location.href = "{{ route('menu') }}";
        }
    }
}

/* =======================
   SUBSCRIBE
======================= */
function handleSubscribe() {
    const emailInput = document.getElementById('subscribeEmail');
    const email = emailInput.value.trim();
    
    if (!email) {
        showToast('⚠️', 'Mohon masukkan alamat email Anda.');
        return;
    }
    
    if (!email.includes('@') || !email.includes('.')) {
        showToast('❌', 'Format email tidak valid.');
        return;
    }
    
    showToast('🎉', 'Terima kasih! Anda telah berlangganan newsletter BreadRush.');
    emailInput.value = '';
}

/* =======================
   TOAST
======================= */
function showToast(icon, msg) {
    document.getElementById('toastIcon').textContent = icon;
    document.getElementById('toastMsg').textContent = msg;
    const t = document.getElementById('toast');
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 3000);
}

/* =======================
   PROMO TIME CHECK (21:00 - 22:30 WIB)
======================= */
function checkPromoStatus() {
    const now = new Date();
    
    // Get WIB time (UTC+7)
    const utc = now.getTime() + (now.getTimezoneOffset() * 60000);
    const wib = new Date(utc + (7 * 3600000));
    
    const hours = wib.getHours();
    const minutes = wib.getMinutes();
    const currentMinutes = hours * 60 + minutes;
    
    const promoStart = 21 * 60;      // 21:00
    const promoEnd = 22 * 60 + 30;   // 22:30
    
    const container = document.getElementById('promoStatusContainer');
    
    if (currentMinutes >= promoStart && currentMinutes < promoEnd) {
        // PROMO SEDANG AKTIF - hitung sisa waktu
        const remainingMinutes = promoEnd - currentMinutes;
        const rHours = Math.floor(remainingMinutes / 60);
        const rMins = remainingMinutes % 60;
        
        container.innerHTML = `
            <div class="promo-status-badge active">
                <span class="pulse-dot green"></span>
                PROMO SEDANG BERLANGSUNG!
            </div>
            <div class="promo-countdown">
                <div class="countdown-box">
                    <div class="countdown-num">${String(rHours).padStart(2, '0')}</div>
                    <div class="countdown-label">Jam</div>
                </div>
                <span class="countdown-sep">:</span>
                <div class="countdown-box">
                    <div class="countdown-num">${String(rMins).padStart(2, '0')}</div>
                    <div class="countdown-label">Menit</div>
                </div>
                <span style="font-size:13px; opacity:0.7; margin-left:6px;">tersisa</span>
            </div>
        `;
    } else {
        // PROMO BELUM AKTIF - hitung waktu menuju promo
        let minutesUntilPromo;
        if (currentMinutes < promoStart) {
            minutesUntilPromo = promoStart - currentMinutes;
        } else {
            // Sudah lewat 22:30, hitung menuju 21:00 besok
            minutesUntilPromo = (24 * 60 - currentMinutes) + promoStart;
        }
        const uHours = Math.floor(minutesUntilPromo / 60);
        const uMins = minutesUntilPromo % 60;
        
        container.innerHTML = `
            <div class="promo-status-badge inactive">
                <span class="pulse-dot red"></span>
                PROMO BELUM DIMULAI
            </div>
            <div class="promo-countdown">
                <div class="countdown-box">
                    <div class="countdown-num">${String(uHours).padStart(2, '0')}</div>
                    <div class="countdown-label">Jam</div>
                </div>
                <span class="countdown-sep">:</span>
                <div class="countdown-box">
                    <div class="countdown-num">${String(uMins).padStart(2, '0')}</div>
                    <div class="countdown-label">Menit</div>
                </div>
                <span style="font-size:13px; opacity:0.7; margin-left:6px;">menuju promo</span>
            </div>
        `;
    }
}

// Run promo check on load and every 60 seconds
checkPromoStatus();
setInterval(checkPromoStatus, 60000);

/* =======================
   DARK MODE
======================= */
const toggle = document.getElementById("darkToggle");

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

