@extends('layouts.appadmin')

@section('title', 'Admin Panel · Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/users/index.css') }}">
<style>
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }
    .stat-card {
        background: #2D2D2D;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: transform 0.2s, background 0.2s;
    }
    .stat-card:hover {
        background: #3a3a3a;
        transform: translateY(-3px);
    }
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .stat-info p { margin: 0; font-size: 0.78rem; color: #aaa; }
    .stat-info h4 { margin: 4px 0 0; font-size: 1.4rem; font-weight: 700; color: #fff; }

    .row-cards {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 20px;
    }
    .dash-card {
        background: #2D2D2D;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 20px;
    }
    .dash-card-header {
        background: #1e1e1e;
        padding: 14px 18px;
        color: #fff;
        font-weight: 600;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .dash-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.84rem;
    }
    .dash-table thead th {
        background: #3E3B3B;
        color: #ccc;
        padding: 10px 14px;
        font-weight: 600;
        text-align: left;
        white-space: nowrap;
    }
    .dash-table tbody td {
        padding: 10px 14px;
        color: #e0e0e0;
        border-bottom: 1px solid rgba(255,255,255,0.04);
        vertical-align: middle;
    }
    .dash-table tbody tr:last-child td { border-bottom: none; }
    .dash-table tbody tr:hover td { background: rgba(255,255,255,0.03); }

    /* table scroll on small screens */
    .table-wrap { overflow-x: auto; }

    .status-badge {
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .status-menunggu { background: rgba(255,193,7,0.15);   color: #ffc107; }
    .status-diterima { background: rgba(76,175,80,0.15);   color: #4caf50; }
    .status-batal    { background: rgba(229,57,53,0.15);   color: #e57373; }
    .status-selesai  { background: rgba(59,130,246,0.15);  color: #3b82f6; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .stat-grid { grid-template-columns: repeat(2, 1fr); }
        .row-cards  { grid-template-columns: 1fr; }
    }
    @media (max-width: 576px) {
        .stat-grid  { grid-template-columns: 1fr 1fr; }
        .stat-card  { padding: 14px; gap: 10px; }
        .stat-icon  { width: 38px; height: 38px; font-size: 1.1rem; }
        .stat-info h4 { font-size: 1.1rem; }
    }
    @media (max-width: 400px) {
        .stat-grid  { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

<div class="breadcrumb-panel">
    <i class="bi bi-house-door"></i> Panel / <span style="font-weight:500; color:black;">Dashboard</span>
</div>

{{-- STAT CARDS --}}
<div class="stat-grid">
    <a href="{{ route('customers.index') }}" class="stat-card text-decoration-none">
        <div class="stat-icon" style="background:rgba(59,130,246,0.15);">
            <i class="bi bi-people" style="color:#3b82f6;"></i>
        </div>
        <div class="stat-info">
            <p>Total Customer</p>
            <h4>{{ $totalCustomer }}</h4>
        </div>
    </a>
    <a href="{{ route('bookings.index') }}" class="stat-card text-decoration-none">
        <div class="stat-icon" style="background:rgba(76,175,80,0.15);">
            <i class="bi bi-calendar-check" style="color:#4caf50;"></i>
        </div>
        <div class="stat-info">
            <p>Today's booking</p>
            <h4>{{ $bookingHariIni }}</h4>
        </div>
    </a>
    <a href="{{ route('barbers.index') }}" class="stat-card text-decoration-none">
        <div class="stat-icon" style="background:rgba(255,193,7,0.15);">
            <i class="bi bi-scissors" style="color:#ffc107;"></i>
        </div>
        <div class="stat-info">
            <p>Total Barber</p>
            <h4>{{ $totalBarber }}</h4>
        </div>
    </a>
    <a href="{{ route('laporan.index') }}" class="stat-card text-decoration-none">
        <div class="stat-icon" style="background:rgba(181,160,140,0.2);">
            <i class="bi bi-currency-dollar" style="color:#b5a08c;"></i>
        </div>
        <div class="stat-info">
            <p>Month's income</p>
            <h4 style="font-size:1rem;">Rp {{ number_format($incomeBulanIni, 0, ',', '.') }}</h4>
        </div>
    </a>
</div>

{{-- BOOKING TERBARU + BARBER --}}
<div class="row-cards">
    <div class="dash-card" style="margin-bottom:0;">
        <div class="dash-card-header">
            <i class="bi bi-calendar3"></i> latest booking
        </div>
        <div class="table-wrap">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookingTerbaru as $b)
                    <tr>
                        <td>{{ $b->username }}</td>
                        <td>{{ \Carbon\Carbon::parse($b->tanggal)->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($b->status === 'selesai')
                            <span class="status-badge status-{{ $b->status }}">
                                Done
                            </span>
                            @elseif($b->status === 'diterima')
                            <span class="status-badge status-{{ $b->status }}">
                                Accepted
                            </span>
                            @elseif($b->status === 'menunggu')
                            <span class="status-badge status-{{ $b->status }}">
                                Pending
                            </span>
                            @else
                            <span class="status-badge status-{{ $b->status }}">
                                Rejected
                            </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center" style="color:#666; padding:16px;">No booking's yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="dash-card" style="margin-bottom:0;">
        <div class="dash-card-header">
            <i class="bi bi-scissors"></i> Barber data
        </div>
        <div class="table-wrap">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone number</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barbers as $barber)
                    <tr>
                        <td>{{ $barber->nama }}</td>
                        <td>{{ $barber->no_hp ?? '-' }}</td>
                        <td>{{ $barber->alamat ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center" style="color:#666; padding:16px;">No Barber's yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- DAFTAR SERVICE --}}
<div class="dash-card">
    <div class="dash-card-header">
        <i class="bi bi-card-checklist"></i> Service data
    </div>
    <div class="table-wrap">
        <table class="dash-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Services name</th>
                    <th>Price</th>
                    <th>Estimate</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $i => $s)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $s->nama_service }}</td>
                    <td>Rp {{ number_format($s->harga, 0, ',', '.') }}</td>
                    <td>{{ $s->estimasi_menit }} menit</td>
                    <td>
                        @if($s->is_active)
                            <span class="status-badge status-diterima">Active</span>
                        @else
                            <span class="status-badge status-batal">Inactive</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center" style="color:#666; padding:16px;">No services yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection