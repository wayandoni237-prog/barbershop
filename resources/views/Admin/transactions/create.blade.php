<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Proses Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
        }
        .payment-box {
            background: #2a2a2a;
            border-radius: 16px;
            width: 340px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
        }
        .payment-header {
            background: #1a1a1a;
            padding: 16px 20px;
            text-align: center;
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .payment-body {
            padding: 16px 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .payment-method {
            background: #3a3a3a;
            border-radius: 8px;
            padding: 12px 16px;
            text-align: center;
            color: #fff;
            font-weight: 600;
            font-size: 0.95rem;
        }
        .payment-info {
            background: #3a3a3a;
            border-radius: 8px;
            padding: 14px 16px;
            color: #e0e0e0;
            font-size: 0.88rem;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .payment-info .info-row {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .time-badge {
            background: #1a1a1a;
            border: 1px solid #555;
            border-radius: 20px;
            padding: 2px 10px;
            font-size: 0.8rem;
            color: #fff;
        }
        .services-list {
            margin: 4px 0 0 0;
            padding: 0;
            list-style: none;
            font-size: 0.82rem;
            color: #bbb;
        }
        .services-list li {
            padding: 2px 0;
        }
        .services-list li::before {
            content: '• ';
            color: #888;
        }
        .total-box {
            background: #fff;
            border-radius: 8px;
            padding: 10px 16px;
            color: #1a1a1a;
            font-weight: 700;
            font-size: 0.95rem;
        }
        .custom-select {
            background: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.9rem;
            color: #1a1a1a;
            width: 100%;
            outline: none;
            cursor: pointer;
        }
        .btn-action-row {
            display: flex;
            gap: 10px;
            padding: 0 20px 20px;
        }
        .btn-cancel-pay {
            flex: 1;
            background: #dc3545;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 11px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-cancel-pay:hover { background: #bb2d3b; color: #fff; }
        .btn-proses {
            flex: 1;
            background: #a7b27a;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 11px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-proses:hover { background: #8e9a63; }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center min-vh-100">

<div class="payment-box">

 

    

        {{-- HEADER --}}
        <div class="payment-header">
            Payment <i class="bi bi-credit-card-2-front"></i>
        </div>
       @if($errors->any())
    <div>
        <div class="alert alert-danger alert-dismissible fade show" style="min-width:260px;">
            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div>
        <div class="alert alert-danger alert-dismissible fade show" style="min-width:260px;">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('transactions.store', $booking->id) }}">
    @csrf

        <div class="payment-body">

            {{-- METODE BAYAR --}}
            <select name="metode_bayar" class="custom-select" required>
                <option value="" disabled selected>Pilih Metode Bayar</option>
                <option value="tunai">Tunai</option>
                <option value="qris">Qris</option>
            </select>

            {{-- INFO CUSTOMER --}}
            <div class="payment-info">
                <div class="info-row">
                    <span><strong>Username :</strong> {{ $booking->customer->user->nama }}</span>
                </div>
                <div class="info-row">
                    <span><strong>Barber :</strong> {{ $booking->barber->nama }}</span>
                </div>
                <div class="info-row">
                    <span><strong>Time</strong></span>
                    <span class="time-badge">
                        {{ \Carbon\Carbon::parse($booking->tanggal)->format('H:i') }}
                    </span>
                </div>
                <div>
                    <strong>Services :</strong>
                    <ul class="services-list">
                        @foreach($booking->details as $detail)
                        <li>{{ $detail->service->nama_service }} — Rp {{ number_format($detail->harga) }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- TOTAL --}}
            <div class="total-box">
                Total : Rp {{ number_format($booking->details->sum('harga')) }}
            </div>

        </div>

        {{-- BUTTONS --}}
        <div class="btn-action-row">
            <a href="{{ route('bookings.index') }}" class="btn-cancel-pay">Cancel</a>
            <button type="submit" class="btn-proses">Proses</button>
        </div>



    </form>

</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>