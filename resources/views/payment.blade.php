<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pilih metode pembayaran dan selesaikan pesanan BreadRush Anda.">
    <title>Metode Pembayaran - BreadRush</title>
    <link rel="stylesheet" href="{{ asset('stylecheckout.css') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <style>
        .payment-container {
            max-width: 1000px;
            margin: 40px auto 80px;
            padding: 0 24px;
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 40px;
            align-items: start;
        }

        .payment-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 30px;
            box-shadow: 0 8px 30px var(--shadow-color);
            transition: background-color var(--transition-smooth), border-color var(--transition-smooth);
        }

        .payment-title {
            font-family: var(--font-heading);
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 25px;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .payment-title::before {
            content: '';
            display: inline-block;
            width: 5px;
            height: 24px;
            background-color: var(--accent-primary);
            border-radius: 4px;
        }

        .payment-methods {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 25px;
        }

        .method-option {
            border: 1.5px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            transition: all var(--transition-fast);
        }

        .method-option:hover {
            border-color: var(--accent-primary);
            background: var(--accent-soft);
        }

        .method-option.selected {
            border-color: var(--accent-primary);
            background: var(--accent-soft);
            box-shadow: 0 0 0 1px var(--accent-primary);
        }

        .method-info {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .method-icon { font-size: 22px; }

        .method-name {
            font-family: var(--font-heading);
            font-weight: 700;
            color: var(--text-primary);
            font-size: 15px;
        }

        .method-desc {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        .method-radio {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all var(--transition-fast);
        }

        .method-option.selected .method-radio {
            border-color: var(--accent-primary);
            background: var(--accent-primary);
        }

        .method-option.selected .method-radio::after {
            content: '';
            width: 8px;
            height: 8px;
            background: #fff;
            border-radius: 50%;
        }

        .payment-form-section {
            margin-top: 20px;
            display: none;
            flex-direction: column;
            gap: 14px;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .form-group { display: flex; flex-direction: column; gap: 6px; }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
        }

        .form-input {
            padding: 11px 15px;
            border: 1.5px solid var(--border-color);
            border-radius: var(--radius-sm);
            font-family: var(--font-body);
            font-size: 14px;
            color: var(--text-primary);
            background: var(--input-bg);
            outline: none;
            transition: border-color var(--transition-fast);
        }

        .form-input:focus { border-color: var(--accent-primary); }

        /* ====== QRIS Panel ====== */
        .qris-panel {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            padding: 20px;
            background: var(--bg-tertiary);
            border: 1.5px dashed var(--accent-primary);
            border-radius: var(--radius-lg);
        }

        .qris-panel img {
            width: 190px;
            height: 190px;
            object-fit: cover;
            border-radius: var(--radius-sm);
            border: 4px solid var(--bg-secondary);
            box-shadow: 0 4px 15px var(--shadow-color);
        }

        .qris-label {
            font-family: var(--font-heading);
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
            text-align: center;
        }

        .qris-amount {
            font-family: var(--font-heading);
            font-size: 24px;
            font-weight: 800;
            color: var(--accent-primary);
        }

        /* ====== QRIS Popup Modal ====== */
        .qris-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.65);
            backdrop-filter: blur(10px);
            z-index: 3000;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .qris-overlay.open {
            display: flex;
            opacity: 1;
        }

        .qris-modal {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-xl);
            padding: 36px 30px 30px;
            width: 100%;
            max-width: 380px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.35);
            transform: scale(0.85) translateY(20px);
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .qris-overlay.open .qris-modal { transform: scale(1) translateY(0); }

        .qris-modal-title {
            font-family: var(--font-heading);
            font-size: 20px;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .qris-modal-sub {
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 20px;
        }

        .qris-modal img {
            width: 220px;
            height: 220px;
            object-fit: cover;
            border-radius: var(--radius-md);
            border: 3px solid var(--border-color);
            box-shadow: 0 6px 20px var(--shadow-color);
            margin-bottom: 16px;
        }

        .qris-modal-total {
            font-family: var(--font-heading);
            font-size: 22px;
            font-weight: 800;
            color: var(--accent-primary);
            margin-bottom: 22px;
        }

        .qris-confirm-btn {
            width: 100%;
            padding: 15px;
            background: var(--accent-primary);
            color: #fff;
            border: none;
            border-radius: var(--radius-md);
            font-family: var(--font-heading);
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all var(--transition-fast);
        }

        .qris-confirm-btn:hover { background: var(--accent-hover); transform: translateY(-2px); }
        .qris-confirm-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

        .qris-cancel-link {
            display: block;
            margin-top: 14px;
            font-size: 13px;
            color: var(--text-muted);
            cursor: pointer;
            transition: color var(--transition-fast);
        }

        .qris-cancel-link:hover { color: var(--text-primary); }

        /* ====== Summary Table ====== */
        .pay-summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        .pay-summary-table th {
            text-align: left;
            padding: 9px 0;
            font-size: 12px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
        }

        .pay-summary-table td {
            padding: 11px 0;
            font-size: 14px;
            border-bottom: 1px dashed var(--border-color);
        }

        .pay-summary-table tr:last-child td { border-bottom: none; }

        .pay-summary-item-name { font-weight: 600; color: var(--text-primary); }

        .pay-summary-item-qty { color: var(--text-secondary); font-size: 12px; }

        @media (max-width: 850px) {
            .payment-container { grid-template-columns: 1fr; }
        }

        /* Loading spinner */
        .btn-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255,255,255,0.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            vertical-align: middle;
            margin-right: 8px;
        }

        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body>

<!-- ====== NAVBAR ====== -->
<div class="navbar">
    <b>BreadRush</b>

    <div class="nav-links">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('menu') }}">Menu</a>
        <a href="{{ route('checkout') }}">Checkout</a>
        <a href="{{ route('tracking') }}">Riwayat</a>
    </div>

    <div class="nav-right">
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
        <a href="{{ route('home') }}">Home</a> / <a href="{{ route('checkout') }}">Checkout</a> / <span>Pembayaran</span>
    </div>
    <h1>Pilih Metode <span>Pembayaran</span></h1>
    <p class="subtitle">Selesaikan pesanan roti premium Anda dengan aman dan mudah.</p>
