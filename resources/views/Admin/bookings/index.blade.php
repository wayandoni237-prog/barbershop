@extends('layouts.appadmin')

@section('title', 'Admin Panel · Booking Data')
@section('page-title', 'Booking Data')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/users/index.css') }}">
@endpush

@section('content')

<div class="breadcrumb-panel">
    <i class="bi bi-house-door"></i> Panel / <span style="font-weight:500; color:black;">Booking Data</span>
</div>

<div class="container-fluid p-0 mt-4">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="user-card">
        <div class="user-header">
            <h5 class="mb-0">Customer Booking Data</h5>
        </div>

        <div class="table-wrapper">
        <table class="table table-borderless user-table mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Date</th>
                    <th>Barber</th>
                    <th>Status</th>
                    <th>Action</th>
                    <th>Transaction Proccess</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $i => $booking)
                <tr>
                    <td>{{ $i + 1 }}.</td>
                    <td>{{ $booking->username }}</td>
                    <td>{{ $booking->email }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->tanggal)->format('d/m/Y H:i') }}</td>
                    <td>{{ $booking->nama_barber ? 'Barber ' . $booking->nama_barber : '-' }}</td>
                    <td>
                        @if($booking->status === 'diterima')
                            <span class="badge bg-success">Accepted</span>
                        @elseif($booking->status === 'batal')
                            <span class="badge bg-danger">Rejected</span>
                        @elseif($booking->status === 'selesai')
                            <span class="badge btn-done">Done</span>
                        @else
                            <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2 flex-wrap">
                            @if($booking->status === 'menunggu')
                                <form action="{{ route('bookings.accept', $booking->id) }}" method="POST" class="m-0">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-success">Accept</button>
                                </form>
                                <form action="{{ route('bookings.reject', $booking->id) }}" method="POST" class="m-0">
                                    @csrf @method('PATCH')
                                    <button type="button" class="btn-delete"
                                            onclick="confirmReject('$booking->id')">Reject</button>
                                </form>
                            @endif
                            {{-- UBAH: Jadi button modal --}}
                            @if($booking->status === 'menunggu')
                            <button type="button" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $booking->id }}">
                                Edit
                            </button>

                            @elseif ($booking->status === 'diterima')
                            <button type="button" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $booking->id }}">
                                Edit
                            </button>

                            @else
                            <button disabled type="button" style="background-color: #2D2D2D; color:white;" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $booking->id }}">
                                Cannot edit
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        @if($booking->status === 'diterima')
                            {{-- UBAH: Jadi button modal --}}
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#transactionModal{{ $booking->id }}">
                                Transaction proccess
                            </button>
                        @elseif($booking->status === 'menunggu') 
                            <button style="background-color: #2D2D2D;" disabled class="btn btn-secondary btn-sm">Cannot Procces</button>
                        @else
                            <button style="background-color: #2D2D2D;" disabled class="btn btn-secondary btn-sm">Transaction done</button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4">No booking's yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

</div>

{{-- ═══════════════════════ MODALS ═══════════════════════ --}}
@foreach($bookings as $booking)

{{-- EDIT MODAL --}}
<div class="modal fade" id="editModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-0" style="border-radius:12px; overflow:hidden;">
            
            {{-- HEADER: KIRI (konsisten dengan gambar) --}}
            <div class="modal-header border-0 pb-2 pt-3 px-4">
                <span style="background:#2b2b2b; color:#fff; padding:6px 14px; border-radius:8px; font-size:.85rem; font-weight:600;">
                    Edit Booking
                </span>
            </div>

            {{-- BODY --}}
            <div class="modal-body px-4 pb-4 pt-0">
                @if($errors->any())
                    <div class="alert alert-danger py-2 mb-3" style="font-size:0.8rem;">
                        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                    </div>
                @endif

                <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Date --}}
                    <input type="date" name="tanggal_booking"
                           class="form-control mb-3"
                           style="border:none; border-radius:8px; padding:12px 14px; font-size:0.9rem;"
                           value="{{ \Carbon\Carbon::parse($booking->tanggal)->format('Y-m-d') }}"
                           required>

                    {{-- Jam --}}
                    <select name="jam_booking" class="form-select mb-3" required
                            style="border:none; border-radius:8px; padding:12px 14px; font-size:0.9rem; appearance:none; -webkit-appearance:none; background-image:url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%2712%27 height=%2712%27 fill=%27333%27 viewBox=%270 0 16 16%27%3E%3Cpath d=%27M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z%27/%3E%3C/svg%3E'); background-repeat:no-repeat; background-position:right 12px center; padding-right:35px;">
                        <option value="" disabled>-- Select Hour --</option>
                        @foreach(['10:00','11:00','13:00','14:00','15:00','16:00','19:00'] as $jam)
                            <option value="{{ $jam }}"
                                {{ \Carbon\Carbon::parse($booking->tanggal)->format('H:i') === $jam ? 'selected' : '' }}>
                                {{ $jam }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Barber --}}
                    <select name="id_barber" class="form-select mb-3"
                            style="border:none; border-radius:8px; padding:12px 14px; font-size:0.9rem; appearance:none; -webkit-appearance:none; background-image:url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%2712%27 height=%2712%27 fill=%27333%27 viewBox=%270 0 16 16%27%3E%3Cpath d=%27M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z%27/%3E%3C/svg%3E'); background-repeat:no-repeat; background-position:right 12px center; padding-right:35px;">
                        <option value="">-- Pilih Barber --</option>
                        @foreach($barbers as $barber)
                            <option value="{{ $barber->id }}"
                                {{ $booking->id_barber == $barber->id ? 'selected' : '' }}>
                                {{ $barber->nama }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Status --}}
                    <select name="status" class="form-select mb-4"
                            style="border:none; border-radius:8px; padding:12px 14px; font-size:0.9rem; appearance:none; -webkit-appearance:none; background-image:url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%2712%27 height=%2712%27 fill=%27333%27 viewBox=%270 0 16 16%27%3E%3Cpath d=%27M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z%27/%3E%3C/svg%3E'); background-repeat:no-repeat; background-position:right 12px center; padding-right:35px;">
                        <option value="menunggu" {{ $booking->status === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diterima" {{ $booking->status === 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="batal"    {{ $booking->status === 'batal'    ? 'selected' : '' }}>Batal</option>
                    </select>

                    {{-- Buttons --}}
                    <div class="d-flex gap-3">
                        <button type="button" class="btn flex-fill" data-bs-dismiss="modal"
                                style="background:#dc3545; color:#fff; font-weight:500; height:44px; border-radius:8px; border:none; font-size:0.95rem;">
                            Cancel
                        </button>
                        <button type="submit" class="btn flex-fill"
                                style="background:#a7b27a; color:#fff; font-weight:500; height:44px; border-radius:8px; border:none; font-size:0.95rem;">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- TRANSACTION MODAL --}}
