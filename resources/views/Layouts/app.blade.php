<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odyssey Clan - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --spartan-red: #8B0000;
            --spartan-gold: #FFD700;
            --dark-grey: #2C2C2C;
        }
        
        body {
            background-color: var(--dark-grey);
            color: #fff;
            font-family: 'Helvetica Neue', sans-serif;
        }
        
        .navbar {
            background-color: var(--spartan-red);
            border-bottom: 2px solid var(--spartan-gold);
        }
        
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('/images/spartan-bg.jpg');
            background-size: cover;
            background-position: center;
            min-height: 500px;
        }
        
        .member-card {
            background-color: rgba(44, 44, 44, 0.9);
            border: 1px solid var(--spartan-gold);
            transition: transform 0.3s ease;
        }
        
        .member-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="/images/logo.jpg" alt="Odyssey" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/members">Members</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/achievements">Achievements</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/join">Join Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Odyssey Clan</h5>
                    <p>Honor. Strength. Unity.</p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="https://discord.gg/odyssey" class="text-light me-3">
                        <i class="fab fa-discord"></i> Join our Discord
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>