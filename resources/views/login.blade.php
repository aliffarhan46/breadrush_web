<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login ke akun BreadRush Anda untuk mengelola pesanan roti premium.">
    <title>BreadRush - Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    
    @if(env('GOOGLE_CLIENT_ID'))
        <!-- Load Google Identity Services SDK -->
        <script src="https://accounts.google.com/gsi/client" async defer></script>
    @endif

    <style>
        /* Google Account Chooser Modal Styling */
        .g-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
            align-items: center;
            justify-content: center;
        }
        .g-modal-content {
            background-color: #ffffff;
            border-radius: 16px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 12px 36px rgba(0,0,0,0.15);
            padding: 30px 24px;
            animation: gModalOpen 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            font-family: 'Outfit', sans-serif;
        }
        @keyframes gModalOpen {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .g-logo {
            width: 32px;
            height: 32px;
            display: block;
            margin: 0 auto 12px;
        }
        .g-modal-header {
            text-align: center;
            margin-bottom: 24px;
        }
        .g-modal-header h3 {
            font-size: 20px;
            font-weight: 500;
            color: #202124;
            margin-bottom: 4px;
            margin-top: 0;
        }
        .g-modal-header p {
            font-size: 14px;
            color: #5f6368;
            margin: 0;
        }
        .g-modal-body {
            max-height: 250px;
            overflow-y: auto;
            margin-bottom: 16px;
        }
        .g-account-item {
            display: flex;
            align-items: center;
            padding: 10px 12px;
            border-bottom: 1px solid #f1f3f4;
            cursor: pointer;
            transition: background-color 0.2s;
            border-radius: 8px;
            margin-bottom: 4px;
        }
        .g-account-item:hover {
            background-color: #f8f9fa;
        }
        .g-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #8b5e3c;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
            margin-right: 12px;
            overflow: hidden;
            flex-shrink: 0;
        }
        .g-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .g-account-info {
            flex-grow: 1;
            text-align: left;
        }
        .g-account-name {
            font-size: 14px;
            font-weight: 500;
            color: #3c4043;
        }
        .g-account-email {
            font-size: 12px;
            color: #5f6368;
        }
        .g-account-delete {
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 16px;
            color: #dadce0;
            padding: 6px;
            transition: color 0.2s;
        }
        .g-account-delete:hover {
            color: #ea4335;
        }
        .g-modal-footer {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 10px;
        }
        .g-btn-add, .g-btn-submit {
            width: 100%;
            padding: 11px;
            border: 1px solid #dadce0;
            border-radius: 8px;
            background-color: #ffffff;
            color: #1a73e8;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            font-family: 'Outfit', sans-serif;
            transition: background-color 0.2s;
        }
        .g-btn-add:hover {
            background-color: #f8f9fa;
        }
        .g-btn-submit {
            background-color: #1a73e8;
            color: #ffffff;
            border: none;
        }
        .g-btn-submit:hover {
            background-color: #1557b0;
        }
        .g-btn-cancel {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: transparent;
            color: #5f6368;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            font-family: 'Outfit', sans-serif;
        }
        .g-btn-cancel:hover {
            color: #202124;
        }
        .g-form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 12px;
            text-align: left;
        }
        .g-form-group label {
            font-size: 12px;
            font-weight: 600;
            color: #3c4043;
        }
        .g-form-group input {
            padding: 10px;
            border: 1px solid #dadce0;
            border-radius: 8px;
            font-size: 13px;
            font-family: 'Outfit', sans-serif;
        }
        .g-form-group input:focus {
            outline: none;
            border-color: #1a73e8;
        }
    </style>
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
                <h2>Login Akun</h2>
                <p class="desc">Masuk untuk mengelola pesanan roti Anda</p>

                <button class="google-btn" type="button" onclick="googleLogin()">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google">
                    <span>Login Dengan Google</span>
                </button>

                <p class="divider">atau masuk dengan email</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required>

                    <button class="submit-btn" type="submit">Login</button>
                </form>

                <p class="login-text">
                    Belum punya akun?
                    <a href="{{ route('register') }}">Daftar</a>
                </p>
            </div>
        </div>
    </div>

    @if (session('alert'))
        <script>
            alert("{{ session('alert') }}");
        </script>
    @endif
    @if (session('alert_success'))
        <script>
            alert("{{ session('alert_success') }}");
        </script>
    @endif

    <!-- Google Account Chooser Modal (Fallback) -->
    <div id="googleModal" class="g-modal">
        <div class="g-modal-content">
            <div class="g-modal-header">
                <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google" class="g-logo">
                <h3>Pilih akun</h3>
                <p>untuk melanjutkan ke BreadRush</p>
            </div>
            <div class="g-modal-body" id="accountsList">
                <!-- Akun Google pada perangkat akan dimuat di sini -->
            </div>
            <div class="g-modal-footer">
                <button class="g-btn-add" onclick="showAddAccountForm()">Gunakan akun lain</button>
                <button class="g-btn-cancel" onclick="closeGoogleModal()">Batal</button>
            </div>
        </div>
    </div>

    <!-- Modal Tambahkan Akun Baru ke Perangkat -->
    <div id="addAccountModal" class="g-modal">
        <div class="g-modal-content">
            <div class="g-modal-header">
                <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google" class="g-logo">
                <h3>Hubungkan Akun</h3>
                <p>Tambahkan akun Google yang tersedia di perangkat ini</p>
            </div>
            <div class="g-modal-body">
                <div class="g-form-group">
                    <label for="new_nama">Nama Lengkap</label>
                    <input type="text" id="new_nama" placeholder="Contoh: Alif Farhan">
                </div>
                <div class="g-form-group">
                    <label for="new_email">Email Gmail</label>
                    <input type="email" id="new_email" placeholder="contoh@gmail.com">
                </div>
                <div class="g-form-group">
                    <label for="new_avatar">Link Foto Profil (Opsional)</label>
                    <input type="text" id="new_avatar" placeholder="https://example.com/foto.jpg">
                </div>
            </div>
            <div class="g-modal-footer">
                <button class="g-btn-submit" onclick="saveNewAccount()">Hubungkan Akun</button>
                <button class="g-btn-cancel" onclick="hideAddAccountForm()">Kembali</button>
            </div>
        </div>
    </div>

    <script>
    // Ambil client_id jika dikonfigurasi
    const googleClientId = "{{ env('GOOGLE_CLIENT_ID') }}";

    // Setup GIS jika Client ID tersedia
    if (googleClientId) {
        window.onload = function () {
            google.accounts.id.initialize({
                client_id: googleClientId,
                callback: handleGoogleCredentialResponse
            });
        }

        function handleGoogleCredentialResponse(response) {
            const payload = decodeJwtResponse(response.credential);
            persistAccountToDevice({
                nama: payload.name || payload.email || 'Google Account',
                email: payload.email,
                avatar: payload.picture || '',
                isDefault: true
            });
            window.location.href = "{{ route('login.google') }}"
                + "?nama=" + encodeURIComponent(payload.name)
                + "&email=" + encodeURIComponent(payload.email)
                + "&avatar=" + encodeURIComponent(payload.picture)
                + "&password=" + encodeURIComponent("google_oauth_" + payload.sub);
        }

        function decodeJwtResponse(token) {
            let base64Url = token.split('.')[1];
            let base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
            let jsonPayload = decodeURIComponent(window.atob(base64).split('').map(function(c) {
                return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
            }).join(''));
            return JSON.parse(jsonPayload);
        }
    }

    function getDeviceAccounts() {
        const saved = localStorage.getItem('google_accounts_device');
        if (!saved) {
            return [];
        }

        try {
            const parsed = JSON.parse(saved);
            return Array.isArray(parsed) ? parsed : [];
        } catch (error) {
            localStorage.removeItem('google_accounts_device');
            return [];
        }
    }

    function saveDeviceAccounts(accounts) {
        localStorage.setItem('google_accounts_device', JSON.stringify(accounts));
    }

    function persistAccountToDevice(account) {
        const accounts = getDeviceAccounts();
        const email = (account.email || '').toLowerCase();
        const existingIndex = accounts.findIndex(acc => (acc.email || '').toLowerCase() === email);

        if (existingIndex >= 0) {
            accounts[existingIndex] = { ...accounts[existingIndex], ...account, isDefault: true };
        } else {
            accounts.unshift({ ...account, isDefault: true });
        }

        saveDeviceAccounts(accounts.slice(0, 6));
    }

    function renderAccounts() {
        const accounts = getDeviceAccounts();
        const container = document.getElementById('accountsList');
        container.innerHTML = '';

        if (!accounts.length) {
            container.innerHTML = `
                <div style="padding: 10px 0; color: #5f6368; font-size: 13px; text-align: center;">
                    Belum ada akun Google yang tersimpan di perangkat ini.
                </div>
            `;
            return;
        }

        accounts.forEach((acc, index) => {
            const avatarChar = (acc.nama || acc.email || 'G').charAt(0).toUpperCase();
            const avatarContent = acc.avatar
                ? `<img src="${acc.avatar}" alt="Avatar">`
                : avatarChar;

            const item = document.createElement('div');
            item.className = 'g-account-item';
            item.innerHTML = `
                <div class="g-avatar">${avatarContent}</div>
                <div class="g-account-info" onclick="selectAccount(${index})">
                    <div class="g-account-name">${(acc.nama || acc.email || 'Google Account').replace(/</g, '&lt;')}</div>
                    <div class="g-account-email">${(acc.email || 'Akun belum lengkap').replace(/</g, '&lt;')}</div>
                </div>
                <button class="g-account-delete" onclick="deleteAccount(${index}); event.stopPropagation();" title="Hapus akun dari perangkat">✕</button>
            `;
            container.appendChild(item);
        });
    }

    function googleLogin() {
        if (googleClientId) {
            // Jika ada Client ID, pemicu Google GIS native
            google.accounts.id.prompt();
        } else {
            // Jika tidak ada Client ID, tampilkan modal kustom (akun perangkat)
            document.getElementById('googleModal').style.display = 'flex';
            renderAccounts();
        }
    }

    function closeGoogleModal() {
        document.getElementById('googleModal').style.display = 'none';
    }

    document.querySelector('.google-btn').addEventListener('click', function(e) {
        e.preventDefault();
        googleLogin();
    });

    function showAddAccountForm() {
        document.getElementById('googleModal').style.display = 'none';
        document.getElementById('addAccountModal').style.display = 'flex';
    }

    function hideAddAccountForm() {
        document.getElementById('addAccountModal').style.display = 'none';
        document.getElementById('googleModal').style.display = 'flex';
    }

    function saveNewAccount() {
        const nama = document.getElementById('new_nama').value.trim();
        const email = document.getElementById('new_email').value.trim();
        const avatar = document.getElementById('new_avatar').value.trim();

        if (!nama || !email) {
            alert("Nama dan Email wajib diisi!");
            return;
        }

        if (!email.endsWith("@gmail.com")) {
            alert("Email harus berupa alamat @gmail.com!");
            return;
        }

        const accounts = getDeviceAccounts();

        // Cek duplikasi
        if (accounts.some(acc => (acc.email || '').toLowerCase() === email.toLowerCase())) {
            alert("Akun dengan email tersebut sudah terhubung!");
            return;
        }

        accounts.push({ nama, email, avatar, isDefault: false });
        saveDeviceAccounts(accounts);

        // Bersihkan input
        document.getElementById('new_nama').value = '';
        document.getElementById('new_email').value = '';
        document.getElementById('new_avatar').value = '';

        hideAddAccountForm();
        renderAccounts();
    }

    function deleteAccount(index) {
        const accounts = getDeviceAccounts();
        accounts.splice(index, 1);
        saveDeviceAccounts(accounts);
        renderAccounts();
    }

    function selectAccount(index) {
        const accounts = getDeviceAccounts();
        const acc = accounts[index];
        if (!acc) {
            return;
        }

        persistAccountToDevice({
            nama: acc.nama || acc.email || 'Google Account',
            email: acc.email,
            avatar: acc.avatar || '',
            isDefault: true
        });

        const password = "google_mock_password";
        closeGoogleModal();

        window.location.href = "{{ route('login.google') }}"
            + "?nama=" + encodeURIComponent(acc.nama || acc.email || 'Google Account')
            + "&email=" + encodeURIComponent(acc.email)
            + "&avatar=" + encodeURIComponent(acc.avatar || '')
            + "&password=" + encodeURIComponent(password);
    }

    // Tutup modal jika klik di luar box
    window.onclick = function(event) {
        const gModal = document.getElementById('googleModal');
        const addModal = document.getElementById('addAccountModal');
        if (event.target === gModal) {
            closeGoogleModal();
        }
        if (event.target === addModal) {
            hideAddAccountForm();
            closeGoogleModal();
        }
    }
    </script>
</body>
</html>