</div>

<!-- ====== PAYMENT CONTENT ====== -->
<div class="payment-container">

    <!-- Left Column: Payment Methods -->
    <div class="payment-card">
        <div class="payment-title">Metode Pembayaran</div>

        <div class="payment-methods">

            <!-- QRIS (Default selected) -->
            <div class="method-option selected" id="method-qris" onclick="selectMethod('qris', this)">
                <div class="method-info">
                    <span class="method-icon">📲</span>
                    <div>
                        <div class="method-name">QRIS</div>
                        <div class="method-desc">Scan kode QR — Bayar via GoPay, OVO, DANA, ShopeePay, dll.</div>
                    </div>
                </div>
                <div class="method-radio"></div>
            </div>

            <!-- BCA VA -->
            <div class="method-option" id="method-bca-va" onclick="selectMethod('bca-va', this)">
                <div class="method-info">
                    <span class="method-icon">🏦</span>
                    <div>
                        <div class="method-name">BCA Virtual Account</div>
                        <div class="method-desc">Transfer bank otomatis tanpa verifikasi manual</div>
                    </div>
                </div>
                <div class="method-radio"></div>
            </div>

            <!-- Mandiri VA -->
            <div class="method-option" id="method-mandiri-va" onclick="selectMethod('mandiri-va', this)">
                <div class="method-info">
                    <span class="method-icon">🏛️</span>
                    <div>
                        <div class="method-name">Mandiri Virtual Account</div>
                        <div class="method-desc">Transfer via Mandiri Online / ATM</div>
                    </div>
                </div>
                <div class="method-radio"></div>
            </div>

            <!-- E-Wallet -->
            <div class="method-option" id="method-ewallet" onclick="selectMethod('ewallet', this)">
                <div class="method-info">
                    <span class="method-icon">📱</span>
                    <div>
                        <div class="method-name">GoPay / OVO / DANA</div>
                        <div class="method-desc">Bayar instan via aplikasi dompet digital</div>
                    </div>
                </div>
                <div class="method-radio"></div>
            </div>

            <!-- Credit Card -->
            <div class="method-option" id="method-cc" onclick="selectMethod('cc', this)">
                <div class="method-info">
                    <span class="method-icon">💳</span>
                    <div>
                        <div class="method-name">Kartu Kredit / Debit</div>
                        <div class="method-desc">Visa, MasterCard, JCB, Amex</div>
                    </div>
                </div>
                <div class="method-radio"></div>
            </div>
        </div>

        <!-- QRIS Preview (default) -->
        <div id="form-qris" class="payment-form-section" style="display: flex;">
            <div class="qris-panel">
                <img src="{{ asset('Gambar/qris.png') }}" alt="QRIS BreadRush" id="qrisPreviewImg">
                <div class="qris-label">Scan menggunakan aplikasi pembayaran Anda</div>
                <div class="qris-amount" id="qrisPreviewAmount">Rp 0</div>
                <p style="font-size: 12px; color: var(--text-muted); text-align: center; margin: 0;">
                    Berlaku 15 menit · Pembayaran real-time
                </p>
            </div>
        </div>

        <!-- Virtual Account Form -->
        <div id="form-va" class="payment-form-section">
            <div class="form-group">
                <label class="form-label">Nomor Virtual Account</label>
                <input type="text" class="form-input" id="vaNumber" value="8001202607060001" readonly
                       style="font-weight: 700; letter-spacing: 1.5px; font-family: monospace;">
            </div>
            <p style="font-size: 12px; color: var(--text-muted); margin: 0;">
                *Salin nomor VA dan bayar via mobile banking / ATM. Pembayaran otomatis terdeteksi dalam 1–2 menit.
            </p>
        </div>

        <!-- E-Wallet Form -->
        <div id="form-ewallet" class="payment-form-section">
            <div class="form-group">
                <label class="form-label">Nomor Handphone Terdaftar</label>
                <input type="text" class="form-input" placeholder="081234567890">
            </div>
            <p style="font-size: 12px; color: var(--text-muted); margin: 0;">
                Notifikasi bayar akan dikirim ke aplikasi dompet digital Anda.
            </p>
        </div>

        <!-- Credit Card Form -->
        <div id="form-cc" class="payment-form-section">
            <div class="form-group">
                <label class="form-label">Nama Pemegang Kartu</label>
                <input type="text" class="form-input" placeholder="NAMA SESUAI KARTU">
            </div>
            <div class="form-group">
                <label class="form-label">Nomor Kartu</label>
                <input type="text" class="form-input" placeholder="4111 2222 3333 4444">
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div class="form-group">
                    <label class="form-label">Masa Berlaku</label>
                    <input type="text" class="form-input" placeholder="MM / YY">
                </div>
                <div class="form-group">
                    <label class="form-label">CVV</label>
                    <input type="password" class="form-input" placeholder="•••">
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Order Summary -->
    <div class="summary-section">
        <div class="summary-card">
            <div class="summary-header">
                <span>🛒</span> Detail Tagihan
            </div>

            <div class="summary-body">
                <div>
                    <h3 style="font-family: var(--font-heading); font-size: 14px; color: var(--text-secondary); margin-bottom: 5px;">Rincian Belanja</h3>
                    <table class="pay-summary-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th style="text-align: right;">Total</th>
                            </tr>
                        </thead>
                        <tbody id="payItemsBody">
                            <!-- JS populated -->
                        </tbody>
                    </table>
                </div>

                <div class="summary-divider"></div>

                <div class="summary-row">
                    <span class="label" style="font-size: 13px;">Subtotal Roti</span>
                    <span class="value" id="paySubtotal" style="font-size: 14px;">Rp 0</span>
                </div>

                <div class="summary-row" id="paySavedRow" style="display: none;">
                    <span class="label" style="font-size: 13px; color: var(--success-green);">Hemat Promo</span>
                    <span class="value" id="paySaved" style="font-size: 14px; color: var(--success-green);">- Rp 0</span>
                </div>

                <div class="summary-row shipping">
                    <span class="label" style="font-size: 13px;">Ongkos Kirim</span>
                    <span class="value" id="payShipping" style="font-size: 14px;">Rp 10.000</span>
                </div>

                <div class="summary-total" style="padding-top: 12px; margin-top: 5px;">
                    <span class="label" style="font-size: 16px;">Total Pembayaran</span>
                    <span class="value" id="payTotal" style="font-size: 22px;">Rp 0</span>
                </div>

                <button class="checkout-cta" id="bayarBtn" onclick="openPaymentModal()" style="margin-top: 15px;">
                    Bayar Sekarang →
                </button>

                <div class="secure-badge">
                    <span>🔒</span> Pembayaran 100% Aman & Terenkripsi
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ====== QRIS POPUP MODAL ====== -->
<div class="qris-overlay" id="qrisModal">
    <div class="qris-modal">
        <div class="qris-modal-title">Scan & Bayar</div>
        <p class="qris-modal-sub" id="qrisModalMethodLabel">Scan kode QRIS dengan aplikasi pembayaran Anda</p>
        <img src="{{ asset('Gambar/qris.png') }}" alt="QRIS BreadRush" id="qrisModalImg">
        <div class="qris-modal-total" id="qrisModalTotal">Rp 0</div>
        <button class="qris-confirm-btn" id="qrisConfirmBtn" onclick="submitPayment()">
            ✅ Konfirmasi Pembayaran
        </button>
        <a class="qris-cancel-link" onclick="closeModal()">Batalkan & Kembali</a>
    </div>
