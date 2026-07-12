<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pilih menu roti premium BreadRush dengan diskon spesial 35%. Cinnamon Roll, Roti Strawberry Cream, dan lainnya.">
    <title>Menu - BreadRush</title>
    <link rel="stylesheet" href="{{ asset('css/stylemenu.css') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
</head>
<body>

<div class="navbar">
    <b>BreadRush</b>

    <div class="nav-links">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('menu') }}" class="active">Menu</a>
        <a href="{{ route('checkout') }}">Checkout</a>
        <a href="{{ route('tracking') }}">Riwayat</a>
    </div>

    <div class="nav-right">
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Cari roti favoritmu..." oninput="filterProducts()">
        </div>
        <button class="nav-cart-btn" aria-label="Keranjang Belanja" onclick="toggleCart()">
            🛒
            <span class="cart-badge" id="cartBadge">0</span>
        </button>
        <button id="darkToggle" aria-label="Toggle Tema">🌙</button>

        <div class="user-profile">
            <a href="{{ route('profile') }}" class="user-profile-link" style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: inherit;">
                <div class="user-avatar" style="width: 32px; height: 32px; border-radius: 50%; overflow: hidden; background: #8b5e3c; color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; border: 2px solid rgba(139,94,60,0.2);">
                    @if (Auth::user()->foto_profile)
                        <img src="{{ str_starts_with(Auth::user()->foto_profile, 'http') ? Auth::user()->foto_profile : asset(Auth::user()->foto_profile) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                    @endif
                </div>
                <span class="user-name">Halo, {{ Auth::user()->nama }}!</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <button type="button" class="logout-btn" onclick="document.getElementById('logout-form').submit();" style="margin-left: 8px;">
                Keluar
            </button>
        </div>
    </div>
</div>

<!-- ====== MENU HERO ====== -->
<div class="menu-hero">
    <h1>Menu <span>BreadRush</span></h1>
    <p class="subtitle">
        Temukan pilihan roti premium yang fresh dari oven setiap hari. 
        Dibuat dengan bahan terbaik untuk cita rasa yang tak terlupakan.
    </p>
    <div class="promo-banner" id="promoBanner" style="display: none;">
        <span class="fire-icon">🔥</span>
        <span id="promoBannerText">Diskon 35% untuk semua menu!</span>
        <span class="fire-icon">🔥</span>
    </div>
    <div id="promoOffBanner" class="promo-banner" style="display: none; background: linear-gradient(135deg, #7f8c8d, #95a5a6); animation: none;">
        ⏰ Diskon 35% tersedia setiap hari pukul 21.00–22.30 WIB
    </div>
</div>

<!-- ====== FILTER TABS ====== -->
<div class="filter-section">
    <div class="filter-tabs">
        <button class="filter-tab active" onclick="setFilter('all', this)">Semua</button>
        <button class="filter-tab" onclick="setFilter('pastry', this)">Pastry</button>
        <button class="filter-tab" onclick="setFilter('roti-manis', this)">Roti Manis</button>
        <button class="filter-tab" onclick="setFilter('savory', this)">Savory</button>
    </div>
    <select class="sort-dropdown" id="sortSelect" onchange="sortProducts()">
        <option value="default">Urutkan</option>
        <option value="price-low">Harga: Rendah ke Tinggi</option>
        <option value="price-high">Harga: Tinggi ke Rendah</option>
        <option value="name-az">Nama: A - Z</option>
    </select>
</div>

<!-- ====== MENU GRID ====== -->
<div class="menu-grid" id="menuGrid">
    <!-- Products will be rendered by JavaScript -->
</div>

<!-- ====== CART OVERLAY ====== -->
<div class="cart-overlay" id="cartOverlay" onclick="toggleCart()"></div>

<!-- ====== CART SIDEBAR ====== -->
<div class="cart-sidebar" id="cartSidebar">
    <div class="cart-header">
        <h2>🛒 Keranjang</h2>
        <button class="cart-close-btn" onclick="toggleCart()">✕</button>
    </div>

    <div class="cart-items" id="cartItems">
        <div class="cart-empty" id="cartEmpty">
            <div class="empty-icon">🍞</div>
            <p>Keranjang masih kosong</p>
        </div>
    </div>

    <div class="cart-footer" id="cartFooter" style="display:none;">
        <div class="cart-summary-row">
            <span>Subtotal</span>
            <span id="cartSubtotal">Rp 0</span>
        </div>
        <div class="cart-summary-row">
            <span>Hemat</span>
            <span id="cartSaved" style="color: var(--success-green);">- Rp 0</span>
        </div>
        <div class="cart-total-row">
            <span>Total</span>
            <span id="cartTotal">Rp 0</span>
        </div>
        <a href="{{ route('checkout') }}">
            <button class="checkout-btn">
                Checkout Sekarang →
            </button>
        </a>
    </div>
