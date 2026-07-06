<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lacak status pesanan roti premium BreadRush Anda secara real-time.">
    <title>Tracking Pesanan - BreadRush</title>
    <link rel="stylesheet" href="{{ asset('stylecheckout.css') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <style>
        /* ====== TRACKING PAGE ====== */
        .tracking-wrapper {
            max-width: 860px;
            margin: 40px auto 80px;
            padding: 0 24px;
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        /* ====== ORDER SUCCESS BANNER ====== */
        .success-banner {
            background: linear-gradient(135deg, var(--accent-primary), #6B4226);
            color: #fff;
            border-radius: var(--radius-xl);
            padding: 32px 36px;
            display: flex;
            align-items: center;
            gap: 24px;
            box-shadow: 0 10px 40px rgba(139, 94, 60, 0.35);
        }

        .success-icon {
            font-size: 52px;
            flex-shrink: 0;
            animation: bounce 1.2s ease infinite alternate;
        }

        @keyframes bounce {
            from { transform: translateY(0); }
            to   { transform: translateY(-8px); }
        }

        .success-banner h2 {
            font-family: var(--font-heading);
            font-size: 24px;
            font-weight: 800;
            margin: 0 0 6px;
        }

        .success-banner p {
            font-size: 14px;
            opacity: 0.88;
            margin: 0;
        }

        .order-id-tag {
            margin-top: 10px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(6px);
            border-radius: 50px;
            padding: 6px 16px;
            font-family: monospace;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* ====== TRACKING STEPPER ====== */
        .tracking-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-xl);
            padding: 34px 36px;
            box-shadow: 0 6px 25px var(--shadow-color);
            transition: background-color var(--transition-smooth), border-color var(--transition-smooth);
        }

        .tracking-card-title {
            font-family: var(--font-heading);
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .tracking-card-title::before {
            content: '';
            display: inline-block;
            width: 5px;
            height: 22px;
            background: var(--accent-primary);
            border-radius: 4px;
        }

        /* --- Stepper --- */
        .stepper {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            position: relative;
            padding: 0 10px;
        }

        .stepper::before {
            content: '';
            position: absolute;
            top: 22px;
            left: 30px;
            right: 30px;
            height: 4px;
            background: var(--border-color);
            border-radius: 4px;
            z-index: 0;
        }

        .stepper-progress {
            position: absolute;
            top: 22px;
            left: 30px;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-primary), var(--warning-orange));
            border-radius: 4px;
            z-index: 1;
            transition: width 1s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            z-index: 2;
            flex: 1;
        }

        .step-circle {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            background: var(--bg-primary);
            border: 3px solid var(--border-color);
            transition: all 0.5s ease;
            position: relative;
        }

        .step.done .step-circle {
            background: var(--accent-primary);
            border-color: var(--accent-primary);
            box-shadow: 0 0 0 5px rgba(139, 94, 60, 0.18);
        }

        .step.active .step-circle {
            background: var(--warning-orange);
            border-color: var(--warning-orange);
            box-shadow: 0 0 0 5px rgba(232, 145, 58, 0.25);
            animation: pulse-ring 1.5s ease infinite;
        }

        @keyframes pulse-ring {
            0%   { box-shadow: 0 0 0 5px rgba(232, 145, 58, 0.25); }
            50%  { box-shadow: 0 0 0 12px rgba(232, 145, 58, 0.08); }
            100% { box-shadow: 0 0 0 5px rgba(232, 145, 58, 0.25); }
        }

        .step-label {
            font-family: var(--font-heading);
            font-size: 12px;
            font-weight: 700;
            text-align: center;
            color: var(--text-muted);
            max-width: 80px;
            line-height: 1.4;
        }

        .step.done .step-label,
        .step.active .step-label {
            color: var(--text-primary);
        }

        .step-time {
            font-size: 11px;
            color: var(--text-muted);
            text-align: center;
        }

        .step.done .step-time,
        .step.active .step-time {
            color: var(--accent-primary);
        }

        /* ====== ORDER DETAILS ====== */
        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .detail-block {
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 18px 20px;
            transition: background-color var(--transition-smooth), border-color var(--transition-smooth);
        }

        .detail-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .detail-value {
            font-family: var(--font-heading);
            font-size: 17px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .detail-value.highlight {
            color: var(--accent-primary);
            font-size: 20px;
        }

        /* ====== ITEMS LIST ====== */
        .order-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 0;
            border-bottom: 1px dashed var(--border-color);
            animation: fadeInUp 0.4s ease forwards;
            opacity: 0;
        }

        .order-item:last-child { border-bottom: none; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .order-item-img {
            width: 72px;
            height: 72px;
            border-radius: var(--radius-md);
            object-fit: cover;
            flex-shrink: 0;
            border: 2px solid var(--border-color);
        }

        .order-item-info { flex: 1; }

        .order-item-name {
            font-family: var(--font-heading);
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .order-item-qty {
            font-size: 13px;
            color: var(--text-secondary);
        }

        .order-item-price {
            font-family: var(--font-heading);
            font-size: 16px;
            font-weight: 700;
            color: var(--accent-primary);
            flex-shrink: 0;
        }

        /* ====== ACTION BUTTONS ====== */
        .action-row {
            display: flex;
            gap: 14px;
        }

        .btn-primary {
            flex: 1;
            padding: 15px;
            background: var(--accent-primary);
            color: #fff;
            border: none;
            border-radius: var(--radius-md);
            font-family: var(--font-heading);
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all var(--transition-fast);
        }

        .btn-primary:hover {
            background: var(--accent-hover);
            transform: translateY(-2px);
            color: #fff;
        }

        .btn-outline {
            flex: 1;
            padding: 15px;
            background: transparent;
            color: var(--accent-primary);
            border: 2px solid var(--accent-primary);
            border-radius: var(--radius-md);
            font-family: var(--font-heading);
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all var(--transition-fast);
        }

        .btn-outline:hover {
            background: var(--accent-soft);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .success-banner { flex-direction: column; text-align: center; }
            .stepper { gap: 10px; }
            .stepper::before { left: 20px; right: 20px; }
            .stepper-progress { left: 20px; }
            .step-circle { width: 38px; height: 38px; font-size: 16px; }
            .details-grid { grid-template-columns: 1fr; }
            .action-row { flex-direction: column; }
        }
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
        <a href="{{ route('tracking') }}" class="active">Riwayat</a>
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
        <a href="{{ route('home') }}">Home</a> / <span>Tracking Pesanan</span>
    </div>
    <h1>Tracking <span>Pesanan</span></h1>
    <p class="subtitle">Pantau status pesanan roti premium Anda secara real-time.</p>
</div>

<!-- ====== TRACKING WRAPPER ====== -->
<div class="tracking-wrapper">

    <!-- Success Banner -->
    <div class="success-banner">
        @php
            $icons = [
                'Pesanan diterima' => '📦',
                'Pesanan disiapkan' => '🍞',
                'Pesanan dikirim' => '🛵',
                'Pesanan selesai' => '🎉',
            ];
            $bannerIcon = $icons[$tracking->status_tracking] ?? '📦';
        @endphp
        <div class="success-icon">{{ $bannerIcon }}</div>
        <div>
            <h2>{{ $tracking->status_tracking }}</h2>
            <p>Terima kasih, <strong>{{ $tracking->nama_pelanggan }}</strong>! Pesanan Anda sedang kami proses dengan penuh kasih sayang. 🍞</p>
            <div class="order-id-tag">
                #TRX{{ str_pad($tracking->id, 6, '0', STR_PAD_LEFT) }}
            </div>
        </div>
    </div>

    <!-- Tracking Stepper -->
    <div class="tracking-card">
        <div class="tracking-card-title">Status Pengiriman</div>

        @php
            $steps = [
                1 => ['label' => 'Pesanan Diterima',  'icon' => '📦', 'status' => 'Pesanan diterima'],
                2 => ['label' => 'Sedang Disiapkan',  'icon' => '🍞', 'status' => 'Pesanan disiapkan'],
                3 => ['label' => 'Dalam Pengiriman',  'icon' => '🛵', 'status' => 'Pesanan dikirim'],
                4 => ['label' => 'Pesanan Selesai',   'icon' => '✅', 'status' => 'Pesanan selesai'],
            ];

            $currentStep = 1;
            foreach ($steps as $num => $s) {
                if ($tracking->status_tracking === $s['status']) {
                    $currentStep = $num;
                    break;
                }
            }

            // Progress bar width: 0%, 33%, 66%, 100%
            $progressWidths = [1 => '0%', 2 => '33%', 3 => '66%', 4 => '100%'];
            $progressWidth = $progressWidths[$currentStep] ?? '0%';
        @endphp

        <div class="stepper" id="stepper">
            <div class="stepper-progress" id="stepProgress" style="width: 0%;"></div>

            @foreach($steps as $num => $step)
                @php
                    $state = '';
                    if ($num < $currentStep) $state = 'done';
                    elseif ($num === $currentStep) $state = 'active';
                @endphp

                <div class="step {{ $state }}">
                    <div class="step-circle">{{ $step['icon'] }}</div>
                    <div class="step-label">{{ $step['label'] }}</div>
                    <div class="step-time">
                        @if($num <= $currentStep)
                            {{ $tracking->updated_at ? $tracking->updated_at->format('H:i') : '--:--' }}
                        @else
                            Menunggu...
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Order Details Grid -->
    <div class="tracking-card">
        <div class="tracking-card-title">Detail Pesanan</div>

        <div class="details-grid">
            <div class="detail-block">
                <div class="detail-label">Nama Pelanggan</div>
                <div class="detail-value">{{ $tracking->nama_pelanggan }}</div>
            </div>
            <div class="detail-block">
                <div class="detail-label">Metode Pembayaran</div>
                <div class="detail-value">{{ $tracking->metode_pembayaran }}</div>
            </div>
            <div class="detail-block">
                <div class="detail-label">Total Pembayaran</div>
                <div class="detail-value highlight">Rp {{ number_format($tracking->total_bayar, 0, ',', '.') }}</div>
            </div>
            <div class="detail-block">
                <div class="detail-label">Tanggal Pesanan</div>
                <div class="detail-value" style="font-size: 14px;">
                    {{ $tracking->created_at ? $tracking->created_at->format('d M Y, H:i') : '-' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Items Ordered -->
    <div class="tracking-card">
        <div class="tracking-card-title">Roti yang Dipesan</div>

        @if($tracking->items && count($tracking->items) > 0)
            @foreach($tracking->items as $index => $item)
                <div class="order-item" style="animation-delay: {{ $index * 0.1 }}s;">
                    <img class="order-item-img"
                         src="{{ asset($item['gambar'] ?? 'Gambar/Menu/cinnamon.png') }}"
                         alt="{{ $item['nama'] ?? 'Roti' }}"
                         onerror="this.src='{{ asset('Gambar/Menu/cinnamon.png') }}'">
                    <div class="order-item-info">
                        <div class="order-item-name">{{ $item['nama'] ?? 'Roti Premium' }}</div>
                        <div class="order-item-qty">
                            {{ $item['qty'] ?? 1 }} pcs ×
                            Rp {{ number_format($item['harga'] ?? 0, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="order-item-price">
                        Rp {{ number_format(($item['harga'] ?? 0) * ($item['qty'] ?? 1), 0, ',', '.') }}
                    </div>
                </div>
            @endforeach
        @else
            <p style="color: var(--text-muted); text-align: center; padding: 20px 0;">
                Tidak ada detail item pesanan.
            </p>
        @endif
    </div>

    <!-- Action Buttons -->
    <div class="action-row">
        <a href="{{ route('menu') }}" class="btn-primary">
            🍞 Pesan Lagi
        </a>
        <a href="{{ route('home') }}" class="btn-outline">
            🏠 Kembali ke Home
        </a>
    </div>

</div>

<script>
/* ====== ANIMATED STEPPER PROGRESS ====== */
window.addEventListener('load', () => {
    setTimeout(() => {
        document.getElementById('stepProgress').style.width = '{{ $progressWidth }}';
    }, 300);
});

/* ====== DARK MODE ====== */
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
</script>

</body>
</html>