</div>

<!-- ====== TOAST ====== -->
<div class="toast" id="toast">
    <span id="toastIcon">✅</span>
    <span id="toastMsg">Memproses pesanan...</span>
</div>

<script>
/* =============================
   LOAD CART FROM LOCALSTORAGE
============================= */
let cart = JSON.parse(localStorage.getItem('breadrushCart')) || [];
let selectedMethod = 'QRIS';

function formatRupiah(n) {
    return 'Rp ' + n.toLocaleString('id-ID');
}

/* =============================
   SELECT METHOD
============================= */
function selectMethod(id, el) {
    // Reset all
    document.querySelectorAll('.method-option').forEach(m => m.classList.remove('selected'));
    document.querySelectorAll('.payment-form-section').forEach(f => f.style.display = 'none');

    el.classList.add('selected');

    const methodMap = {
        'qris': { form: 'form-qris', label: 'QRIS' },
        'bca-va': { form: 'form-va', label: 'BCA Virtual Account' },
        'mandiri-va': { form: 'form-va', label: 'Mandiri Virtual Account' },
        'ewallet': { form: 'form-ewallet', label: 'E-Wallet (GoPay/OVO/DANA)' },
        'cc': { form: 'form-cc', label: 'Kartu Kredit/Debit' }
    };

    if (methodMap[id]) {
        document.getElementById(methodMap[id].form).style.display = 'flex';
        selectedMethod = methodMap[id].label;
    }
}

