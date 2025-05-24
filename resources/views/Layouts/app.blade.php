<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odyssey Clan - @yield('title')</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;600;700&family=Titillium+Web:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary: #8B0000;
            --primary-dark: #630000;
            --accent: #FFD700;
            --accent-dark: #C8AB00;
            --dark: #121212;
            --dark-gray: #1E1E1E;
            --mid-gray: #333333;
            --light-gray: #444444;
            --text: #EEEEEE;
        }
        
        body {
            background-color: var(--dark);
            color: var(--text);
            font-family: 'Titillium Web', sans-serif;
            position: relative;
        }
        
        h1, h2, h3, h4, h5, h6, .navbar-brand {
            font-family: 'Rajdhani', sans-serif;
            font-weight: 700;
        }
        
        /* Background element */
        .bg-pattern {
            position: relative;
        }

        /* Add this to prevent overflow scrolling */
        html, body {
            overflow-x: hidden;
            width: 100%;
            position: relative;
        }

        .bg-pattern::before {
            content: '';
            position: fixed; /* Change to fixed to prevent scrolling with content */
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                linear-gradient(to bottom, rgba(18, 18, 18, 0.95), rgba(18, 18, 18, 0.9)),
                url('/images/bg-pattern.png');
            background-repeat: repeat;
            transform: rotate(15deg);
            transform-origin: center center;
            z-index: -1;
            pointer-events: none;
            /* Expand beyond viewport to allow for rotation without gaps */
            width: 150%;
            height: 150%;
            margin-left: -25%;
            margin-top: -25%;
        }
        
        .bg-noise {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('/images/noise.png');
            opacity: 0.05;
            pointer-events: none;
            z-index: 0;
        }
        
        /* Navbar */
        .navbar {
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--accent);
            padding: 0.8rem 1rem;
            z-index: 100;
        }
        
        .navbar-brand {
            color: white;
            font-size: 1.6rem;
            font-weight: 700;
        }
        
        .navbar-brand span {
            color: var(--accent);
        }
        
        .nav-link {
            color: var(--text);
            font-weight: 600;
            position: relative;
            margin: 0 0.5rem;
            transition: color 0.3s ease;
        }
        
        .nav-link:hover, .nav-link:focus {
            color: var(--accent);
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--accent);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        .nav-link.active {
            color: var(--accent);
        }
        
        .nav-link.active::after {
            width: 100%;
        }
        
        /* Hero Section */
        /* Hero Section */
        .hero-section {
            position: relative;
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('/images/hero-bg.png');
            background-size: cover;
            background-position:center; /* Focus on right side */
            min-height: 700px; /* Increased height */
            display: flex;
            align-items: center;
            border-bottom: 4px solid var(--accent);
            overflow: hidden;
            background-attachment: fixed; /* Parallax effect */
        }
        
        /* Add responsive adjustments for mobile */
        @media (max-width: 767.98px) {
            .hero-section {
            min-height: 500px; /* Decreased height */
            background-position: 130% center; /* Adjust horizontal and vertical positioning on mobile */
            background-attachment: scroll; /* Disable parallax on mobile for better performance */
            }
        }
        
        .hero-content {
            position: relative;
            z-index: 10;
        }
        
        .hero-title {
            font-size: 5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.3);
            line-height: 0.9;
            letter-spacing: -1px;
        }

        .hero-title span {
            display: block;
            font-size: 7rem;
            background: linear-gradient(45deg, var(--accent) 0%, #ffffff 50%, var(--accent) 100%);
            background-size: 200% auto;
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shine 3s linear infinite;
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            font-style: italic;
            position: relative;
            display: inline-block;
        }

        .hero-subtitle::before,
        .hero-subtitle::after {
            content: '';
            height: 2px;
            width: 30px;
            background: var(--accent);
            display: inline-block;
            vertical-align: middle;
            margin: 0 10px;
        }

        .hero-btn-container {
            margin-top: 2rem;
            transform: skewX(-5deg);
        }
        
        .hero-btn {
            background-color: var(--primary);
            color: white;
            border: 2px solid var(--accent);
            padding: 0.75rem 2rem;
            font-weight: 600;
            text-transform: uppercase;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .hero-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--accent);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .hero-btn:hover::before {
            left: 0;
        }
        
        .hero-btn:hover {
            color: var(--dark);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        
        /* Cards & Sections */
        .section-title {
            position: relative;
            font-size: 2.5rem;
            color: white;
            margin-bottom: 3rem;
            text-align: center;
            text-transform: uppercase;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: var(--accent);
        }
        
        .card {
            background-color: var(--dark-gray);
            border: 1px solid var(--light-gray);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 2rem;
            overflow: hidden;
            position: relative;
        }
        
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
            border-color: var(--accent);
        }
        
        .card-highlight {
            border-color: var(--accent);
        }
        
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        
        .card-header {
            background-color: var(--primary);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            padding: 0.75rem 1.25rem;
            border-bottom: 2px solid var(--accent);
        }
        
        .card-title {
            color: var(--accent);
            font-weight: 600;
        }
        
        .card-body {
            background-color: var(--dark-gray);
            color: var(--text);
        }
        
        /* Member Cards */
        .member-card {
            background-color: var(--dark-gray);
            border: 1px solid var(--light-gray);
            border-radius: 10px;
            padding: 2rem;
            transition: all 0.3s ease;
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .member-card:hover {
            transform: translateY(-10px);
            border-color: var(--accent);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        
        .member-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 4px solid var(--accent);
            object-fit: cover;
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
        }
        
        .member-card:hover .member-avatar {
            transform: scale(1.05);
            border-width: 5px;
        }
        
        .member-name {
            color: white;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .member-rank {
            background-color: var(--primary);
            color: white;
            padding: 0.25rem 1rem;
            border-radius: 50px;
            display: inline-block;
            margin-bottom: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            border: 1px solid var(--accent);
            font-size: 0.85rem;
        }
        
        /* Footer */
        footer {
            background-color: var(--dark-gray);
            border-top: 3px solid var(--accent);
            padding: 3rem 0;
            position: relative;
        }
        
        .footer-content {
            position: relative;
            z-index: 10;
        }
        
        .footer-title {
            color: var(--accent);
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }
        
        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--mid-gray);
            color: white;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background-color: var(--accent);
            color: var(--dark);
            transform: translateY(-3px);
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.8rem;
        }
        
        .footer-links a {
            color: var(--text);
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        .footer-links a:hover {
            color: var(--accent);
            transform: translateX(5px);
        }
        
        .copyright {
            color: #888;
            text-align: center;
            margin-top: 3rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--light-gray);
        }
        
        /* Utils */
        .text-accent {
            color: var(--accent) !important;
        }
        
        /* Form elements */
        .form-label {
            color: var(--text);
            font-weight: 500;
        }
        
        .form-text {
            color: var(--text) !important;
            opacity: 0.8;
        }
        
        .form-control, .form-select {
            background-color: var(--mid-gray);
            color: var(--text);
            border-color: var(--light-gray);
        }
        
        .form-control:focus, .form-select:focus {
            background-color: var(--mid-gray);
            color: var(--text);
            border-color: var(--accent);
            box-shadow: 0 0 0 0.25rem rgba(255, 215, 0, 0.25);
        }
        
        /* Table styles */
        .table-dark {
            --bs-table-bg: var(--dark-gray);
            --bs-table-color: var(--text);
            color: var(--text);
        }
        
        /* Accordion styles */
        .accordion-button {
            color: var(--text);
            background-color: var(--dark-gray);
        }
        
        .accordion-button:not(.collapsed) {
            color: var(--accent);
            background-color: var(--mid-gray);
        }
        
        .accordion-button::after {
            filter: brightness(3);
        }
        
        .accordion-button:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 0.25rem rgba(255, 215, 0, 0.25);
        }
        
        .accordion-body {
            background-color: var(--dark-gray);
            color: var(--text);
        }
        
        /* Modal styles */
        .modal {
            z-index: 9999 !important;
        }
        
        .modal-backdrop {
            z-index: 9998 !important;
            background-color: rgba(0, 0, 0, 0.8);
        }
        
        .modal-content {
            background-color: var(--dark-gray);
            color: var(--text);
            border: 2px solid var(--accent);
            border-radius: 10px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.8);
            position: relative;
            z-index: 10000;
        }
        
        .modal-header {
            border-bottom-color: var(--accent);
            background-color: var(--dark-gray);
            border-radius: 8px 8px 0 0;
        }
        
        .modal-footer {
            border-top-color: var(--accent);
            background-color: var(--dark-gray);
            border-radius: 0 0 8px 8px;
        }
        
        .modal-dialog {
            pointer-events: auto;
            position: relative;
            z-index: 10001;
        }
        
        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
            transform: translate(0, -50px);
        }
        
        .modal.show .modal-dialog {
            transform: none;
        }
        
        /* Fix for modal backdrop clicking through */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
        }
        
        /* Ensure modal is properly positioned */
        .modal.show {
            display: block !important;
        }
        
        /* Prevent body scroll when modal is open */
        body.modal-open {
            overflow: hidden;
        }
        
        .modal-backdrop.show {
            opacity: 1;
        }
        
        /* Prevent background elements from interfering with modals */
        body.modal-open {
            overflow: hidden;
        }
        
        body.modal-open .bg-pattern::before,
        body.modal-open .bg-noise {
            z-index: -2;
        }
        
        /* Ensure modal buttons work properly */
        .modal .btn {
            pointer-events: auto;
            position: relative;
            z-index: 1;
        }
        
        .table-warning {
            color: var(--dark) !important;
        }
        
        .table-hover > tbody > tr:hover > * {
            color: var(--text);
            background-color: var(--mid-gray);
        }
        
        .table-warning.table-hover > tbody > tr:hover > * {
            color: var(--dark) !important;
        }
        
        /* Alert styles */
        .alert-success {
            color: #0f5132;
            background-color: #d1e7dd;
        }
        
        .alert-warning {
            color: #664d03;
            background-color: #fff3cd;
        }
        
        .alert-danger {
            color: #842029;
            background-color: #f8d7da;
        }
        
        .alert-info {
            color: #055160;
            background-color: #cff4fc;
        }
        
        .btn-primary {
            background-color: var(--primary);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .btn-accent {
            background-color: var(--accent);
            border: none;
            color: var(--dark);
            transition: all 0.3s ease;
        }
        
        .btn-accent:hover {
            background-color: var(--accent-dark);
            transform: translateY(-2px);
        }
        
        .btn-outline {
            background-color: transparent;
            border: 2px solid var(--accent);
            color: var(--accent);
            transition: all 0.3s ease;
        }
        
        .btn-outline:hover {
            background-color: var(--accent);
            color: var(--dark);
            transform: translateY(-2px);
        }
        
        .btn-purple {
            background-color: #6441a5;
            border: none;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-purple:hover {
            background-color: #5a3a8b;
            color: white;
            transform: translateY(-2px);
        }
        
        .text-purple {
            color: #6441a5 !important;
        }
        
        /* Animations */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .floating {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes shine {
            to {
                background-position: 200% center;
            }
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.3; }
            100% { opacity: 1; }
        }
        
        /* Media Queries */
        @media (max-width: 991.98px) {
            .hero-title {
                font-size: 4rem;
            }
            
            .hero-title span {
                font-size: 5.5rem;
            }
        }
        
        @media (max-width: 767.98px) {
            .hero-title {
                font-size: 3rem;
            }
            
            .hero-title span {
                font-size: 4rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 575.98px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-title span {
                font-size: 3rem;
            }
            
            .hero-subtitle::before,
            .hero-subtitle::after {
                width: 15px;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
            }
        }
    </style>
    @yield('extra-css')
</head>
<body class="bg-pattern">
    <div class="bg-noise"></div>
    
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="/images/logo.png" alt="Odyssey" height="40" class="me-2">
                <span>ODYSSEY</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('members*') ? 'active' : '' }}" href="/members">Members</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('events*') ? 'active' : '' }}" href="/events">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('leaderboard*') ? 'active' : '' }}" href="/leaderboard">Leaderboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('gallery*') ? 'active' : '' }}" href="/gallery">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('join*') ? 'active' : '' }}" href="/join">Join Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://exclaim.gg/store/odyssey-clan" target="_blank">
                            <i class="fas fa-shopping-cart me-1"></i> Merch
                        </a>
                    </li>
                    @auth
                        @if(Auth::user()->isAdmin())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->is('admin*') ? 'active' : '' }}" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-shield"></i> Admin
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="adminDropdown">
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.verification.index') }}"><i class="fas fa-user-check me-2"></i> Verifications</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.members.index') }}"><i class="fas fa-users me-2"></i> Members</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.admins.create') }}"><i class="fas fa-user-plus me-2"></i> Add Admin</a></li>
                            </ul>
                        </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" 
                                     class="rounded-circle me-2" style="width: 24px; height: 24px; object-fit: cover;">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-edit me-2"></i> Edit Profile</a></li>
                                
                                @if(Auth::user()->isAdmin())
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-success" href="{{ route('admin.dashboard') }}"><i class="fas fa-user-shield me-2"></i> Admin Panel</a></li>
                                @endif
                                
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('login*') ? 'active' : '' }}" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('register*') ? 'active' : '' }}" href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i> Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main style="margin-top: 76px;">
        @yield('content')
    </main>

    <footer>
        <div class="container footer-content">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h4 class="footer-title">ODYSSEY CLAN</h4>
                    <p class="mb-3">A brotherhood of elite gamers, forged in the heat of battle and bound by honor.</p>
                    <div class="social-links">
                        <a href="https://discord.gg/odyssey" target="_blank"><i class="fab fa-discord"></i></a>
                        <a href="https://twitter.com/odysseyclan" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="https://youtube.com/odysseyclan" target="_blank"><i class="fab fa-youtube"></i></a>
                        <a href="https://twitch.tv/odysseyclan" target="_blank"><i class="fab fa-twitch"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h4 class="footer-title">QUICK LINKS</h4>
                    <ul class="footer-links">
                        <li><a href="/about"><i class="fas fa-chevron-right me-2"></i> About Us</a></li>
                        <li><a href="/events"><i class="fas fa-chevron-right me-2"></i> Upcoming Events</a></li>
                        <li><a href="/leaderboard"><i class="fas fa-chevron-right me-2"></i> Leaderboard</a></li>
                        <li><a href="/gallery"><i class="fas fa-chevron-right me-2"></i> Media Gallery</a></li>
                        <li><a href="/join"><i class="fas fa-chevron-right me-2"></i> Join Odyssey</a></li>
                        <li><a href="https://exclaim.gg/store/odyssey-clan" target="_blank"><i class="fas fa-shopping-cart me-2"></i> Official Merch</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h4 class="footer-title">JOIN OUR DISCORD</h4>
                    <p class="mb-3">Connect with our community, participate in events, and stay updated with clan news.</p>
                    <a href="https://discord.gg/odyssey" class="btn btn-accent" target="_blank">
                        <i class="fab fa-discord me-2"></i> Join Discord Server
                    </a>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; {{ date('Y') }} Odyssey Clan. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                offset: 100,
                once: true
            });
            
            // Let Bootstrap handle modals natively
        });
    </script>
    @yield('extra-js')
</body>
</html>