@if($booking->status === 'diterima')
<div class="modal fade" id="transactionModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-0" style="border-radius:12px; overflow:hidden; max-width:380px; margin:0 auto;">
            
            {{-- HEADER: KIRI (konsisten dengan gambar) --}}
            <div class="modal-header border-0 pb-2 pt-3 px-4">
                <span style="background:#2b2b2b; color:#fff; padding:6px 14px; border-radius:8px; font-size:.85rem; font-weight:600;">
                    <i class="bi bi-credit-card-2-front me-1"></i> Payment
                </span>
            </div>

            {{-- BODY --}}
            <div class="modal-body px-4 pb-4 pt-0">
                
                @if($errors->any())
                    <div class="alert alert-danger py-2 mb-3" style="font-size:0.8rem;">
                        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger py-2 mb-3" style="font-size:0.8rem;">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('transactions.store', $booking->id) }}">
                    @csrf

                    {{-- METODE BAYAR - Dropdown dengan arrow --}}
                    <select name="metode_bayar" class="form-select mb-3" required
                            style="border:none; border-radius:8px; padding:12px 14px; font-size:0.9rem; color:#1a1a1a; appearance:none; -webkit-appearance:none; background-image:url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%2712%27 height=%2712%27 fill=%27333%27 viewBox=%270 0 16 16%27%3E%3Cpath d=%27M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z%27/%3E%3C/svg%3E'); background-repeat:no-repeat; background-position:right 12px center; background-color:#fff; padding-right:35px;">
                        <option value="" disabled selected>Choose Payment Method</option>
                        <option value="tunai">Tunai</option>
                        <option value="qris">Qris</option>
                    </select>

                    {{-- INFO CUSTOMER --}}
                    <div style="background:#3a3a3a; border-radius:8px; padding:14px 16px; font-size:0.85rem; color:#e0e0e0; display:flex; flex-direction:column; gap:8px; margin-bottom:12px;">
                        <div><strong style="color:#fff;">Username :</strong> {{ $booking->username }}</div>
                        <div><strong style="color:#fff;">Barber :</strong> {{ $booking->nama_barber ?? '-' }}</div>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <strong style="color:#fff;">Time</strong>
                            <span style="background:#1a1a1a; border:1px solid #555; border-radius:20px; padding:2px 10px; font-size:0.75rem; color:#fff;">
                                {{ \Carbon\Carbon::parse($booking->tanggal)->format('H:i') }}
                            </span>
                        </div>
                        <div>
                            <strong style="color:#fff;">Services :</strong>
                            <ul style="list-style:none; margin:4px 0 0; padding:0; font-size:0.8rem; color:#bbb;">
                                @foreach(DB::table('booking_details')
                                    ->join('services', 'booking_details.id_service', '=', 'services.id')
                                    ->where('booking_details.id_booking', $booking->id)
                                    ->select('services.nama_service', 'booking_details.harga')
                                    ->get() as $detail)
                                <li style="padding:2px 0;">• {{ $detail->nama_service }} — Rp {{ number_format($detail->harga) }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    {{-- TOTAL --}}
                    <div style="background:#fff; border-radius:8px; padding:12px 16px; color:#1a1a1a; font-weight:700; font-size:0.95rem; margin-bottom:16px;">
                        Total : Rp {{ number_format($booking->total_harga ?? 0) }}
                    </div>

                    {{-- BUTTONS --}}
                    <div class="d-flex gap-3">
                        <button type="button" class="btn flex-fill" data-bs-dismiss="modal"
                                style="background:#dc3545; color:#fff; font-weight:500; height:44px; border-radius:8px; border:none; font-size:0.95rem;">
                            Cancel
                        </button>
                        <button type="submit" class="btn flex-fill"
                                style="background:#a7b27a; color:#fff; font-weight:500; height:44px; border-radius:8px; border:none; font-size:0.95rem;">
                            Proses
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@endforeach

@endsection