/* =============================
   RENDER BILL DETAILS
============================= */
function renderBill() {
    const body = document.getElementById('payItemsBody');

    if (cart.length === 0) {
        body.innerHTML = `<tr><td colspan="2" style="text-align:center;color:var(--text-muted);padding:20px 0;">Keranjang kosong.</td></tr>`;
        document.getElementById('bayarBtn').disabled = true;
        return;
    }

    let html = '';
    let subtotal = 0;
    let savings = 0;

    cart.forEach(item => {
        const hargaAsli = item.hargaAsli || item.harga;
        const itemTotal = item.harga * item.qty;
        subtotal += itemTotal;
        savings += (hargaAsli - item.harga) * item.qty;

        html += `
            <tr>
                <td>
                    <span class="pay-summary-item-name">${item.nama}</span><br>
                    <span class="pay-summary-item-qty">${item.qty} × ${formatRupiah(item.harga)}</span>
                </td>
                <td style="text-align:right;font-weight:700;color:var(--text-primary);">
                    ${formatRupiah(itemTotal)}
                </td>
            </tr>`;
    });

    body.innerHTML = html;

    const shipping = 10000;
    const grandTotal = subtotal + shipping;

    document.getElementById('paySubtotal').textContent = formatRupiah(subtotal + savings);

    if (savings > 0) {
        document.getElementById('paySavedRow').style.display = 'flex';
        document.getElementById('paySaved').textContent = '- ' + formatRupiah(savings);
    }

    document.getElementById('payShipping').textContent = formatRupiah(shipping);
    document.getElementById('payTotal').textContent = formatRupiah(grandTotal);

    // Update QRIS preview amounts
    document.getElementById('qrisPreviewAmount').textContent = formatRupiah(grandTotal);
    document.getElementById('qrisModalTotal').textContent = formatRupiah(grandTotal);
}

