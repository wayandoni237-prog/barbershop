<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin/users/create.css') }}">
</head>
<body>

<div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="container-box">
        <div style="text-align:center; color:#fff; font-size:1rem; font-weight:700; margin-bottom:22px;">
            Edit Data Booking
        </div>

        @if($errors->any())
            <div style="background:#c0392b; color:#fff; border-radius:6px; padding:8px 12px; margin-bottom:14px; font-size:0.82rem;">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif

        <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Date --}}
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                <input type="date" name="tanggal_booking"
                       class="form-control custom-input"
                       value="{{ \Carbon\Carbon::parse($booking->tanggal)->format('Y-m-d') }}"
                       required>
            </div>

            {{-- Jam --}}
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="bi bi-clock"></i></span>
                <select name="jam_booking" class="form-select custom-input" required>
                    <option value="" disabled>-- Select Hour --</option>
                    @foreach(['10:00','11:00','13:00','14:00','15:00','16:00','19:00'] as $jam)
                        <option value="{{ $jam }}"
                            {{ \Carbon\Carbon::parse($booking->tanggal)->format('H:i') === $jam ? 'selected' : '' }}>
                            {{ $jam }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Barber --}}
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                <select name="id_barber" class="form-select custom-input">
                    <option value="">-- Pilih Barber --</option>
                    @foreach($barbers as $barber)
                        <option value="{{ $barber->id }}"
                            {{ $booking->id_barber == $barber->id ? 'selected' : '' }}>
                            {{ $barber->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Status --}}
            <div class="input-group mb-4">
                <span class="input-group-text"><i class="bi bi-flag"></i></span>
                <select name="status" class="form-select custom-input">
                    <option value="menunggu" {{ $booking->status === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="diterima" {{ $booking->status === 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="batal"    {{ $booking->status === 'batal'    ? 'selected' : '' }}>Batal</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div class="d-flex gap-3">
                <a href="{{ route('bookings.index') }}"
                   class="btn btn-cancel rounded d-flex align-items-center justify-content-center text-decoration-none">
                    Cancel
                </a>
                <button type="submit" class="btn btn-save rounded">Save</button>
            </div>

        </form>
    </div>
</div>

</body>
</html>