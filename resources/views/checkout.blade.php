<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Selesaikan pemesanan roti premium BreadRush Anda.">
    <title>Checkout - BreadRush</title>
    <link rel="stylesheet" href="{{ asset('stylecheckout.css') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
</head>
<body>

<!-- ====== NAVBAR ====== -->
<div class="navbar">
    <b>BreadRush</b>

    <div class="nav-links">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('menu') }}">Menu</a>
        <a href="{{ route('checkout') }}" class="active">Checkout</a>
        <a href="{{ route('tracking') }}">Riwayat</a>
    </div>

    <div class="nav-right">
        <button class="nav-cart-btn" aria-label="Keranjang Belanja" style="cursor: default; position: relative;">
            🛒
            <span class="cart-badge" id="cartBadge">0</span>
        </button>
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

<!-- ====== PAGE HEADER ====== -->
<div class="page-header">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a> / <a href="{{ route('menu') }}">Menu</a> / <span>Checkout</span>
    </div>
    <h1>Checkout <span>BreadRush</span></h1>
    <p class="subtitle">Selesaikan pesanan roti premium Anda di bawah ini.</p>
</div>

<!-- ====== CHECKOUT CONTENT ====== -->
<div class="checkout-wrapper">
    
    <!-- Left Column: Cart Items -->
    <div class="cart-section">
        <div class="section-label">
            Keranjang Anda
            <span class="item-count-badge" id="itemCount">0 Item</span>
        </div>

        <div id="checkoutItemsList">
            <!-- Rendered by JS -->
        </div>

        <!-- Add Menu Button -->
        <button class="add-menu-btn" id="addMenuBtn" onclick="window.location.href='{{ route('menu') }}'">
            <span class="plus-icon">+</span> Tambah Menu Lainnya
        </button>
    </div>

    <!-- Right Column: Order Summary -->
    <div class="summary-section">
        <div class="summary-card">
            <div class="summary-header">
                <span>📋</span> Ringkasan Pembayaran
            </div>
            
            <div class="summary-body">
                <!-- Promo Code -->
                <div class="promo-input-group">
                    <input type="text" class="promo-input" id="promoInput" placeholder="Masukkan kode promo (e.g. BREAD10)">
                    <button class="promo-apply-btn" onclick="applyPromo()">Pakai</button>
                </div>
                <div id="promoFeedback" style="font-size: 13px; margin-top: -8px; display: none;"></div>

                <div class="summary-divider"></div>

                <div class="summary-row">
                    <span class="label">Subtotal (Original)</span>
                    <span class="value" id="summarySubtotal">Rp 0</span>
                </div>

                <div class="summary-row savings" id="savingsRow" style="display: none;">
                    <span class="label">Diskon Spesial 35%</span>
                    <span class="value" id="summarySaved">- Rp 0</span>
                </div>

                <div class="summary-row savings" id="promoPromoRow" style="display: none; color: var(--success-green);">
                    <span class="label">Kupon Promo</span>
                    <span class="value" id="summaryPromo">- Rp 0</span>
                </div>

                <div class="summary-row shipping">
                    <span class="label">Ongkir</span>
                    <span class="value" id="summaryShipping">Rp 0</span>
                </div>

                <div class="summary-total">
                    <span class="label">Total</span>
                    <span class="value" id="summaryTotal">Rp 0</span>
                </div>

                <button class="checkout-cta" id="checkoutSubmit" onclick="proceedToPayment()">
                    Lanjutkan Pembayaran →
                </button>

                <div class="secure-badge">
                    <span>🔒</span> Pembayaran 100% Aman & Terenkripsi
                </div>
            </div>
        </div>
    </div>

</div>

<!-- ====== TOAST ====== -->
<div class="toast" id="toast">
    <span id="toastIcon">✅</span>
    <span id="toastMsg">Keranjang diperbarui!</span>
</div>

<script>
/* =======================
   DATA PRODUK UNTUK LOOKUP
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

// State Promo Code
let appliedPromoCode = null;
let promoDiscountPercentage = 0;

/* =======================
   LOAD CART
======================= */
let cart = JSON.parse(localStorage.getItem('breadrushCart')) || [];

function formatRupiah(angka) {
    return 'Rp ' + angka.toLocaleString('id-ID');
}