/* =============================
   OPEN PAYMENT MODAL
============================= */
function openPaymentModal() {
    if (cart.length === 0) {
        showToast('❌', 'Keranjang Anda kosong!');
        return;
    }

    // Update modal label
    if (selectedMethod === 'QRIS') {
        document.getElementById('qrisModalMethodLabel').textContent = 'Scan kode QRIS dengan aplikasi pembayaran Anda';
        document.getElementById('qrisModalImg').style.display = 'block';
    } else {
        document.getElementById('qrisModalMethodLabel').textContent = `Konfirmasi pembayaran via ${selectedMethod}`;
        document.getElementById('qrisModalImg').style.display = 'none';
    }

    // Recalculate total for modal
    let subtotal = cart.reduce((s, i) => s + (i.harga * i.qty), 0);
    const grandTotal = subtotal + 10000;
    document.getElementById('qrisModalTotal').textContent = formatRupiah(grandTotal);

    const modal = document.getElementById('qrisModal');
    modal.style.display = 'flex';
    requestAnimationFrame(() => modal.classList.add('open'));
}

function closeModal() {
    const modal = document.getElementById('qrisModal');
    modal.classList.remove('open');
    setTimeout(() => modal.style.display = 'none', 350);
}

/* =============================
   SUBMIT PAYMENT VIA AJAX
============================= */
function submitPayment() {
    const btn = document.getElementById('qrisConfirmBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="btn-spinner"></span>Memproses...';

    let subtotal = cart.reduce((s, i) => s + (i.harga * i.qty), 0);
    const grandTotal = subtotal + 10000;

    const payload = {
        metode_pembayaran: selectedMethod,
        total_bayar: grandTotal,
        items: cart.map(item => ({
            id: item.id,
            nama: item.nama,
            harga: item.harga,
            hargaAsli: item.hargaAsli || item.harga,
            qty: item.qty,
            gambar: item.gambar
        })),
        _token: '{{ csrf_token() }}'
    };

    fetch('{{ route("payment.submit") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify(payload)
    })
    .then(res => {
        if (!res.ok) throw new Error('Server error');
        return res.json();
    })
    .then(data => {
        if (data.success) {
            // Clear cart
            localStorage.removeItem('breadrushCart');
            window.location.href = '{{ url("/tracking") }}/' + data.id;
        } else {
            throw new Error('Pembayaran gagal');
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = '✅ Konfirmasi Pembayaran';
        showToast('❌', 'Gagal memproses pesanan. Coba lagi.');
    });
}

/* =============================
   TOAST
============================= */
function showToast(icon, msg) {
    document.getElementById('toastIcon').textContent = icon;
    document.getElementById('toastMsg').textContent = msg;
    const t = document.getElementById('toast');
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 3000);
}

/* =============================
   DARK MODE
============================= */
const toggle = document.getElementById("darkToggle");

if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark");
    toggle.innerText = "☀️";
} else {
    toggle.innerText = "🌙";
}

toggle.addEventListener("click", () => {
    document.body.classList.toggle("dark");
    const dark = document.body.classList.contains("dark");
    localStorage.setItem("theme", dark ? "dark" : "light");
    toggle.innerText = dark ? "☀️" : "🌙";
});

/* =============================
   CLOSE MODAL ON OVERLAY CLICK
============================= */
document.getElementById('qrisModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

/* =============================
   INIT
============================= */
renderBill();
</script>

</body>
</html>