</div>

<!-- ====== TOAST ====== -->
<div class="toast" id="toast">
    <span class="toast-icon">✅</span>
    <span id="toastMsg">Produk ditambahkan!</span>
</div>


<script>
/* =======================
   DATA PRODUK
======================= */
const produkList = [
    {
        id: 1,
        nama: "Cinnamon Roll",
        kategori: "pastry",
        deskripsi: "Gulungan kayu manis lembut dengan taburan icing cream yang manis dan gurih.",
        hargaAsli: 35000,
        gambar: "{{ asset('Gambar/Menu/cinnamon.png') }}"
    },
    {
        id: 2,
        nama: "Roti Strawberry Cream",
        kategori: "roti-manis",
        deskripsi: "Roti manis dengan isian cream strawberry segar dan topping buah asli.",
        hargaAsli: 40000,
        gambar: "{{ asset('Gambar/Menu/roti_strawberry_cream.png') }}"
    },
    {
        id: 3,
        nama: "Roti Susu Butter",
        kategori: "roti-manis",
        deskripsi: "Roti susu premium dengan olesan butter Prancis. Lembut dan harum.",
        hargaAsli: 38000,
        gambar: "{{ asset('Gambar/Menu/roti_susu_butter.png') }}"
    },
    {
        id: 4,
        nama: "Garlic Cheese Bread",
        kategori: "savory",
        deskripsi: "Roti garlic dengan lelehan keju mozzarella dan herb pilihan chef.",
        hargaAsli: 42000,
        gambar: "{{ asset('Gambar/Menu/garlic_cheese.png') }}"
    },
    {
        id: 5,
        nama: "Korean Cream Cheese",
        kategori: "pastry",
        deskripsi: "Pastry Korea dengan filling cream cheese tebal yang creamy dan addictive.",
        hargaAsli: 45000,
        gambar: "{{ asset('Gambar/Menu/korean_cream.png') }}"
    },
    {
        id: 6,
        nama: "Roti Bakar Keju",
        kategori: "savory",
        deskripsi: "Roti bakar tebal dengan keju leleh dan butter spesial BreadRush.",
        hargaAsli: 36000,
        gambar: "{{ asset('Gambar/Menu/roti_bakar_keju.png') }}"
    }
];

/* =======================
   PROMO CONFIG (Time-based: 21:00-22:30 WIB)
======================= */
const diskonPersen = 35;
const diskon = diskonPersen / 100;

function checkIsPromoTime() {
    const now = new Date();
    const utc = now.getTime() + (now.getTimezoneOffset() * 60000);
    const wib = new Date(utc + (7 * 3600000));
    const hours = wib.getHours();
    const minutes = wib.getMinutes();
    const currentMinutes = hours * 60 + minutes;
    const promoStart = 21 * 60;    // 21:00
    const promoEnd = 22 * 60 + 30; // 22:30
    return currentMinutes >= promoStart && currentMinutes < promoEnd;
}

const isPromo = checkIsPromoTime();

/* =======================
   STATE
======================= */
let cart = JSON.parse(localStorage.getItem('breadrushCart')) || [];
let currentFilter = 'all';
let favorites = JSON.parse(localStorage.getItem('breadrushFavs')) || [];

/* =======================
   FORMAT HARGA
======================= */
function formatRupiah(angka) {
    return 'Rp ' + angka.toLocaleString('id-ID');
}