/* =======================
   RENDER CHECKOUT
======================= */
function renderCheckout() {
    const listContainer = document.getElementById('checkoutItemsList');
    const itemCountBadge = document.getElementById('itemCount');
    const cartBadge = document.getElementById('cartBadge');
    const addMenuBtn = document.getElementById('addMenuBtn');
    
    // Update badge navbar
    const totalItems = cart.reduce((sum, c) => sum + c.qty, 0);
    cartBadge.textContent = totalItems;
    itemCountBadge.textContent = totalItems + ' Item';

    if (cart.length === 0) {
        // Render Empty State
        listContainer.innerHTML = `
            <div class="cart-empty-state">
                <div class="empty-icon">🍞</div>
                <h3>Keranjang Belanja Anda Kosong</h3>
                <p>Silakan pilih menu roti lezat kami terlebih dahulu.</p>
                <button class="shop-now-btn" onclick="window.location.href='{{ route('menu') }}'">
                    Belanja Sekarang →
                </button>
            </div>
        `;
        addMenuBtn.style.display = 'none';
        
        // Reset values
        document.getElementById('summarySubtotal').textContent = formatRupiah(0);
        document.getElementById('savingsRow').style.display = 'none';
        document.getElementById('promoPromoRow').style.display = 'none';
        document.getElementById('summaryShipping').textContent = formatRupiah(0);
        document.getElementById('summaryTotal').textContent = formatRupiah(0);
        document.getElementById('checkoutSubmit').disabled = true;
        return;
    }

    addMenuBtn.style.display = 'flex';
    document.getElementById('checkoutSubmit').disabled = false;

    let html = '';
    let originalSubtotal = 0;
    let promoSavings = 0;

    cart.forEach(item => {
        // Look up detailed info
        const originalItem = produkList.find(p => p.id === item.id) || {};
        const deskripsi = originalItem.deskripsi || 'Roti premium segar dari oven.';
        const kategori = originalItem.kategori || 'Roti';
        const hargaAsli = item.hargaAsli || item.harga;
        
        originalSubtotal += hargaAsli * item.qty;
        promoSavings += (hargaAsli - item.harga) * item.qty;

        html += `
            <div class="checkout-item">
                <img class="checkout-item-img" src="${item.gambar}" alt="${item.nama}">
                <div class="checkout-item-details">
                    <span class="checkout-item-category">${kategori.replace('-', ' ')}</span>
                    <h3 class="checkout-item-name">${item.nama}</h3>
                    <p class="checkout-item-desc">${deskripsi}</p>
                    <div class="checkout-price-row">
                        ${isPromo ? `<span class="checkout-price-original">${formatRupiah(hargaAsli)}</span>` : ''}
                        <span class="checkout-price-final">${formatRupiah(item.harga)}</span>
                        ${isPromo ? `<span class="checkout-discount-tag">-${diskonPersen}%</span>` : ''}
                    </div>
                    <div class="checkout-qty">
                        <button class="checkout-qty-btn" onclick="updateQty(${item.id}, -1)">−</button>
                        <span class="checkout-qty-num">${item.qty}</span>
                        <button class="checkout-qty-btn" onclick="updateQty(${item.id}, 1)">+</button>
                    </div>
                </div>
                <div class="checkout-item-actions">
                    <button class="remove-btn" onclick="removeItem(${item.id})" aria-label="Hapus">🗑️</button>
                    <span class="item-subtotal">${formatRupiah(item.harga * item.qty)}</span>
                </div>
            </div>
        `;
    });

    listContainer.innerHTML = html;

    // Calculate details
    const currentDiscountedSubtotal = originalSubtotal - promoSavings;
    const shippingFee = 10000;
    
    // Additional promo discount from coupon
    let couponDiscount = 0;
    if (appliedPromoCode) {
        couponDiscount = Math.round(currentDiscountedSubtotal * (promoDiscountPercentage / 100));
    }

    const finalTotal = currentDiscountedSubtotal - couponDiscount + shippingFee;

    // Render summary values
    document.getElementById('summarySubtotal').textContent = formatRupiah(originalSubtotal);
    
    if (promoSavings > 0) {
        document.getElementById('savingsRow').style.display = 'flex';
        document.getElementById('summarySaved').textContent = '- ' + formatRupiah(promoSavings);
    } else {
        document.getElementById('savingsRow').style.display = 'none';
    }

    if (couponDiscount > 0) {
        document.getElementById('promoPromoRow').style.display = 'flex';
        document.getElementById('summaryPromo').textContent = '- ' + formatRupiah(couponDiscount);
    } else {
        document.getElementById('promoPromoRow').style.display = 'none';
    }

    document.getElementById('summaryShipping').textContent = formatRupiah(shippingFee);
    document.getElementById('summaryTotal').textContent = formatRupiah(finalTotal);
}

/* =======================
   CART ACTIONS
======================= */
function updateQty(id, delta) {
    const item = cart.find(c => c.id === id);
    if (!item) return;

    item.qty += delta;
    if (item.qty <= 0) {
        removeItem(id);
        return;
    }

    saveCart();
    renderCheckout();
    showToast('✅', 'Jumlah item diperbarui!');
}

function removeItem(id) {
    const item = cart.find(c => c.id === id);
    const name = item ? item.nama : 'Item';
    
    cart = cart.filter(c => c.id !== id);
    saveCart();
    renderCheckout();
    showToast('🗑️', name + ' dihapus dari keranjang.');
}

function saveCart() {
    localStorage.setItem('breadrushCart', JSON.stringify(cart));
}

/* =======================
   PROMO CODE CODE
======================= */
function applyPromo() {
    const input = document.getElementById('promoInput').value.trim().toUpperCase();
    const feedback = document.getElementById('promoFeedback');
    
    if (cart.length === 0) {
        showToast('❌', 'Keranjang Anda kosong.');
        return;
    }

    if (input === 'BREAD10') {
        appliedPromoCode = 'BREAD10';
        promoDiscountPercentage = 10;
        feedback.style.display = 'block';
        feedback.style.color = 'var(--success-green)';
        feedback.textContent = 'Kode BREAD10 berhasil dipakai! Diskon tambahan 10%.';
        showToast('🎉', 'Diskon 10% berhasil diterapkan!');
    } else if (input === 'FREESHIP') {
        appliedPromoCode = 'FREESHIP';
        feedback.style.display = 'block';
        feedback.style.color = 'var(--success-green)';
        feedback.textContent = 'Kode FREESHIP berhasil! Ongkos kirim gratis.';
        showToast('🚚', 'Gratis ongkir berhasil diterapkan!');
    } else if (input === '') {
        feedback.style.display = 'none';
        appliedPromoCode = null;
        promoDiscountPercentage = 0;
    } else {
        feedback.style.display = 'block';
        feedback.style.color = 'var(--promo-red)';
        feedback.textContent = 'Kode promo tidak valid.';
        appliedPromoCode = null;
        promoDiscountPercentage = 0;
        showToast('❌', 'Kode promo tidak valid!');
    }

    // Custom recalculation for FREESHIP in rendering
    if (appliedPromoCode === 'FREESHIP') {
        // Redefine render total with 0 shipping
        const listContainer = document.getElementById('checkoutItemsList');
        let originalSubtotal = 0;
        let promoSavings = 0;
        cart.forEach(item => {
            const hargaAsli = item.hargaAsli || item.harga;
            originalSubtotal += hargaAsli * item.qty;
            promoSavings += (hargaAsli - item.harga) * item.qty;
        });
        const currentDiscountedSubtotal = originalSubtotal - promoSavings;
        const shippingFee = 0; // free!
        const finalTotal = currentDiscountedSubtotal + shippingFee;

        document.getElementById('summarySubtotal').textContent = formatRupiah(originalSubtotal);
        document.getElementById('savingsRow').style.display = 'flex';
        document.getElementById('summarySaved').textContent = '- ' + formatRupiah(promoSavings);
        document.getElementById('promoPromoRow').style.display = 'flex';
        document.getElementById('summaryPromo').textContent = '- Rp 10.000 (Free Shipping)';
        document.getElementById('summaryShipping').textContent = formatRupiah(shippingFee);
        document.getElementById('summaryTotal').textContent = formatRupiah(finalTotal);
    } else {
        renderCheckout();
    }
}

/* =======================
   PROCEED TO PAYMENT
======================= */
function proceedToPayment() {
    if (cart.length === 0) return;
    
    // Redirect to the payment route
    window.location.href = "{{ route('payment') }}";
}

/* =======================
   TOAST
======================= */
function showToast(icon, msg) {
    const toast = document.getElementById('toast');
    document.getElementById('toastIcon').textContent = icon;
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
renderCheckout();
</script>

</body>
</html>
