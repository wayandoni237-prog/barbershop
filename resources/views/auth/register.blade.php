@extends('layouts.app')

@section('content')
<style>
    /* register-page */
    .register-page {
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f5f0;
        padding: 1rem;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .register-card {
        display: flex;
        max-width: 1100px;
        width: 100%;
        background: #ffffff;
        border-radius: 2rem;
        overflow: hidden;
        box-shadow: 0 20px 35px rgba(0, 0, 0, 0.05);
        border: 1px solid #ece3d9;
    }

    /* Kolom kiri info barbershop */
    .info-panel {
        background: #1e1e1e;
        color: #fff;
        flex: 1;
        padding: 2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .info-panel h2 {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }

    .info-panel h2 span {
        color: #b68b5c;
    }

    .info-panel .tagline {
        font-size: 0.95rem;
        color: #ccc;
        margin-bottom: 1.5rem;
        border-left: 3px solid #b68b5c;
        padding-left: 1rem;
    }

    .info-detail {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }

    .info-detail i {
        font-style: normal;
        color: #b68b5c;
        background: rgba(255, 255, 255, 0.08);
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    /* Kolom kanan form register */
    .form-panel {
        flex: 1.2;
        padding: 1.8rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .form-panel h3 {
        font-size: 1.8rem;
        font-weight: 600;
        color: #1e1e1e;
        margin-bottom: 0.2rem;
    }

    .form-panel .sub {
        color: #6b6b6b;
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }

    /* Grid 2 kolom */
    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .form-group {
        flex: 1 1 calc(50% - 0.5rem);
        min-width: 0;
        margin-bottom: 0.8rem;
    }

    .form-group.full-width {
        flex: 1 1 100%;
    }

    .form-group label {
        display: block;
        font-size: 0.85rem;
        font-weight: 500;
        color: #2e2e2e;
        margin-bottom: 0.2rem;
    }

    .form-group input {
        width: 100%;
        padding: 0.7rem 1rem;
        border: 1.5px solid #e3dbd1;
        border-radius: 40px;
        font-size: 0.9rem;
        outline: none;
        transition: all 0.2s;
        background: #fff;
    }

    .form-group input:focus {
        border-color: #b68b5c;
        box-shadow: 0 0 0 3px rgba(182, 139, 92, 0.1);
    }

    .register-btn {
        background: #1e1e1e;
        color: #fff;
        border: none;
        padding: 0.8rem;
        border-radius: 40px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        margin-top: 0.5rem;
        transition: background 0.2s;
    }

    .register-btn:hover {
        background: #b68b5c;
    }

    .login-link {
        text-align: center;
        margin-top: 1rem;
        color: #4a4a4a;
        font-size: 0.9rem;
    }

    .login-link a {
        color: #b68b5c;
        text-decoration: none;
        font-weight: 600;
        border-bottom: 1px dotted;
    }

    .login-link a:hover {
        color: #7a4f2a;
    }

    /* Responsif */
    @media (max-width: 700px) {
        .register-card {
            flex-direction: column;
        }

        .form-group {
            flex: 1 1 100%;
        }

        .info-panel,
        .form-panel {
            padding: 1.5rem;
        }

        .register-page {
            padding: 0.5rem;
        }
    }
</style>

<div class="register-page">
    <div class="register-card">
        <!-- Kolom Kiri: Info Barbershop -->
        <div class="info-panel">
            <h2>Barbershop <span>●</span></h2>
            <div class="tagline">Professional & Affordable</div>
            <div class="info-detail"><i>📞</i> <span>+62 857-3854-0804</span></div>
            <div class="info-detail"><i>📍</i> <span>Jl. Teuku Umar Barat</span></div>
            <div class="info-detail"><i>✂️</i> <span>Haircut & Hairstyle</span></div>
        </div>

        <!-- Kolom Kanan: Form Register Compact -->
        <div class="form-panel">
            <h3>Register Account</h3>
            <div class="sub">Buat akun baru untuk memesan</div>

            @if(session('success'))
            <div class="sub alert alert-success">
                {{session('success')}}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
            @endif


            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-row">
                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        @error('email')
                        <span class="text-danger" style="font-size:.85rem;">{{ $message }}</span>
                        @enderror
                        <input type="email" id="email" name="email" placeholder="contoh@email.com" required>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Min. 8 karakter" required>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" placeholder="John Doe" required>
                    </div>

                    <!-- Username -->
                    <div class="form-group">
                        <label for="username">Username</label>
                        @error('username')
                        <span class="text-danger" style="font-size:.85rem;">{{ $message }}</span>
                        @enderror
                        <input type="text" id="username" name="username" placeholder="johndoe123" required>
                    </div>

                    <!-- No. Telepon -->
                    <div class="form-group">
                        <label for="no_hp">No. Telepon</label>
                        <input type="tel" id="no_hp" name="no_hp" placeholder="081234567890" required>
                    </div>

                    <!-- Alamat (full width) -->
                    <div class="form-group full-width">
                        <label for="alamat">Alamat</label>
                        <input type="text" id="alamat" name="alamat" placeholder="Jl. Teuku Umar Barat, Denpasar" required>
                    </div>
                </div>

                <button type="submit" class="register-btn">Register</button>

                <div class="login-link">
                    Already have an account? <a href="{{ route('login') }}">Login</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection