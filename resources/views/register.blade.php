<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Daftar akun BreadRush untuk memesan roti premium pilihan Anda.">
    <title>BreadRush - Register</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
</head>
<body>

    <div class="header">
        <h2>BreadRush</h2>
        <div class="nav">
            <a href="{{ route('login') }}">
                <button type="button">Login</button>
            </a>
            <a href="{{ route('register') }}">
                <button type="button">Daftar</button>
            </a>
        </div>
    </div>

    <div class="container">
        <div class="left">
            <img src="{{ asset('Gambar/Cuplikan layar 2026-04-09 202048.png') }}" alt="Roti premium BreadRush">
        </div>

        <div class="right">
            <div class="form-box">
                <h2>Daftar Akun</h2>
                <p class="desc">Daftar gratis untuk mengakses produk kami</p>

                <button class="google-btn" type="button" onclick="googleLogin()">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google">
                    <span>Daftar Dengan Google</span>
                </button>

                <p class="divider">atau mendaftar dengan email</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Nama lengkap" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Minimal 6 karakter" required>

                    <label class="checkbox">
                        <input type="checkbox" required>
                        Setuju dengan Ketentuan
                    </label>

                    <button class="submit-btn" type="submit">Daftar</button>
                </form>

                <p class="login-text">
                    Sudah punya akun?
                    <a href="{{ route('login') }}">Login</a>
                </p>
            </div>
        </div>
    </div>

    @if (session('alert'))
        <script>
            alert("{{ session('alert') }}");
        </script>
    @endif

    <script>

    function googleLogin(){
        let pilihan = prompt(
            "Pilih akun Google:\n\n1. aliffarhan.az@gmail.com\n2. nabila.putri@gmail.com"
        );

        let nama = "";
        let email = "";
        let password = "admin123";

        // Akun 1
        if(pilihan == "1"){
            nama = "Alif";
            email = "aliffarhan.az@gmail.com";
        }
        // Akun 2
        else if(pilihan == "2"){
            nama = "Nabila";
            email = "nabila.putri@gmail.com";
        }
        // Salah input
        else {
            alert("Pilihan tidak valid!");
            return;
        }

        window.location.href = "{{ route('register.google') }}"
            + "?nama=" + encodeURIComponent(nama)
            + "&email=" + encodeURIComponent(email)
            + "&password=" + encodeURIComponent(password);
    }
    </script>
</body>
</html>