/* =======================
   RENDER PRODUCTS
======================= */
function renderProducts(produkArr) {
    const grid = document.getElementById('menuGrid');
    grid.innerHTML = '';

    if (produkArr.length === 0) {
        grid.innerHTML = '<div style="grid-column: 1/-1; text-align:center; padding:60px 20px;"><p style="font-size:18px; color:var(--text-secondary);">Tidak ada produk ditemukan 🍞</p></div>';
        return;
    }

    produkArr.forEach((p, index) => {
        const hargaAkhir = isPromo ? Math.round(p.hargaAsli - (p.hargaAsli * diskon)) : p.hargaAsli;
        const isFav = favorites.includes(p.id);
        const cartItem = cart.find(c => c.id === p.id);

        const card = document.createElement('div');
        card.className = 'product-card';
        card.dataset.kategori = p.kategori;
        card.style.animationDelay = (index * 0.08) + 's';
        card.style.animation = 'fadeInUp 0.5s ease forwards';
        card.style.opacity = '0';

        card.innerHTML = `
            <div class="product-img-wrap">
                <img src="${p.gambar}" alt="${p.nama}" loading="lazy">
                ${isPromo ? `<span class="discount-badge">-${diskonPersen}%</span>` : ''}
                <button class="fav-btn ${isFav ? 'liked' : ''}" onclick="toggleFav(${p.id}, this)" aria-label="Favorit">
                    ${isFav ? '❤️' : '🤍'}
                </button>
            </div>
            <div class="product-info">
                <span class="product-category">${p.kategori.replace('-', ' ')}</span>
                <h3 class="product-name">${p.nama}</h3>
                <p class="product-desc">${p.deskripsi}</p>
                <div class="price-row">
                    ${isPromo ? `<span class="price-original">${formatRupiah(p.hargaAsli)}</span>` : ''}
                    <span class="price-final ${!isPromo ? 'price-no-promo' : ''}">${formatRupiah(hargaAkhir)}</span>
                </div>
            </div>
            <div class="card-actions">
                <button class="add-cart-btn" onclick="addToCart(${p.id})" id="addBtn-${p.id}">
                    <span class="cart-icon">🛒</span>
                    Tambah ke Keranjang
                </button>
            </div>
        `;

        grid.appendChild(card);
    });
}

