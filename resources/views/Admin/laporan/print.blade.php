<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Print Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: Arial;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        p {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #3E3B3B;
            color: white;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .total-income {
            background-color: #3E3B3B;
            color: white;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        td {
            color: #3E3B3B;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        .gariss {
            width: 60%;
            border-top: 3px solid black;
            border-bottom: none;
            border-left: none;
            border-right: none;
        }

        @media print {
            body {
                margin: 0;
            }
        }
    </style>
</head>

<body class="pt-5">
    <div class="container-md">


        <div class="d-flex flex-column text-center align-items-center mb-3">
            <h1 class="m-0"><strong>Barbershop Report</strong></h1>
            <p class="m-0"><strong>Laporan Booking Harian</strong></p>
        </div>
        <center>
            <div class="mb-4 gariss">
            </div>
        </center>


        <p class="mb-1">
            Date:
            {{ $tanggalAwal->translatedFormat('l, d/m/Y') }}
            -
            {{ $tanggalAkhir->translatedFormat('l, d/m/Y') }}
        </p>
        <p>Total Customer: {{ $totalCustomer }}</p>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Customer</th>
                    <th>Service</th>
                    <th>Price</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @if($data->isEmpty())
                <tr>
                    <td colspan="4">Tidak ada data</td>
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
                    <td class="text-start">
                        @forelse($item->details as $d)
                        Rp {{ number_format($d->service->harga ?? 0, 0, ',', '.') }}<br>
                        @empty
                        -
                        @endforelse
                    </td>
                    <td style="text-align: start;">
                        Date: {{ $item->tanggal->translatedFormat('l, d/m/Y') }} <br>
                        Hour: {{$item->tanggal->format('H:i')}}
                    </td>
                </tr>
                @endforeach

                <tr class="total-row">
                    <td class="total-income" colspan="3" class="text-start fw-bold">Total Income</td>
                    <td class="total-income tex" colspan="2" class="text-start fw-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>

</body>

</html>