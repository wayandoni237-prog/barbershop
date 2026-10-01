@extends('layouts.app')

@section('content')
<style>
    /* login-page */
    .login-page {
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f5f0;
        padding: 2rem;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .login-card {
        display: flex;
        max-width: 1000px;
        width: 100%;
        background: #ffffff;
        border-radius: 2rem;
        overflow: hidden;
        box-shadow: 0 20px 35px rgba(0, 0, 0, 0.05);
        border: 1px solid #ece3d9;
    }

    /* Kolom kiri informasi barbershop */
    .info-panel {
        background: #1e1e1e;
        color: #fff;
        flex: 1;
        padding: 2.5rem;
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
        font-size: 1rem;
        color: #ccc;
        margin-bottom: 2rem;
        border-left: 3px solid #b68b5c;
        padding-left: 1rem;
    }

    .info-detail {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.2rem;
        font-size: 0.95rem;
    }

    .info-detail i {
        font-style: normal;
        color: #b68b5c;
        background: rgba(255, 255, 255, 0.08);
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .info-detail span {
        color: #e0e0e0;
    }

    /* Kolom kanan form login */
    .form-panel {
        flex: 1;
        padding: 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .form-panel h3 {
        font-size: 1.8rem;
        font-weight: 600;
        color: #1e1e1e;
        margin-bottom: 0.25rem;
    }

    .form-panel .sub {
        color: #6b6b6b;
        margin-bottom: 2rem;
        font-size: 0.95rem;
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-group label {
        display: block;
        font-size: 0.9rem;
        font-weight: 500;
        color: #2e2e2e;
        margin-bottom: 0.3rem;
    }

    .form-group input {
        width: 100%;
        padding: 0.85rem 1.2rem;
        border: 1.5px solid #e3dbd1;
        border-radius: 50px;
        font-size: 0.95rem;
        outline: none;
        transition: all 0.2s;
        background: #fff;
    }

    .form-group input:focus {
        border-color: #b68b5c;
        box-shadow: 0 0 0 3px rgba(182, 139, 92, 0.1);
    }

    .login-btn {
        background: #1e1e1e;
        color: #fff;
        border: none;
        padding: 0.9rem;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        margin-top: 0.75rem;
        transition: background 0.2s;
    }

    .login-btn:hover {
        background: #b68b5c;
    }

    .register-link {
        text-align: center;
        margin-top: 1.5rem;
        color: #4a4a4a;
        font-size: 0.9rem;
    }

    .register-link a {
        color: #b68b5c;
        text-decoration: none;
        font-weight: 600;
        border-bottom: 1px dotted;
    }

    .register-link a:hover {
        color: #7a4f2a;
    }

    /* Responsif */
    @media (max-width: 700px) {
        .login-card {
            flex-direction: column;
            border-radius: 1.5rem;
        }

        .info-panel {
            padding: 2rem;
        }

        .form-panel {
            padding: 2rem;
        }

        .login-page {
            padding: 1rem;
        }
    }
</style>

<div class="login-page">
    <div class="login-card">
        <!-- Kolom Info Kiri -->
        <div class="info-panel">
            <h2>Barbershop <span>●</span></h2>
            <div class="tagline">Professional & Affordable</div>

            <div class="info-detail">
                <i>📞</i>
                <span>+62 857-3854-0804</span>
            </div>
            <div class="info-detail">
                <i>📍</i>
                <span>Jl. Teuku Umar Barat</span>
            </div>
            <div class="info-detail">
                <i>✂️</i>
                <span>Haircut & Hairstyle</span>
            </div>
        </div>

        <!-- Kolom Kanan -->
        <div class="form-panel">
            <h3>Login Account</h3>
            <div class="sub">Silakan masuk untuk melanjutkan</div>

            @if (session('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
            @endif


            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" placeholder="contoh@email.com" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>

                <button type="submit" class="login-btn">Login</button>

                <div class="register-link">
                    Belum punya akun? <a href="{{ route('register') }}">Register</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection