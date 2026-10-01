@extends('layouts.app')

@section('title', 'Booking - Barbershop')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/user/booking.css') }}">
@endpush

@section('content')
<div class="booking-page">
    <div class="booking-container">

        <h1 class="page-title">Select a service</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                @foreach($errors->all() as $err)<div>{{ $err }}</div>@endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('user.booking.store') }}" method="POST">
        @csrf

        <div class="booking-wrapper">

            {{-- LEFT --}}
            <div class="left-column">

                {{-- SERVICE --}}
                <div class="service-section">
                    <span class="section-label">Service Haircut and Hairstyle</span>
                    <div class="service-list">
                        @foreach($services as $i => $service)
                        <label class="service-item">
                            <input type="radio" name="id_service" value="{{ $service->id }}"
                                {{ old('id_service', $services->first()->id) == $service->id ? 'checked' : '' }}
                                required>
                            <div class="service-number">{{ $i + 1 }}</div>
                            <div class="service-info">
                                <h4>{{ $service->nama_service }}</h4>
                                <div class="service-price">
                                    <i class="bi bi-cash-stack"></i>
                                    <span>Price : Rp {{ number_format($service->harga, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <i class="bi bi-chevron-right service-arrow"></i>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- BARBER --}}
                <div class="barber-section">
                    <span class="section-label">Barber Profile</span>
                    <div class="barber-grid">
                        @foreach($barbers as $i => $barber)
                        <label class="barber-card">
                            <input type="radio" name="id_barber" value="{{ $barber->id }}"
                                {{ old('id_barber', $barbers->first()->id) == $barber->id ? 'checked' : '' }}>
                            <div class="barber-avatar">
                                <img id="foto_barber" src="{{asset('storage/'. $barber->image)}}" alt="Foto Barber">
                            </div>
                            <div class="barber-overlay">
                                <div class="barber-name">{{ $barber->nama }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- RIGHT --}}
            <div class="right-column">
                <div class="form-section">
                    <span class="form-label">Filling Form</span>

                    <div class="form-group">
                        <label class="schedule-label">Date</label>
                        <input type="date" name="tanggal_booking"
                               class="schedule-input"
                               min="{{ date('Y-m-d') }}"
                               value="{{ old('tanggal_booking') }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label class="schedule-label">Hour</label>
                        <select name="jam_booking" class="schedule-input" required>
                            <option value="" disabled {{ old('jam_booking') ? '' : 'selected' }}>-- Select Hour --</option>
                            @foreach(['10:00','11:00','13:00','14:00','15:00','16:00','19:00'] as $jam)
                            <option value="{{ $jam }}" {{ old('jam_booking') === $jam ? 'selected' : '' }}>{{ $jam }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="confirm-btn">Confirm Booking</button>
                </div>
            </div>

        </div>
        </form>

    </div>
</div>
@endsection