@extends('layouts.appadmin')

@section('title', 'Admin Panel · Report data')
@section('page-title', 'Report data')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/users/index.css') }}">
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 0px;
    }

    th,
    td {
        padding: 8px;
        text-align: center;
    }

    .header-logic {
        background: #2D2D2D;
        width: 100%;
        color: white;
        margin: 0px;
    }

    .schedule-input {
        width: 100%;
        background: rgb(245, 245, 245, 0.20);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        padding: 12px 16px;
        margin: 12px 0px;
        color: #fff;
        font-size: 0.9rem;
        transition: border-color 0.3s;
    }

    .total {
        position: relative;
        bottom: 1.5rem;
        margin: 0px;
    }

    .inputBulan {
        width: 25%;
        background: #2D2D2D;
        color: white;
    }

    @media print {

        button,
        form {
            display: none;
        }
    }
</style>
@endpush

@section('content')

<div class="breadcrumb-panel">
    <i class="bi bi-house-door"></i> Panel / <span style="font-weight:500; color:black;">Report data</span>
</div>

<div class="container-fluid p-0 mt-4">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="container-fluid container-head p-0 m-0 d-flex gap-3 justify-content-start">
        <div class="header-logic p-4 gap-2 mb-5 rounded d-flex flex-column align-items-start">
            <h5 class="mb-2">Daily booking</h5>

            <!-- FILTER TANGGAL -->
            <form class="mb-2" method="GET">
                <label><strong>Choose first date - last date:</strong></label>
                <p class="mb-0 mt-3">
                    {{ request('tanggal_awal') 
                      ? \Carbon\Carbon::parse(request('tanggal_awal'))->translatedFormat('l') 
                      : '' 
                    }}
                </p>
                <input class="schedule-input mt-0" type="date" name="tanggal_awal" value="{{ request('tanggal_awal') ? \Carbon\Carbon::parse(request('tanggal_awal'))->format('Y-m-d') : date('Y-m-01') }}" onchange="this.form.submit()">
                <p class="mb-0 mt-1">
                    {{ request('tanggal_akhir') 
                      ? \Carbon\Carbon::parse(request('tanggal_akhir'))->translatedFormat('l') 
                      : '' 
                    }}
                </p>
                <input class="schedule-input mt-0" type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') ? \Carbon\Carbon::parse(request('tanggal_akhir'))->format('Y-m-d') : date('Y-m-t') }}" onchange="this.form.submit()">
            </form>

            <button class="mt-2 btn-edit rounded" onclick="printLaporan()">Print</button>
        </div>

        <div class="header-logic p-4 gap-2 mb-5 rounded d-flex flex-column align-items-center">
            <i style="font-size: 5rem;" class="bi bi-people-fill m-0"></i>
            <p class="total">Total Customer:</p>
            <h3 class="mt-0" style="font-size: 3.8rem;"> {{ $totalCustomer }}</h3>
        </div>
    </div>



    <div class="user-card">
        <div class="user-header">
            <h5 class="mb-0">Report data</h5>
        </div>

    <div class="table-wrapper">
        <table class="table table-borderless user-table mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Customer's Name</th>
                    <th>Service</th>
                    <th>Price</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @if($data->isEmpty())
                <tr>
                    <td colspan="4">There's no data yet</td>
                </tr>
                @endif
                @foreach($data as $i => $item)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $item->customer->user->nama ?? '-' }}</td>
                    <td>
                        @forelse($item->details as $d)
                        {{ $d->service->nama_service ?? '-' }}<br>
                        @empty
                        -
                        @endforelse
                    </td>
                    <td>
                        @forelse($item->details as $d)
                        Rp {{ number_format($d->service->harga ?? 0, 0, ',', '.') }}<br>
                        @empty
                        -
                        @endforelse
                    </td>
                    <td>{{ $item->created_at->translatedFormat( 'l, d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

        <div>
            <h2 class="mt-5 mb-0"><strong>Daily income</strong></h2>
            <form class="mt-2 mb-2" method="GET">
                <select class="inputBulan" name="bulan" class="form-control" onchange="this.form.submit()">
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                        </option>
                        @endfor
                </select>
            </form>
            <canvas class="mt-0" id="incomeChart" height="100"></canvas>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.1/dist/chart.umd.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const labels = <?= json_encode($labels) ?>;
                const totals = <?= json_encode($totals) ?>;

                const ctx = document.getElementById('incomeChart').getContext('2d');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Income Harian',
                            data: totals,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                }
                            }
                        }
                    }
                });

            });
        </script>

    </div>

</div>

<script>
    function printLaporan() {
        let tanggalAwal = document.querySelector('input[name=tanggal_awal]').value;
        let tanggalAkhir = document.querySelector('input[name=tanggal_akhir]').value;

        if (!tanggalAwal || !tanggalAkhir) {
            alert('Pilih tanggal dulu!');
            return;
        }

        window.open(`/admin/laporan/print?tanggal_awal=${tanggalAwal}&tanggal_akhir=${tanggalAkhir}`, '_blank');
    }
</script>




@endsection