/* Fade-in animation */
const styleSheet = document.createElement('style');
styleSheet.textContent = `
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;
document.head.appendChild(styleSheet);

/* =======================
   FILTER
======================= */
function setFilter(filter, btn) {
    currentFilter = filter;

    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');

    const filtered = filter === 'all'
        ? produkList
        : produkList.filter(p => p.kategori === filter);

    renderProducts(filtered);
}

/* =======================
   SEARCH
======================= */
function filterProducts() {
    const query = document.getElementById('searchInput').value.toLowerCase();
    let filtered = produkList.filter(p =>
        p.nama.toLowerCase().includes(query) ||
        p.deskripsi.toLowerCase().includes(query) ||
        p.kategori.toLowerCase().includes(query)
    );

    if (currentFilter !== 'all') {
        filtered = filtered.filter(p => p.kategori === currentFilter);
    }

    renderProducts(filtered);
}

/* =======================
   SORT
======================= */
function sortProducts() {
    const value = document.getElementById('sortSelect').value;
    let filtered = currentFilter === 'all'
        ? [...produkList]
        : produkList.filter(p => p.kategori === currentFilter);

    const query = document.getElementById('searchInput').value.toLowerCase();
    if (query) {
        filtered = filtered.filter(p =>
            p.nama.toLowerCase().includes(query) ||
            p.deskripsi.toLowerCase().includes(query)
        );
    }

    switch (value) {
        case 'price-low':
            filtered.sort((a, b) => a.hargaAsli - b.hargaAsli);
            break;
        case 'price-high':
            filtered.sort((a, b) => b.hargaAsli - a.hargaAsli);
            break;
        case 'name-az':
            filtered.sort((a, b) => a.nama.localeCompare(b.nama));
            break;
    }

    renderProducts(filtered);
}

/* =======================
   FAVORITES
======================= */
function toggleFav(id, btn) {
    const idx = favorites.indexOf(id);
    if (idx === -1) {
        favorites.push(id);
        btn.classList.add('liked');
        btn.innerHTML = '❤️';
    } else {
        favorites.splice(idx, 1);
        btn.classList.remove('liked');
        btn.innerHTML = '🤍';
    }
    localStorage.setItem('breadrushFavs', JSON.stringify(favorites));
}

/* =======================
   CART FUNCTIONS
======================= */
function addToCart(id) {
    const produk = produkList.find(p => p.id === id);
    if (!produk) return;

    const harga = isPromo ? Math.round(produk.hargaAsli - (produk.hargaAsli * diskon)) : produk.hargaAsli;
    const existing = cart.find(c => c.id === id);

    if (existing) {
        existing.qty += 1;
    } else {
        cart.push({
            id: produk.id,
            nama: produk.nama,
            harga: harga,
            hargaAsli: produk.hargaAsli,
            gambar: produk.gambar,
            qty: 1
        });
    }

    saveCart();
    updateCartUI();
    showToast(produk.nama + ' ditambahkan ke keranjang!');
}

function removeFromCart(id) {
    cart = cart.filter(c => c.id !== id);
    saveCart();
    updateCartUI();
}

function updateQty(id, delta) {
    const item = cart.find(c => c.id === id);
    if (!item) return;

    item.qty += delta;
    if (item.qty <= 0) {
        removeFromCart(id);
        return;
    }

    saveCart();
    updateCartUI();
}

function saveCart() {
    localStorage.setItem('breadrushCart', JSON.stringify(cart));
}

function updateCartUI() {
    const badge = document.getElementById('cartBadge');
    const totalItems = cart.reduce((sum, c) => sum + c.qty, 0);
    badge.textContent = totalItems;
    badge.classList.toggle('visible', totalItems > 0);

    const itemsContainer = document.getElementById('cartItems');
    const emptyState = document.getElementById('cartEmpty');
    const footer = document.getElementById('cartFooter');

    if (cart.length === 0) {
        itemsContainer.innerHTML = '<div class="cart-empty" id="cartEmpty"><div class="empty-icon">🍞</div><p>Keranjang masih kosong</p></div>';
        footer.style.display = 'none';
        return;
    }

    footer.style.display = 'block';
    let html = '';
    let subtotal = 0;
    let totalSaved = 0;

    cart.forEach(item => {
        subtotal += item.harga * item.qty;
        if (isPromo) {
            totalSaved += (item.hargaAsli - item.harga) * item.qty;
        }

        html += `
            <div class="cart-item">
                <img class="cart-item-img" src="${item.gambar}" alt="${item.nama}">
                <div class="cart-item-details">
                    <span class="cart-item-name">${item.nama}</span>
                    <span class="cart-item-price">${formatRupiah(item.harga)}</span>
                    <div class="cart-item-qty">
                        <button class="cart-qty-btn" onclick="updateQty(${item.id}, -1)">−</button>
                        <span class="cart-qty-num">${item.qty}</span>
                        <button class="cart-qty-btn" onclick="updateQty(${item.id}, 1)">+</button>
                    </div>
                </div>
                <button class="cart-item-remove" onclick="removeFromCart(${item.id})" aria-label="Hapus">🗑️</button>
            </div>
        `;
    });

    itemsContainer.innerHTML = html;
    document.getElementById('cartSubtotal').textContent = formatRupiah(subtotal);
    document.getElementById('cartSaved').textContent = '- ' + formatRupiah(totalSaved);
    document.getElementById('cartTotal').textContent = formatRupiah(subtotal);
}

/* =======================
   CART TOGGLE
======================= */
function toggleCart() {
    const sidebar = document.getElementById('cartSidebar');
    const overlay = document.getElementById('cartOverlay');
    const isOpen = sidebar.classList.contains('open');

    sidebar.classList.toggle('open');
    overlay.classList.toggle('open');
    document.body.style.overflow = isOpen ? '' : 'hidden';
}

/* =======================
   TOAST
======================= */
function showToast(msg) {
    const toast = document.getElementById('toast');
    document.getElementById('toastMsg').textContent = msg;
    toast.classList.add('show');

    setTimeout(() => {
        toast.classList.remove('show');
    }, 2500);
}

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

/* =======================
   INIT
======================= */
const urlParams = new URLSearchParams(window.location.search);
const categoryParam = urlParams.get('category');
const searchParam = urlParams.get('search');

// Show/hide promo banner based on time
if (isPromo) {
    document.getElementById('promoBanner').style.display = 'flex';
    document.getElementById('promoOffBanner').style.display = 'none';
} else {
    document.getElementById('promoBanner').style.display = 'none';
    document.getElementById('promoOffBanner').style.display = 'flex';
}

// Handle search from home page
if (searchParam) {
    document.getElementById('searchInput').value = searchParam;
    filterProducts();
} else if (categoryParam) {
    const tabBtn = Array.from(document.querySelectorAll('.filter-tab')).find(btn => {
        return btn.getAttribute('onclick').includes(`'${categoryParam}'`);
    });
    if (tabBtn) {
        setFilter(categoryParam, tabBtn);
    } else {
        renderProducts(produkList);
    }
} else {
    renderProducts(produkList);
}
updateCartUI();
</script>

@include('academic_footer')

@if (session('alert_success'))
    <script>
        alert("{{ session('alert_success') }}");
    </script>
@endif

</body>
</html>
