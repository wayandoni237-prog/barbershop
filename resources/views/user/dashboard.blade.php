@push('styles')
<link rel="stylesheet" href="{{asset('css/user/user_dashboard.css')}}">
@endpush
@extends('layouts.app')

@section('title', 'Barbershop - Premium Haircut')



@section('content')

<!--HOME-->
<section id="home">
    <h1 class="hero-title">Barbershop</h1>
    <p class="hero-subtitle">Professional and Affordable</p>
    
    <a href="/user/booking" class="btn btn-booking">Booking Now</a>

    <div class="hero-info">
        <div class="hero-info-item">
            <i class="bi bi-telephone"></i>
            <small>Contact</small>
            <p>+62 857-3854-0804</p>
        </div>
        <div class="hero-info-item">
            <i class="bi bi-scissors"></i>
            <small>Service</small>
            <p>Haircut & Hairstyle</p>
        </div>
        <div class="hero-info-item">
            <i class="bi bi-geo-alt"></i>
            <small>Location</small>
            <p>Jl. Teuku Umar Barat</p>
        </div>
    </div>
</section>

<!--SERVICE-->
<section id="service">
    <div class="section-title">
        <h2>Our Service</h2>
        <p>Professional and Affordable</p>
    </div>

    @php
        $icons = ['bi-scissors', 'bi-award', 'bi-droplet', 'bi-wind'];
    @endphp

    <div class="service-grid">
        @foreach($services as $i => $service)
        <div class="service-card">
            <div class="service-icon">
                <i class="bi {{ $icons[$i] ?? 'bi-scissors' }}"></i>
            </div>
            <h4>{{ $service->nama_service }}</h4>
            <div class="price">Rp {{ number_format($service->harga, 0, ',', '.') }}</div>
            <div class="time"><i class="bi bi-clock"></i> {{ $service->estimasi_menit }} Minute</div>
            <!-- <p>{{ $service->deskripsi }}</p> -->
        </div>
        @endforeach
    </div>
</section>

<!--GALLERY-->
<section id="gallery">
    <div class="section-title">
        <h2>Our Gallery</h2>
        <p>Portfolio of Our Work</p>
    </div>

    <div class="gallery-grid">
        <div class="gallery-item">
            <img src="{{ asset('images/gallery 1.png') }}" alt="Haircut 1">
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/gallery 2.png') }}" alt="Barbershop">
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/gallery 3.png') }}" alt="Haircut 2">
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/gallery 4.png') }}" alt="Beard">
        </div>
        <div class="gallery-item">
            <img src="{{ asset('images/gallery 5.png') }}" alt="Interior">
        </div>
        <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1622286342621-4bd786c2447c?w=400" alt="Styling">
        </div>
    </div>
</section>

<!--REVIEW-->
<section id="review">
    <div class="section-title">
        <h2>Review</h2>
        <p>What Our Customers Say</p>
    </div>

    <div class="review-grid">
        <div class="review-card">
            <div class="review-header">
                <div class="review-avatar">B</div>
                <div class="review-meta">
                    <h5>Budi</h5>
                    <div class="stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                </div>
            </div>
            <p>"Pelayanan sangat bagus, potongan rambut rapi dan barbernya ramah. Tempatnya juga nyaman dan bersih."</p>
        </div>

        <div class="review-card">
            <div class="review-header">
                <div class="review-avatar">D</div>
                <div class="review-meta">
                    <h5>Dedekun</h5>
                    <div class="stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i></div>
                </div>
            </div>
            <p>"Sudah langganan disini, hasilnya selalu konsisten. Harga terjangkau untuk kualitas yang diberikan."</p>
        </div>

        <div class="review-card">
            <div class="review-header">
                <div class="review-avatar">B</div>
                <div class="review-meta">
                    <h5>Batubara</h5>
                    <div class="stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                </div>
            </div>
            <p>"Recommended banget! Barbernya profesional dan ngerti banget sama style yang saya mau."</p>
        </div>
    </div>
</section>

@endsection