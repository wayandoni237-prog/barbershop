
@extends('layouts.appadmin')

@section('title', 'Admin Panel · Data Services')

@section('page-title', 'Transaction process')

@push('styles')
<link rel="stylesheet" href="{{asset('css/admin/users/index.css')}}">
@endpush

@section('content')

<!-- panel atas breadcrumb -->
<div class="breadcrumb-panel">
    <i style="color: black;" class="bi bi-house-door"></i> Panel / <span style="font-weight:500; color:black;">Transaction process</span>
</div>

<!-- CARD UTAMA -->
<div class="container-fluid p-0 mt-4">

    <div class="user-card">

        <div class="user-header">
            <h5>⚙️ Transaction process</h5>
        </div>

        @if(session('success'))
        <div class="user-header">
            <p class="alert alert-success">{{session('success')}}</p>
        </div>
        @endif

        @if(session('error'))
        <div class="user-header">
            <p class="alert alert-danger">{{session('error')}}</p>
        </div>
        @endif
<div class="table-wrapper">
        <table class="table table-borderless user-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Customer</th>
                    <th>Barber</th>
                    <th>Cashier</th>
                    <th>Booking</th>
                    <th>Date</th>
                    <th>payment method</th>
                    <th>Total</th>
                    <th>Service status</th>
                    <th>Payment status</th>
                    <th>Final</th>
                </tr>
            </thead>

            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$transaction->customer->user->nama ?? '-'}}</td>
                    <td>{{$transaction->barber->nama ?? '-'}}</td>
                    <td>{{$transaction->kasir->user->nama ?? '-'}}</td>
                    <td>{{$transaction->booking->id ?? '-'}}</td>
                    <td>{{$transaction->tanggal->format('j/n/Y·H:i')}}</td>
                    <td>{{$transaction->metode_bayar}}</td>
                    <td>Rp {{number_format($transaction->total,0,',','.' )}}</td>
                    <td>
                        @if($transaction->status_layanan == 'proses')
                        <span class="badge bg-warning">Process</span>
                        @else
                        <span class="badge bg-success">Finish</span>
                        @endif
                    </td>
                    <td>
                        @if($transaction->status_pembayaran == 'pending')
                        <span class="badge bg-danger">Pending</span>
                        @else
                        <span class="badge bg-success">Paid off</span>
                        @endif
                    </td>
                    <td>
                        @if($transaction->status_layanan == 'proses')
                        <div class="d-flex gap-2">
                            <form action="{{ route('transactions.complete', $transaction->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-success btn-sm">
                                    Finish
                                </button>
                            </form>
                        @else
                            <form action="{{ route('transactions.complete', $transaction->id) }}" method="POST">
                                @csrf
                                <button style="background-color: #2D2D2D;" disabled class="btn btn-secondary btn-sm text-white">
                                    Done
                                </button>
                            </form>
                        </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>

    </div>

</div>

@endsection