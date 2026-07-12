<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - BreadRush</title>
    <link rel="stylesheet" href="{{ asset('css/stylehome.css') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <style>
        :root {
            --primary-color: #8b5e3c;
            --primary-hover: #a47148;
            --bg-main: #faf6f1;
            --bg-card: rgba(255, 255, 255, 0.8);
            --text-title: #3d2b1a;
            --text-body: #5a4633;
            --text-muted: #8a7560;
            --border-color: rgba(139, 94, 60, 0.15);
            --shadow-color: rgba(139, 94, 60, 0.08);
            --input-bg: #ffffff;
        }

        body.dark {
            --bg-main: #18120e;
            --bg-card: rgba(30, 24, 20, 0.8);
            --text-title: #f7ede2;
            --text-body: #d7ccc8;
            --text-muted: #a1887f;
            --border-color: rgba(215, 204, 200, 0.15);
            --shadow-color: rgba(0, 0, 0, 0.4);
            --input-bg: #2b221a;
        }

        body {
            background: var(--bg-main);
            color: var(--text-body);
            transition: background-color 0.3s ease, color 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .profile-container {
            max-width: 800px;
            width: 90%;
            margin: 120px auto 60px;
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px var(--shadow-color);
            position: relative;
            z-index: 10;
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 40px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 30px;
        }

        @media (max-width: 600px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
            }
            .profile-container {
                padding: 20px;
                margin-top: 100px;
            }
        }

        .avatar-wrapper {
            position: relative;
            width: 130px;
            height: 130px;
        }

        .avatar-preview {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--primary-color);
            box-shadow: 0 4px 14px var(--shadow-color);
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 48px;
            font-weight: 700;
            overflow: hidden;
        }

        .avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-upload-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            background: var(--primary-color);
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 2px solid var(--bg-main);
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .avatar-upload-btn:hover {
            background: var(--primary-hover);
            transform: scale(1.1);
        }

        .profile-info h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-title);
            margin-bottom: 6px;
        }

        .profile-info p {
            color: var(--text-muted);
            font-size: 14px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        @media (max-width: 600px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-body);
        }

        .form-group input {
            padding: 12px 16px;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            background: var(--input-bg);
            color: var(--text-body);
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(139, 94, 60, 0.15);
        }

        .form-group input:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            background: rgba(139, 94, 60, 0.05);
        }

        .button-group {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .btn-save {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Outfit', sans-serif;
        }

        .btn-save:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(139, 94, 60, 0.2);
        }

        .btn-back {
            background: transparent;
            color: var(--text-body);
            border: 1px solid var(--border-color);
            padding: 12px 28px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            font-family: 'Outfit', sans-serif;
        }

        .btn-back:hover {
            background: rgba(139, 94, 60, 0.05);
            border-color: var(--primary-color);
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
        <button id="darkToggle" aria-label="Toggle Tema">🌙</button>

        <div class="user-profile">
            <!-- Tautan ke Halaman Profil dengan Avatar atau Inisial -->
            <a href="{{ route('profile') }}" class="user-profile-link" style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: inherit;">
                <div class="user-avatar" style="width: 32px; height: 32px; border-radius: 50%; overflow: hidden; background: var(--primary-color); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px;">
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
            <button type="button" class="logout-btn" onclick="document.getElementById('logout-form').submit();" style="margin-left: 10px;">
                Keluar
            </button>
        </div>
    </div>
</div>

<div class="profile-container">
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="profile-header">
            <div class="avatar-wrapper">
                <div class="avatar-preview" id="avatarPreview">
                    @if ($user->foto_profile)
                        <img src="{{ str_starts_with($user->foto_profile, 'http') ? $user->foto_profile : asset($user->foto_profile) }}" alt="Foto Profil">
                    @else
                        {{ strtoupper(substr($user->nama, 0, 1)) }}
                    @endif
                </div>
                <label for="foto_profile" class="avatar-upload-btn" title="Unggah Foto Baru">
                    📷
                </label>
                <input type="file" id="foto_profile" name="foto_profile" accept="image/*" style="display: none;" onchange="previewImage(event)">
            </div>
            
            <div class="profile-info">
                <h1>{{ $user->nama }}</h1>
                <p>{{ $user->email }}</p>
                <p style="margin-top: 4px; font-size: 12px; opacity: 0.8;">Metode Login: {{ str_starts_with($user->password_users, '$2y$') || str_starts_with($user->password_users, '$2x$') ? 'Email & Password' : 'Google Authentication' }}</p>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $user->nama) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Alamat Email (Tidak dapat diubah)</label>
                <input type="email" id="email" value="{{ $user->email }}" disabled>
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi Baru (Opsional)</label>
                <input type="password" id="password" name="password" placeholder="Masukkan jika ingin mengganti">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi kata sandi baru">
            </div>
        </div>

        <div class="button-group">
            <a href="{{ route('home') }}" class="btn-back">Kembali ke Home</a>
            <button type="submit" class="btn-save">Simpan Perubahan</button>
        </div>
    </form>
</div>

<script>
    /* ====================================
       PRATINJAU GAMBAR UNGGAHAN
       ==================================== */
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('avatarPreview');
            output.innerHTML = `<img src="${reader.result}" alt="Foto Profil">`;
        };
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    /* ====================================
       PENGATURAN TEMA GELAP (DARK MODE)
       ==================================== */
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

@include('academic_footer')

@if (session('alert_success'))
    <script>
        alert("{{ session('alert_success') }}");
    </script>
@endif
@if (session('alert'))
    <script>
        alert("{{ session('alert') }}");
    </script>
@endif
@if ($errors->any())
    <script>
        alert("{{ $errors->first() }}");
    </script>
@endif

</body>
</html>
