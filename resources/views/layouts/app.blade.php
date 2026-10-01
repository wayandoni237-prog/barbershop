<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Barbershop')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}">
    
    @stack('styles')
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#home">
                <img src="{{asset('images/Babershop (4).png')}}" alt="Logo" width="130">
            </a>
            
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="/user/dashboard#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/user/dashboard#service">Service</a></li>
                    <li class="nav-item"><a class="nav-link" href="/user/dashboard#gallery">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="/user/dashboard#review">Review</a></li>
                </ul>
                
                <ul class="navbar-nav align-items-center">
                    @auth
                        <li class="nav-user d-none d-md-block me-3">
                            Halo, <strong>{{ Auth::user()->username }}</strong>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn-nav btn-danger">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}" class="btn-nav btn-outline-light">Login</a>
                            <a href="{{ route('register') }}" class="btn-nav btn-light">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>@yield('content')</main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                
                <!-- Brand & Service -->
                <div class="col-md-4 col-6">
                    <div class="footer-brand">
                        <a class="navbar-brand" href="#home">
                            <img src="{{asset('images/Babershop (4).png')}}" alt="Logo" width="130">
                        </a>
                    </div>
                    
                    <div class="footer-service d-flex flex-column align-items-start">
                        <h4>Service</h4>
                        <ul class="d-flex flex-column align-items-start">
                            <li><a href="#service">basic haircut</a></li>
                            <li><a href="#service">premium haircut</a></li>
                            <li><a href="#service">highlight / bleaching</a></li>
                            <li><a href="#service">hair styling</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Media Sosial -->
                <div class="col-md-4 col-6">
                    <div class="footer-contact">
                        <h4>Contact Us</h4>
                        <small>Social media</small>
                        
                        <div class="contact-item">
                            <i class="bi bi-telephone-fill"></i>
                            <a href="https://wa.me/62881037303437" target="_blank">+62 881-0373-03437</a>
                        </div>
                        
                        <div class="contact-item">
                            <i class="bi bi-instagram"></i>
                            <a href="https://instagram.com/barbershop.id" target="_blank">barbershop.id</a>
                        </div>
                        
                        <div class="contact-item">
                            <i class="bi bi-twitter"></i>
                            <a href="https://twitter.com/barbershop.id" target="_blank">barbershop.id</a>
                        </div>
                        
                        <div class="contact-item">
                            <i class="bi bi-tiktok"></i>
                            <a href="https://tiktok.com/@barbershop.id" target="_blank">barbershop.id</a>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="col-md-4 col-12">
                    <div class="footer-contact mt-4 mt-md-0">
                        <h4>Contact</h4>
                        <small>&nbsp;</small>
                        
                        <div class="contact-item">
                            <i class="bi bi-telephone"></i>
                            <a href="tel:+6281999581880">+62819-9958-1880</a>
                        </div>
                        
                        <div class="contact-item">
                            <i class="bi bi-envelope"></i>
                            <a href="mailto:barbershopid@gmail.com">barbershopid@gmail.com</a>
                        </div>
                        
                        <div class="contact-item">
                            <i class="bi bi-geo-alt"></i>
                            <span>Jl.Teuku Umar Barat, Gn Lumut</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="footer-bottom">
                <p>&copy; 2026 BarberShop</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>