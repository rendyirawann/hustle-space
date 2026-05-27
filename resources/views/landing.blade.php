<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hustle Space Photobooth - SaaS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/hustle/favico.png') }}">
    <style>
        :root {
            --primary: #5544FF;
            --primary-hover: #4433DD;
            --primary-light: #F0F0FF;
            --bg-color: #F8F9FA;
            --text-main: #1A1A24;
            --text-muted: #6B7280;
            --card-bg: #FFFFFF;
            --border-color: #E5E7EB;
        }

        html.theme-dark {
            --primary-light: #2A2D43;
            --bg-color: #0B0F19;
            --text-main: #F3F4F6;
            --text-muted: #9CA3AF;
            --card-bg: #000000;
            --border-color: #2D334A;
        }

        .img-dark { display: none; }
        html.theme-dark .img-light { display: none; }
        html.theme-dark .img-dark { display: block; }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        /* Page Loader */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #000000;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease-out, visibility 0.5s ease-out;
            opacity: 1;
            visibility: visible;
        }

        .page-loader.fade-out {
            opacity: 0;
            visibility: hidden;
        }

        .page-loader img {
            width: 150px; /* Adjust size based on logo actual dimensions */
            object-fit: contain;
            animation: pulse 1.5s infinite alternate;
        }

        @keyframes pulse {
            0% { transform: scale(0.9); opacity: 0.8; }
            100% { transform: scale(1.1); opacity: 1; }
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 5%;
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-main);
            text-decoration: none;
        }

        .logo-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--primary), #8B5CF6);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        
        .logo span {
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .nav-links {
            display: flex;
            align-items: center;
        }

        .nav-links a {
            margin-left: 2rem;
            text-decoration: none;
            color: var(--text-main);
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .btn {
            padding: 0.6rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .theme-toggle {
            background: transparent;
            border: none;
            color: var(--text-main);
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0.5rem;
            margin-left: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: background 0.3s;
        }

        .theme-toggle:hover {
            background: var(--primary-light);
        }

        .btn-outline {
            border: 1px solid var(--border-color);
            background: transparent;
            color: var(--text-main);
        }

        .btn-outline:hover {
            background: var(--primary-light);
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 6px rgba(85, 68, 255, 0.2);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(85, 68, 255, 0.3);
        }

        /* Hero Section */
        .hero {
            padding: 6rem 5%;
            text-align: center;
            background: linear-gradient(to bottom, var(--primary-light), var(--bg-color));
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
            color: var(--text-main);
        }
        
        .hero h1 span {
            color: var(--primary);
        }

        .hero p {
            font-size: 1.25rem;
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto 2.5rem;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        /* Features */
        .features {
            padding: 5rem 5%;
            background: var(--card-bg);
        }

        .section-title {
            text-align: center;
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 3rem;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            padding: 2.5rem;
            border-radius: 16px;
            background: var(--bg-color);
            border: 1px solid var(--border-color);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .feature-card h3 {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }

        .feature-card p {
            color: var(--text-muted);
        }

        /* Pricing */
        .pricing {
            padding: 5rem 5%;
            background: var(--bg-color);
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1000px;
            margin: 0 auto;
        }

        .pricing-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 3rem 2rem;
            border: 1px solid var(--border-color);
            text-align: center;
            position: relative;
            transition: transform 0.3s ease;
        }

        .pricing-card:hover {
            transform: translateY(-5px);
        }

        .pricing-card.popular {
            border: 2px solid var(--primary);
            box-shadow: 0 15px 30px rgba(85, 68, 255, 0.1);
        }
        
        .popular-badge {
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--primary);
            color: white;
            padding: 0.25rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .pricing-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 1rem;
        }

        .pricing-price {
            font-size: 3rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 0.5rem;
        }

        .pricing-price span {
            font-size: 1rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .pricing-features {
            list-style: none;
            margin: 2rem 0;
            text-align: left;
        }

        .pricing-features li {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-main);
        }

        .pricing-features li::before {
            content: '✓';
            color: var(--primary);
            font-weight: bold;
        }

        .pricing-card .btn {
            width: 100%;
            display: block;
            padding: 0.8rem;
        }

        /* Footer */
        footer {
            padding: 3rem 5%;
            background: var(--card-bg);
            border-top: 1px solid var(--border-color);
            text-align: center;
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        /* Mobile Hamburger */
        .hamburger {
            display: none;
            flex-direction: column;
            gap: 6px;
            cursor: pointer;
            background: none;
            border: none;
            padding: 5px;
            margin-left: auto;
            z-index: 1001;
        }
        .hamburger span {
            width: 30px;
            height: 3px;
            background-color: var(--text-main);
            border-radius: 3px;
            transition: all 0.3s ease;
        }
        
        .hamburger.active span:nth-child(1) {
            transform: translateY(9px) rotate(45deg);
        }
        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }
        .hamburger.active span:nth-child(3) {
            transform: translateY(-9px) rotate(-45deg);
        }

        @media (max-width: 768px) {
            .hamburger {
                display: flex;
            }
            .nav-links {
                position: fixed;
                top: 70px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 70px);
                background-color: var(--card-bg);
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 2rem;
                transition: left 0.3s ease;
                border-top: 1px solid var(--border-color);
            }
            .nav-links.active {
                left: 0;
            }
            .nav-links .btn {
                margin-left: 0 !important;
                width: 80%;
                text-align: center;
            }
            .hero {
                padding: 8rem 5% 4rem;
            }
            .hero h1 {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <script>
        // Check local storage and apply theme immediately to prevent flash
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('theme-dark');
        }
    </script>
    
    <!-- Page Loader -->
    <div class="page-loader" id="pageLoader">
        <img class="img-light" src="{{ asset('assets/hustle/logo-loading-white.png') }}" alt="Loading...">
        <img class="img-dark" src="{{ asset('assets/hustle/logo-loading.png') }}" alt="Loading...">
    </div>

    <!-- Navbar -->
    <nav class="navbar">
        <a href="/" class="logo">
            <img class="img-light" src="{{ asset('assets/hustle/hustle-space-logo-white.png') }}" alt="HustleSpace Logo" style="height: 40px;">
            <img class="img-dark" src="{{ asset('assets/hustle/hustle-space-logo.png') }}" alt="HustleSpace Logo" style="height: 40px;">
        </a>
        
        <button class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="nav-links" id="navLinks">
            <a href="#features" class="nav-item">Features</a>
            <a href="#pricing" class="nav-item">Pricing</a>
            <a href="{{ route('gallery.index') }}" class="nav-item">Moments</a>
            <button id="themeToggle" class="theme-toggle">
                <span class="icon-light">🌙</span>
            </button>
            <a href="{{ url('/hustle-posed') }}" class="btn btn-outline nav-item" style="margin-left: 1.5rem;">Coba Demo</a>
            <a href="{{ url('/hustle-posed/login') }}" class="btn btn-primary nav-item" style="margin-left: 0.5rem;">Login</a>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <h1>Bawa Pengalaman Photobooth<br>ke <span>Layar Anda.</span></h1>
        <p>Platform photobooth SaaS pertama yang memungkinkan Anda membuat, menyesuaikan, dan membagikan momen berharga di berbagai acara dengan frame custom.</p>
        <div class="hero-actions">
            <a href="/hustle-posed" class="btn btn-primary">Lihat Demo Photobooth</a>
            <a href="#pricing" class="btn btn-outline">Lihat Pricing</a>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="features">
        <h2 class="section-title">Kenapa HustleSpace?</h2>
        <div class="feature-grid">
            <div class="feature-card">
                <div class="feature-icon">✨</div>
                <h3>Custom Frames</h3>
                <p>Upload frame desain Anda sendiri atau pilih dari ratusan template siap pakai (Minimal, Elegant, Fun, Seasonal).</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📸</div>
                <h3>Multiple Layouts</h3>
                <p>Dukung pengambilan Single, Two Frames, hingga Four Frames seperti photobooth profesional.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">☁️</div>
                <h3>Cloud Storage</h3>
                <p>Simpan semua hasil foto pelanggan secara otomatis ke cloud. Download dan bagikan kapan saja.</p>
            </div>
        </div>
    </section>

    <!-- Pricing -->
    <section id="pricing" class="pricing">
        <h2 class="section-title">Pilih Plan Anda</h2>
        <div class="pricing-grid">
            
            <!-- Basic Plan -->
            <div class="pricing-card">
                <div class="pricing-title">Starter</div>
                <div class="pricing-price">Rp 99k<span>/bulan</span></div>
                <ul class="pricing-features">
                    <li>Akses Basic Frames</li>
                    <li>Single & 4-Frame Layout</li>
                    <li>Export Foto Resolusi Standar</li>
                    <li>Watermark HustleSpace</li>
                </ul>
                <a href="{{ url('/hustle-posed/login') }}" class="btn btn-outline">Mulai Sekarang</a>
            </div>

            <!-- Pro Plan -->
            <div class="pricing-card popular">
                <div class="popular-badge">Paling Populer</div>
                <div class="pricing-title">Pro Event</div>
                <div class="pricing-price">Rp 299k<span>/bulan</span></div>
                <ul class="pricing-features">
                    <li>Akses Semua Premium Frames</li>
                    <li>Upload Custom Frame Sendiri</li>
                    <li>Export Resolusi Tinggi (HD)</li>
                    <li>Tanpa Watermark</li>
                    <li>Dashboard Analytics</li>
                </ul>
                <a href="{{ url('/hustle-posed/login') }}" class="btn btn-primary">Pilih Pro</a>
            </div>

            <!-- Enterprise -->
            <div class="pricing-card">
                <div class="pricing-title">Enterprise</div>
                <div class="pricing-price">Custom</div>
                <ul class="pricing-features">
                    <li>Semua Fitur Pro Event</li>
                    <li>White-label Solution</li>
                    <li>Custom Domain</li>
                    <li>Prioritas Dukungan 24/7</li>
                </ul>
                <a href="{{ url('/hustle-posed/login') }}" class="btn btn-outline">Hubungi Kami</a>
            </div>

        </div>
    </section>

    <footer>
        &copy; {{ date('Y') }} HustleSpace. All rights reserved. Made with ❤️ for your best moments.
    </footer>

    <script>
        // Hamburger Menu Logic
        const hamburger = document.getElementById('hamburger');
        const navLinks = document.getElementById('navLinks');
        
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navLinks.classList.toggle('active');
        });
        
        // Close menu when clicking a link
        document.querySelectorAll('.nav-item').forEach(n => n.addEventListener('click', () => {
            hamburger.classList.remove('active');
            navLinks.classList.remove('active');
        }));

        // Theme toggle logic
        const themeToggle = document.getElementById('themeToggle');
        const iconLight = themeToggle.querySelector('.icon-light');

        // Set initial icon
        if (document.documentElement.classList.contains('theme-dark')) {
            iconLight.textContent = '☀️';
        }

        themeToggle.addEventListener('click', () => {
            document.documentElement.classList.toggle('theme-dark');
            if (document.documentElement.classList.contains('theme-dark')) {
                localStorage.setItem('theme', 'dark');
                iconLight.textContent = '☀️';
            } else {
                localStorage.setItem('theme', 'light');
                iconLight.textContent = '🌙';
            }
        });

        window.addEventListener('load', () => {
            const loader = document.getElementById('pageLoader');
            if (loader) {
                setTimeout(() => {
                    loader.classList.add('fade-out');
                }, 2000);
            }
        });

        document.querySelectorAll('a[href]:not([href^="#"])').forEach(link => {
            link.addEventListener('click', function(e) {
                if(this.target !== '_blank' && !e.ctrlKey && !e.metaKey) {
                    if(this.id === 'themeToggle') return; // Ignore theme toggle button
                    e.preventDefault();
                    const url = this.href;
                    const loader = document.getElementById('pageLoader');
                    if(loader) {
                        loader.classList.remove('fade-out');
                        setTimeout(() => {
                            window.location.href = url;
                        }, 400); 
                    } else {
                        window.location.href = url;
                    }
                }
            });
        });
    </script>
</body>
</html>
