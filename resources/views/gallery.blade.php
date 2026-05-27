<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hustle Moments - Gallery</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --card-bg: #ffffff;
            --primary: #4f46e5;
            --secondary: #ec4899;
        }

        .theme-dark {
            --bg-color: #020617;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --card-bg: #0f172a;
            --primary: #6366f1;
            --secondary: #f472b6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            overflow-x: hidden;
        }

        .img-dark { display: none; }
        .theme-dark .img-dark { display: block; }
        .theme-dark .img-light { display: none; }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 1.5rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(var(--bg-color), 0.8);
            backdrop-filter: blur(10px);
            z-index: 1000;
            border-bottom: 1px solid rgba(148, 163, 184, 0.1);
        }

        .navbar .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-main);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-main);
            font-weight: 600;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .theme-toggle {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.2rem;
            color: var(--text-main);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(79, 70, 229, 0.3);
        }

        /* Hero Section */
        .hero {
            padding: 150px 5% 50px;
            text-align: center;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 1.2rem;
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto;
        }

        /* Masonry Grid */
        .gallery-container {
            padding: 0 5% 100px;
            columns: 4 250px;
            column-gap: 1.5rem;
        }

        .gallery-item {
            break-inside: avoid;
            margin-bottom: 1.5rem;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            position: relative;
            background: var(--card-bg);
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
        }

        .gallery-item:hover {
            transform: scale(1.03) translateY(-5px);
            z-index: 10;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .gallery-item img {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 1rem;
        }

        .overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 2rem 1.5rem 1.5rem;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            color: white;
            opacity: 0;
            transition: opacity 0.3s;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            border-bottom-left-radius: 1rem;
            border-bottom-right-radius: 1rem;
        }

        .gallery-item:hover .overlay {
            opacity: 1;
        }

        .user-info {
            font-size: 0.9rem;
            font-weight: 600;
        }
        
        .user-info span {
            display: block;
            font-size: 0.75rem;
            font-weight: 400;
            opacity: 0.8;
        }

        .badge {
            background: var(--primary);
            padding: 0.2rem 0.5rem;
            border-radius: 0.5rem;
            font-size: 0.7rem;
            font-weight: 700;
        }
        
        .badge.demo {
            background: var(--text-muted);
        }

        /* Lightbox */
        #lightbox {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.9);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            backdrop-filter: blur(5px);
        }
        #lightbox.active {
            display: flex;
            animation: fadeIn 0.3s;
        }
        #lightbox img {
            max-width: 90%;
            max-height: 90%;
            border-radius: 1rem;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            animation: zoomIn 0.3s;
        }
        #lightbox-close {
            position: absolute;
            top: 2rem;
            right: 2rem;
            color: white;
            font-size: 2rem;
            cursor: pointer;
            background: none;
            border: none;
            transition: transform 0.3s;
        }
        #lightbox-close:hover {
            transform: scale(1.1) rotate(90deg);
        }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes zoomIn { from { transform: scale(0.9); } to { transform: scale(1); } }

        @media (max-width: 768px) {
            .gallery-container {
                columns: 2 150px;
            }
            .hero h1 { font-size: 2.5rem; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="/" class="logo">
            <img class="img-light" src="{{ asset('assets/hustle/hustle-space-logo-white.png') }}" alt="HustleSpace Logo" style="height: 40px;">
            <img class="img-dark" src="{{ asset('assets/hustle/hustle-space-logo.png') }}" alt="HustleSpace Logo" style="height: 40px;">
        </a>
        <div class="nav-links">
            <a href="{{ url('/') }}">Home</a>
            <button id="themeToggle" class="theme-toggle">🌙</button>
            <a href="{{ url('/hustle-posed') }}" class="btn btn-primary" style="margin-left: 0.5rem; padding: 0.5rem 1rem;">Coba Photobooth</a>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <h1>Hustle Moments</h1>
        <p>Jelajahi momen-momen seru dan kreatif yang dibagikan oleh komunitas HustleSpace.</p>
    </section>

    <!-- Gallery -->
    <div class="gallery-container">
        @forelse($photos as $photo)
        <div class="gallery-item" onclick="openLightbox('{{ asset('storage/' . $photo->image_path) }}')">
            <img src="{{ asset('storage/' . $photo->image_path) }}" alt="Hustle Moment" loading="lazy">
            <div class="overlay">
                <div class="user-info">
                    {{ $photo->user ? $photo->user->name : 'Guest User' }}
                    <span>{{ $photo->created_at->diffForHumans() }}</span>
                </div>
                @if($photo->user)
                    <div class="badge">PRO</div>
                @else
                    <div class="badge demo">DEMO</div>
                @endif
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 5rem 0;">
            <p>Belum ada foto yang dipublish. Jadilah yang pertama!</p>
        </div>
        @endforelse
    </div>

    <!-- Lightbox -->
    <div id="lightbox">
        <button id="lightbox-close">&times;</button>
        <img id="lightbox-img" src="" alt="Zoomed">
    </div>

    <script>
        // Theme logic
        const themeToggle = document.getElementById('themeToggle');
        const root = document.documentElement;
        
        if (localStorage.getItem('theme') === 'dark') {
            root.classList.add('theme-dark');
            themeToggle.textContent = '☀️';
        }

        themeToggle.addEventListener('click', () => {
            root.classList.toggle('theme-dark');
            const isDark = root.classList.contains('theme-dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            themeToggle.textContent = isDark ? '☀️' : '🌙';
        });

        // Lightbox logic
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        const lightboxClose = document.getElementById('lightbox-close');

        function openLightbox(src) {
            lightboxImg.src = src;
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        lightboxClose.addEventListener('click', () => {
            lightbox.classList.remove('active');
            document.body.style.overflow = 'auto';
        });

        lightbox.addEventListener('click', (e) => {
            if(e.target === lightbox) {
                lightbox.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });
    </script>
</body>
</html>
