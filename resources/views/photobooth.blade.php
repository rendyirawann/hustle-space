<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HustleSpace Photobooth</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/hustle/favico.png') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #5544FF; 
            --primary-hover: #4433DD;
            --bg-color: #F8F9FB;
            --card-bg: #FFFFFF;
            --text-main: #1A1A24;
            --text-muted: #8B8C9A;
            --border-color: #EAEAEE;
            --frame-color: #C6C8FC; 
            --accent-yellow: #FFDE59;
            --accent-pink: #FF9EAA;
            --step-active: #5544FF;
            --step-inactive: #EAEAEE;
        }

        html.theme-dark {
            --bg-color: #0B0F19;
            --card-bg: #000000;
            --text-main: #F3F4F6;
            --text-muted: #9CA3AF;
            --border-color: #2D334A;
            --step-inactive: #2D334A;
        }

        .img-dark { display: none; }
        html.theme-dark .img-light { display: none; }
        html.theme-dark .img-dark { display: inline-block; }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(145deg, var(--bg-color) 0%, #0d1222 100%);
            background-attachment: fixed;
            color: var(--text-main);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100dvh;
        }

        /* Custom Aesthetic Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }

        .theme-dark ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
        }

        .theme-dark ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
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
            background: rgba(85, 68, 255, 0.1);
        }

        .promo-banner {
            background-color: rgba(85, 68, 255, 0.1);
            color: #C6C8FC;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Layout Architecture */
        .wizard-app-layout {
            display: flex;
            flex: 1;
            overflow: hidden;
            flex-direction: row;
        }

        /* Progress Steps Sidebar */
        .wizard-sidebar {
            width: 250px;
            background-color: var(--card-bg);
            border-right: 1px solid var(--border-color);
            padding: 2rem;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            overflow-y: auto;
        }

        .steps-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 0;
            width: 100%;
        }

        .step-wrapper {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.9rem;
            transition: color 0.3s;
            padding: 0.5rem 0;
        }

        .step.active {
            color: var(--step-active);
        }

        .step.completed {
            color: var(--text-main);
        }

        .step-number {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: var(--step-inactive);
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            transition: all 0.3s;
            flex-shrink: 0;
        }

        .step.active .step-number {
            background-color: var(--step-active);
            color: white;
        }
        
        .step.completed .step-number {
            background-color: var(--text-main);
            color: var(--card-bg);
        }

        .step-line {
            width: 2px;
            height: 40px;
            background-color: var(--step-inactive);
            margin-left: 15px; /* Aligns with the center of the 32px circle */
            margin-top: 5px;
            margin-bottom: 5px;
            transition: background-color 0.3s;
        }

        .step-line.active {
            background-color: var(--step-active);
        }

        /* Main Wizard Content Area */
        .wizard-main-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background-color: var(--bg-color);
        }

        .wizard-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
        }

        .wizard-step {
            display: none;
            flex: 1;
            flex-direction: column;
            padding: 1.5rem 3rem;
            overflow-y: auto;
            animation: fadeIn 0.4s ease forwards;
        }
        .wizard-step.active {
            display: flex;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .step-title {
            text-align: center;
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
            color: var(--text-main);
        }

        .step-subtitle {
            text-align: center;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
        }

        /* Step 1: Layout Selection */
        .layout-grid {
            display: flex;
            justify-content: center;
            gap: 2.5rem;
            max-width: 1100px;
            margin: 0 auto;
            width: 100%;
        }

        .layout-card {
            background: var(--card-bg);
            border: 2px solid var(--border-color);
            border-radius: 20px;
            padding: 3.5rem 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .layout-card:hover {
            border-color: var(--primary);
            background: rgba(99, 102, 241, 0.05);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            transform: translateY(-5px);
        }

        .layout-card.selected {
            border-color: var(--primary);
            background: rgba(85, 68, 255, 0.05);
        }

        .layout-icon-big {
            width: 100px;
            height: 130px;
            border: 4px solid var(--text-main);
            border-radius: 12px;
            margin-bottom: 2.5rem;
            display: grid;
            padding: 8px;
            gap: 8px;
        }

        .layout-icon-big div { background: var(--text-main); opacity: 0.2; border-radius: 4px; }
        .layout-card.selected .layout-icon-big { border-color: var(--primary); }
        .layout-card.selected .layout-icon-big div { background: var(--primary); opacity: 0.5; }
        
        .l-single { grid-template-columns: 1fr; grid-template-rows: 1fr; }
        .l-two { grid-template-columns: 1fr; grid-template-rows: 1fr 1fr; }
        .l-four { grid-template-columns: 1fr 1fr; grid-template-rows: 1fr 1fr; }

        .layout-name { font-weight: 700; font-size: 1.1rem; margin-bottom: 0.5rem; }
        .layout-desc { font-size: 0.85rem; color: var(--text-muted); text-align: center; }

        /* Step 2: Camera */
        .camera-container {
            display: flex;
            flex: 1;
            gap: 2rem;
            max-width: 1000px;
            margin: 0 auto;
            width: 100%;
            min-height: 0;
        }

        .camera-main {
            flex: 3;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .camera-view {
            width: 100%;
            max-width: 600px;
            aspect-ratio: 4/3;
            background: #000;
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        #video-feed {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scaleX(-1);
        }

        .countdown-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 8rem;
            font-weight: 800;
            color: white;
            text-shadow: 0 4px 20px rgba(0,0,0,0.5);
            display: none;
            z-index: 10;
        }

        .capture-controls {
            margin-top: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .btn-capture-big {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--card-bg);
            border: 4px solid var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.2s;
            box-shadow: 0 5px 15px rgba(85, 68, 255, 0.3);
        }

        .btn-capture-big .inner {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }
        
        .btn-capture-big:active { transform: scale(0.95); }

        .camera-sidebar {
            flex: 1.5;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            overflow: hidden; /* Prevent scrolling */
        }

        .camera-slots-container {
            width: 100%;
            display: grid;
            gap: 0.75rem;
        }

        .sidebar-title {
            font-weight: 700;
            font-size: 1rem;
            text-align: center;
            width: 100%;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 1rem;
            margin-bottom: 0.5rem;
        }

        .photo-slot {
            width: 100%;
            aspect-ratio: 4/3;
            background: var(--bg-color);
            border: 2px dashed var(--border-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.2s;
        }

        .photo-slot.filled {
            border: none;
        }

        .photo-slot img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-slot .retake-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .photo-slot.filled:hover .retake-overlay { opacity: 1; }
        
        .photo-slot .empty-text {
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* Step 3: Effects */
        .effects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 2rem;
            max-width: 900px;
            margin: 0 auto;
            width: 100%;
        }

        .effect-card {
            background: var(--card-bg);
            border: 2px solid var(--border-color);
            border-radius: 20px;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        
        .effect-card:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            transform: translateY(-5px);
            border-color: var(--primary);
        }

        .effect-card.selected { border-color: var(--primary); background: rgba(85,68,255,0.05); }

        .effect-preview {
            width: 100%;
            background: var(--bg-color);
            border-radius: 8px;
            margin-bottom: 1rem;
            overflow: hidden;
            display: grid; 
        }

        .effect-name { font-weight: 700; font-size: 1rem; }

        /* Effects CSS Filters */
        .filter-none { filter: none; }
        .filter-grayscale { filter: grayscale(100%); }
        .filter-sepia { filter: sepia(80%); }
        .filter-vintage { filter: sepia(50%) contrast(120%) brightness(90%); }
        .filter-bright { filter: brightness(120%) saturate(120%); }

        /* Step 4: Frames */
        .frames-container {
            display: flex;
            gap: 2rem;
            max-width: 1100px;
            margin: 0 auto;
            width: 100%;
            height: 100%; /* Take full height for scrolling */
            min-height: 0;
        }

        .frame-preview-main {
            flex: 1.2;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--card-bg);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid var(--border-color);
            min-height: 0;
        }

        .frame-canvas-wrapper {
            position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            max-height: 100%;
            display: flex;
            justify-content: center;
        }

        #composition-canvas {
            display: block;
            max-width: 100%;
            max-height: 55vh;
            object-fit: contain;
        }

        .frame-selection-sidebar {
            flex: 1;
            background: var(--card-bg);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            padding: 1rem 1.5rem;
            overflow-y: auto;
            max-height: 60vh;
        }
        
        .frame-list-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        .frame-item-card {
            background: var(--bg-color);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            aspect-ratio: 3/4;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .frame-item-card:hover {
            border-color: var(--primary);
            box-shadow: 0 6px 15px rgba(0,0,0,0.15);
            transform: translateY(-3px);
        }

        .frame-item-card.selected {
            border-color: var(--primary);
        }

        .frame-thumb {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
        }

        /* Step 5: Final Result */
        .result-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex: 1;
            gap: 2rem;
        }

        .final-image-wrapper {
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
            border-radius: 8px;
            overflow: hidden;
            background: white;
            padding: 10px;
        }

        #final-canvas {
            display: block;
            max-width: 90vw;
            max-height: 50vh;
        }

        .session-info {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            padding: 1rem 2rem;
            border-radius: 30px;
            display: flex;
            gap: 2rem;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .session-info .val { color: var(--primary); }

        /* Navigation Buttons */
        .wizard-footer {
            padding: 1.5rem 3rem;
            background: var(--card-bg);
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
            z-index: 10;
        }

        .btn {
            padding: 0.85rem 1.75rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.05rem;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-main);
        }
        .btn-outline:hover { background: var(--bg-color); }

        .btn-primary {
            background: var(--primary);
            color: white;
        }
        .btn-primary:hover { background: var(--primary-hover); }
        
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Responsive Breakpoints */
        @media (max-width: 900px) {
            .wizard-app-layout {
                flex-direction: column;
            }
            .wizard-sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid var(--border-color);
                padding: 1rem;
                flex-direction: row;
                overflow-x: auto;
                white-space: nowrap;
            }
            .steps-container {
                flex-direction: row;
                align-items: center;
                justify-content: flex-start;
                width: max-content;
                margin: 0;
                gap: 1rem;
            }
            .step-wrapper {
                flex-direction: row;
                align-items: center;
                width: auto;
            }
            .step-line {
                width: 30px;
                height: 2px;
                margin: 0 10px;
            }
            .step span {
                display: none; /* hide text on mobile to save space */
            }
            
            .wizard-step {
                padding: 1.5rem 1rem;
            }
            
            .layout-grid {
                flex-direction: column;
            }
            
            .camera-container, .frames-container {
                flex-direction: column;
            }
            
            .frame-selection-sidebar {
                max-height: 400px;
            }
        }
    </style>
</head>
<body>
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('theme-dark');
        }
    </script>

    <!-- Navbar -->
    <header class="navbar">
        <a href="/" class="logo">
            <img class="img-light" src="{{ asset('assets/hustle/hustle-space-logo-white.png') }}" alt="Logo" style="height: 40px;">
            <img class="img-dark" src="{{ asset('assets/hustle/hustle-space-logo.png') }}" alt="Logo" style="height: 40px;">
        </a>
        <div style="display: flex; align-items: center; gap: 15px;">
            @if($mode === 'pro')
                <div class="promo-banner" style="background: linear-gradient(135deg, #f59e0b, #ef4444); color: #fff; border:none; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);">
                    <span style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">👑</span> Pro Mode Active
                </div>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239,68,68,0.3); border-radius: 20px; padding: 6px 14px; font-weight: 600; cursor: pointer; transition: all 0.3s; box-shadow: 0 2px 10px rgba(239,68,68,0.15);">
                        Logout
                    </button>
                </form>
            @else
                <div class="promo-banner"><span>✨</span> Level up your moments with HustleSpace!</div>
            @endif
            
            <button id="themeToggle" class="theme-toggle"><span class="icon-light">🌙</span></button>
        </div>
    </header>

    <div class="wizard-app-layout">
        <!-- Sidebar Steps -->
        <aside class="wizard-sidebar">
            <div class="steps-container">
                <div class="step-wrapper">
                    <div class="step active" id="nav-step-1">
                        <div class="step-number">1</div> <span>🔲 Layout</span>
                    </div>
                    <div class="step-line" id="line-1"></div>
                </div>
                
                <div class="step-wrapper">
                    <div class="step" id="nav-step-2">
                        <div class="step-number">2</div> <span>📸 Kamera</span>
                    </div>
                    <div class="step-line" id="line-2"></div>
                </div>
                
                <div class="step-wrapper">
                    <div class="step" id="nav-step-3">
                        <div class="step-number">3</div> <span>✨ Efek</span>
                    </div>
                    <div class="step-line" id="line-3"></div>
                </div>
                
                <div class="step-wrapper">
                    <div class="step" id="nav-step-4">
                        <div class="step-number">4</div> <span>🖼️ Frame</span>
                    </div>
                    <div class="step-line" id="line-4"></div>
                </div>
                
                <div class="step-wrapper">
                    <div class="step" id="nav-step-5">
                        <div class="step-number">5</div> <span>🎉 Selesai</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Wizard Content -->
        <main class="wizard-main-area">
            <div class="wizard-content">
                
                <!-- Step 1: Layout Selection -->
                <div class="wizard-step active" id="step-1">
                    <div class="step-title">Pilih Layout Foto</div>
                    <div class="step-subtitle">Tentukan berapa banyak pose yang ingin Anda abadikan.</div>
                    
                    <div class="layout-grid">
                        <div class="layout-card selected" data-layout="1">
                            <div class="layout-icon-big l-single"><div></div></div>
                            <div class="layout-name">Single Pose</div>
                            <div class="layout-desc">Satu foto penuh untuk momen spesial.</div>
                        </div>
                        <div class="layout-card" data-layout="2">
                            <div class="layout-icon-big l-two"><div></div><div></div></div>
                            <div class="layout-name">Two Frames</div>
                            <div class="layout-desc">Dua pose atas dan bawah.</div>
                        </div>
                        <div class="layout-card" data-layout="4">
                            <div class="layout-icon-big l-four"><div></div><div></div><div></div><div></div></div>
                            <div class="layout-name">Four Frames</div>
                            <div class="layout-desc">Klasik 4 frame ala photobooth.</div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Camera Capture -->
                <div class="wizard-step" id="step-2">
                    <div class="step-title" id="capture-title">Siapkan Pose Anda</div>
                    <div class="step-subtitle">Tekan tombol kamera untuk mengambil foto.</div>
                    
                    <div class="camera-container">
                        <div class="camera-main">
                            <div class="camera-view">
                                <video id="video-feed" autoplay playsinline></video>
                                <canvas id="temp-canvas" style="display:none;"></canvas>
                                <div class="countdown-overlay" id="countdown">3</div>
                            </div>
                            <div class="capture-controls">
                                <div class="btn-capture-big" id="btn-capture">
                                    <div class="inner">📷</div>
                                </div>
                                <div style="font-size:0.85rem; color:var(--text-muted); margin-top:0.5rem;">Klik foto di samping untuk mengulang (retake)</div>
                            </div>
                        </div>
                        
                        <div class="camera-sidebar">
                            <div class="sidebar-title">Hasil Sementara (<span id="photo-count">0</span>/<span id="photo-total">1</span>)</div>
                            <div id="slots-container" class="camera-slots-container">
                                <!-- Slots generated by JS -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Effects -->
                <div class="wizard-step" id="step-3">
                    <div class="step-title">Pilih Filter / Efek</div>
                    <div class="step-subtitle">Tambahkan nuansa pada foto Anda.</div>

                    <div class="effects-grid">
                        <div class="effect-card selected" data-effect="filter-none">
                            <div class="effect-preview filter-none" id="ep-none"></div>
                            <div class="effect-name">Original</div>
                        </div>
                        <div class="effect-card" data-effect="filter-grayscale">
                            <div class="effect-preview filter-grayscale" id="ep-grayscale"></div>
                            <div class="effect-name">Black & White</div>
                        </div>
                        <div class="effect-card" data-effect="filter-sepia">
                            <div class="effect-preview filter-sepia" id="ep-sepia"></div>
                            <div class="effect-name">Sepia</div>
                        </div>
                        <div class="effect-card" data-effect="filter-vintage">
                            <div class="effect-preview filter-vintage" id="ep-vintage"></div>
                            <div class="effect-name">Vintage</div>
                        </div>
                        <div class="effect-card" data-effect="filter-bright">
                            <div class="effect-preview filter-bright" id="ep-bright"></div>
                            <div class="effect-name">Bright</div>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Frames -->
                <div class="wizard-step" id="step-4">
                    <div class="step-title">Pilih Desain Frame</div>
                    <div class="step-subtitle">Pilih bingkai yang paling cocok untuk foto Anda.</div>

                    <div class="frames-container">
                        <div class="frame-preview-main">
                            <div class="frame-canvas-wrapper">
                                <canvas id="composition-canvas"></canvas>
                            </div>
                        </div>
                        <div class="frame-selection-sidebar">
                            <div class="sidebar-title">Pilihan Frame</div>
                            <div class="frame-list-grid" id="frame-options">
                                <!-- Frame options injected by JS depending on layout -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 5: Final Result -->
                <div class="wizard-step" id="step-5">
                    <div class="step-title">Foto Anda Sudah Siap! 🎉</div>
                    <div class="step-subtitle">Silakan unduh momen berharga Anda.</div>

                    <div class="result-container">
                        <div class="final-image-wrapper">
                            <canvas id="final-canvas"></canvas>
                        </div>

                        @if($mode !== 'pro')
                        <div class="session-info">
                            <div>Sisa Sesi Foto: <span class="val" id="info-photos">?</span></div>
                            <div>Sisa Sesi Download: <span class="val" id="info-downloads">?</span></div>
                        </div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Wizard Footer -->
            <div class="wizard-footer">
                <button class="btn btn-outline" id="btn-back" style="visibility: hidden;">← Kembali</button>
                <button class="btn btn-primary" id="btn-next">Lanjut →</button>
                <button class="btn btn-primary" id="btn-download" style="display:none;">↓ Download Foto</button>
            </div>
        </main>
    </div>

    <script>
        // Theme toggle
        const themeToggle = document.getElementById('themeToggle');
        const iconLight = themeToggle.querySelector('.icon-light');
        if (document.documentElement.classList.contains('theme-dark')) iconLight.textContent = '☀️';
        
        themeToggle.addEventListener('click', () => {
            document.documentElement.classList.toggle('theme-dark');
            if (document.documentElement.classList.contains('theme-dark')) {
                localStorage.setItem('theme', 'dark'); iconLight.textContent = '☀️';
            } else {
                localStorage.setItem('theme', 'light'); iconLight.textContent = '🌙';
            }
        });

        // Application State
        const state = {
            currentStep: 1,
            totalSteps: 5,
            layout: 1, // 1, 2, 4
            capturedImages: [], 
            selectedEffect: 'filter-none',
            selectedFrameIndex: 0,
            mode: "{{ $mode ?? 'demo' }}",
            csrfToken: "{{ csrf_token() }}"
        };

        // Cache Management
        function saveState() {
            sessionStorage.setItem('photobooth_state', JSON.stringify({
                currentStep: state.currentStep,
                layout: state.layout,
                capturedImages: state.capturedImages,
                selectedEffect: state.selectedEffect,
                selectedFrameIndex: state.selectedFrameIndex,
                mode: state.mode
            }));
        }

        function loadState() {
            const saved = sessionStorage.getItem('photobooth_state');
            if (saved) {
                try {
                    const parsed = JSON.parse(saved);
                    // Only load if mode matches
                    if (parsed.mode === state.mode) {
                        state.currentStep = parsed.currentStep || 1;
                        state.layout = parsed.layout || 1;
                        state.capturedImages = parsed.capturedImages || [];
                        state.selectedEffect = parsed.selectedEffect || 'filter-none';
                        state.selectedFrameIndex = parsed.selectedFrameIndex || 0;
                    }
                } catch (e) {
                    console.error("Failed to parse cached state", e);
                }
            }
        }

        // DOM Elements
        const btnNext = document.getElementById('btn-next');
        const btnBack = document.getElementById('btn-back');
        const btnDownload = document.getElementById('btn-download');
        
        // Navigation Logic
        function updateWizardUI() {
            // Update Steps Visibility
            for(let i=1; i<=state.totalSteps; i++) {
                document.getElementById(`step-${i}`).classList.remove('active');
                
                const nav = document.getElementById(`nav-step-${i}`);
                if(i < state.currentStep) {
                    nav.classList.add('completed'); nav.classList.remove('active');
                    if(document.getElementById(`line-${i}`)) document.getElementById(`line-${i}`).classList.add('active');
                } else if (i === state.currentStep) {
                    nav.classList.add('active'); nav.classList.remove('completed');
                    if(document.getElementById(`line-${i}`)) document.getElementById(`line-${i}`).classList.remove('active');
                } else {
                    nav.classList.remove('active', 'completed');
                    if(document.getElementById(`line-${i}`)) document.getElementById(`line-${i}`).classList.remove('active');
                }
            }
            document.getElementById(`step-${state.currentStep}`).classList.add('active');

            // Button visibility & state
            // Back button is only available on step 2, 4, 5
            if (state.currentStep === 2) {
                btnBack.style.visibility = 'visible';
                btnBack.textContent = "← Kembali Layout";
            } else if (state.currentStep === 4) {
                btnBack.style.visibility = 'visible';
                btnBack.textContent = "← Kembali Efek";
            } else if (state.currentStep === 5) {
                btnBack.style.visibility = 'visible';
                btnBack.textContent = "Mulai Baru";
            } else {
                btnBack.style.visibility = 'hidden';
            }
            
            if (state.currentStep === 2) {
                // Next is disabled until all photos taken
                btnNext.disabled = state.capturedImages.length < state.layout;
            } else {
                btnNext.disabled = false;
            }

            if (state.currentStep === 5) {
                btnNext.style.display = 'none';
                btnDownload.style.display = 'inline-flex';
            } else {
                btnNext.style.display = 'inline-flex';
                btnDownload.style.display = 'none';
            }

            // Specific step initializations
            if (state.currentStep === 2) initStep2();
            if (state.currentStep === 3) initStep3();
            if (state.currentStep === 4) initStep4();
            if (state.currentStep === 5) initStep5();
        }

        btnNext.addEventListener('click', () => {
            if (state.currentStep < state.totalSteps) {
                state.currentStep++;
                saveState();
                updateWizardUI();
            }
        });

        btnBack.addEventListener('click', () => {
            if (state.currentStep === 5) {
                Swal.fire({
                    title: 'Mulai Baru?',
                    text: "Foto sebelumnya akan terhapus.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'var(--primary)',
                    cancelButtonColor: 'var(--text-muted)',
                    confirmButtonText: 'Ya, Mulai Baru',
                    cancelButtonText: 'Batal',
                    background: document.documentElement.classList.contains('theme-dark') ? 'var(--card-bg)' : '#fff',
                    color: 'var(--text-main)'
                }).then((result) => {
                    if (result.isConfirmed) {
                        sessionStorage.removeItem('photobooth_state');
                        window.location.reload(); 
                    }
                });
            } else if (state.currentStep === 4) {
                state.currentStep = 3;
                saveState();
                updateWizardUI();
            } else if (state.currentStep === 2) {
                state.currentStep = 1;
                saveState();
                updateWizardUI();
            }
        });

        // Step 1: Layout Selection
        document.querySelectorAll('.layout-card').forEach(card => {
            card.addEventListener('click', () => {
                document.querySelectorAll('.layout-card').forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                state.layout = parseInt(card.dataset.layout);
                // Reset captured images if layout changes
                state.capturedImages = [];
                saveState();
            });
        });

        // Step 2: Camera Logic
        const video = document.getElementById('video-feed');
        const tempCanvas = document.getElementById('temp-canvas');
        const ctx = tempCanvas.getContext('2d');
        const slotsContainer = document.getElementById('slots-container');
        const btnCapture = document.getElementById('btn-capture');
        const countdownEl = document.getElementById('countdown');
        let stream = null;
        let isCapturing = false;

        async function initCamera() {
            if (!stream) {
                try {
                    stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "user" } });
                    video.srcObject = stream;
                } catch (err) {
                    Swal.fire({
                        title: 'Akses Kamera Ditolak',
                        text: 'Kamera tidak dapat diakses. Mohon izinkan akses kamera di browser Anda.',
                        icon: 'error',
                        confirmButtonColor: 'var(--primary)',
                        background: document.documentElement.classList.contains('theme-dark') ? 'var(--card-bg)' : '#fff',
                        color: 'var(--text-main)'
                    });
                }
            }
        }

        function initStep2() {
            initCamera();
            document.getElementById('photo-total').textContent = state.layout;
            renderSlots();
        }

        function renderSlots() {
            slotsContainer.innerHTML = '';
            
            // Atur jumlah kolom grid berdasarkan layout (2 kolom jika > 1 frame)
            if (state.layout > 1) {
                slotsContainer.style.gridTemplateColumns = 'repeat(2, 1fr)';
            } else {
                slotsContainer.style.gridTemplateColumns = '1fr';
            }

            document.getElementById('photo-count').textContent = state.capturedImages.length;
            
            for(let i=0; i<state.layout; i++) {
                const slot = document.createElement('div');
                slot.className = `photo-slot ${state.capturedImages[i] ? 'filled' : ''}`;
                
                if (state.capturedImages[i]) {
                    slot.innerHTML = `<img src="${state.capturedImages[i]}" style="transform:scaleX(-1);"><div class="retake-overlay">Click to Retake</div>`;
                    slot.addEventListener('click', () => retakePhoto(i));
                } else {
                    slot.innerHTML = `<div class="empty-text">Photo ${i+1}</div>`;
                }
                slotsContainer.appendChild(slot);
            }

            // Update Next button
            btnNext.disabled = state.capturedImages.length < state.layout;
            
            // Hide capture button if full
            btnCapture.style.opacity = state.capturedImages.length >= state.layout ? '0.5' : '1';
            btnCapture.style.pointerEvents = state.capturedImages.length >= state.layout ? 'none' : 'auto';
            document.getElementById('capture-title').textContent = state.capturedImages.length >= state.layout ? "Bagus! Lanjut ke Efek" : "Siapkan Pose Anda";
        }

        function retakePhoto(index) {
            Swal.fire({
                title: 'Foto Ulang?',
                text: "Ingin memfoto ulang frame ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: 'var(--primary)',
                cancelButtonColor: 'var(--text-muted)',
                confirmButtonText: 'Ya, Foto Ulang',
                cancelButtonText: 'Batal',
                background: document.documentElement.classList.contains('theme-dark') ? 'var(--card-bg)' : '#fff',
                color: 'var(--text-main)'
            }).then((result) => {
                if (result.isConfirmed) {
                    state.capturedImages.splice(index, 1);
                    saveState();
                    renderSlots();
                }
            });
        }

        function flashEffect() {
            const flash = document.createElement('div');
            flash.style.position = 'fixed';
            flash.style.top = '0'; flash.style.left = '0';
            flash.style.width = '100vw'; flash.style.height = '100vh';
            flash.style.backgroundColor = 'white';
            flash.style.zIndex = '99999';
            document.body.appendChild(flash);
            setTimeout(() => { flash.style.opacity = '0'; flash.style.transition = 'opacity 0.3s'; setTimeout(()=>flash.remove(), 300); }, 50);
        }

        btnCapture.addEventListener('click', async () => {
            if (isCapturing || state.capturedImages.length >= state.layout) return;

            // API Check Limit (Only for first photo to save API calls)
            if (state.capturedImages.length === 0) {
                const res = await fetch(`/api/photobooth/capture`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': state.csrfToken },
                    body: JSON.stringify({ mode: state.mode })
                });
                const data = await res.json();
                if (!res.ok || !data.allowed) {
                    Swal.fire({
                        title: 'Limit Tercapai',
                        text: data.message || 'Limit harian penggunaan tercapai.',
                        icon: 'info',
                        confirmButtonColor: 'var(--primary)',
                        background: document.documentElement.classList.contains('theme-dark') ? 'var(--card-bg)' : '#fff',
                        color: 'var(--text-main)'
                    });
                    return;
                }
            }

            isCapturing = true;
            countdownEl.style.display = 'block';
            let c = 3; countdownEl.textContent = c;
            
            const intv = setInterval(() => {
                c--;
                if (c > 0) { countdownEl.textContent = c; } 
                else {
                    clearInterval(intv);
                    countdownEl.style.display = 'none';
                    flashEffect();
                    
                    // Capture
                    tempCanvas.width = video.videoWidth;
                    tempCanvas.height = video.videoHeight;
                    ctx.drawImage(video, 0, 0, tempCanvas.width, tempCanvas.height);
                    
                    state.capturedImages.push(tempCanvas.toDataURL('image/png'));
                    saveState();
                    renderSlots();
                    isCapturing = false;
                }
            }, 1000);
        });

        // Step 3: Effects
        function initStep3() {
            const previewContainers = [
                'ep-none', 'ep-grayscale', 'ep-sepia', 'ep-vintage', 'ep-bright'
            ];

            let cols = 1, rows = 1;
            if (state.layout === 2) { rows = 2; cols = 1; }
            if (state.layout === 4) { rows = 2; cols = 2; }

            previewContainers.forEach(id => {
                const container = document.getElementById(id);
                container.innerHTML = '';
                container.style.display = 'grid';
                container.style.gridTemplateColumns = `repeat(${cols}, 1fr)`;
                container.style.gridTemplateRows = `repeat(${rows}, 1fr)`;
                container.style.gap = '4px';
                container.style.padding = '4px';

                state.capturedImages.forEach(src => {
                    const img = document.createElement('img');
                    img.src = src;
                    img.style.width = '100%';
                    img.style.aspectRatio = '4/3';
                    img.style.objectFit = 'cover';
                    img.style.transform = 'scaleX(-1)';
                    img.style.borderRadius = '2px';
                    img.style.display = 'block';
                    container.appendChild(img);
                });
            });
        }

        document.querySelectorAll('.effect-card').forEach(card => {
            card.addEventListener('click', () => {
                document.querySelectorAll('.effect-card').forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                state.selectedEffect = card.dataset.effect;
                saveState();
            });
        });

        // Frame Themes
        const themes = [
            { id: 'classic_light', name: 'Classic Light', bg: '#FFFFFF', border: 0, borderColor: '', text: '#1A1A24' },
            { id: 'classic_dark', name: 'Classic Dark', bg: '#1A1A24', border: 0, borderColor: '', text: '#FFFFFF' },
            { id: 'retro', name: 'Retro Vibes', bg: '#F4A261', border: 30, borderColor: '#E76F51', text: '#264653' },
            { id: 'cyberpunk', name: 'Cyber Neon', bg: '#0D0221', border: 20, borderColor: '#FF00FF', text: '#00FFFF' },
            { id: 'hellokitty', name: 'Pinky Kitty', bg: '#FFB6C1', border: 25, borderColor: '#FFFFFF', text: '#D81159' },
            { id: 'jjk', name: 'Anime JJK', bg: '#1E1E24', border: 20, borderColor: '#C1121F', text: '#C1121F' }
        ];

        // Step 4 & 5: Drawing Logic
        function drawComposition(canvasId) {
            const canv = document.getElementById(canvasId);
            const cx = canv.getContext('2d');
            const frameConfig = themes[state.selectedFrameIndex];
            
            // Define dimensions based on layout
            const photoW = 600;
            const photoH = 450; // 4:3
            const padding = 40;
            const gap = 20;
            const bottomPadding = 80; // For logo (reduced since text is smaller & no date)
            
            let cols = 1, rows = 1;
            if(state.layout === 2) { rows = 2; cols = 1; }
            if(state.layout === 4) { rows = 2; cols = 2; }

            canv.width = (photoW * cols) + (padding * 2) + (gap * (cols-1));
            canv.height = (photoH * rows) + padding + bottomPadding + (gap * (rows-1));

            // Background
            cx.fillStyle = frameConfig.bg;
            cx.fillRect(0, 0, canv.width, canv.height);

            // Border if any
            if(frameConfig.border) {
                cx.strokeStyle = frameConfig.borderColor;
                cx.lineWidth = frameConfig.border;
                cx.strokeRect(frameConfig.border/2, frameConfig.border/2, canv.width-frameConfig.border, canv.height-frameConfig.border);
            }

            // Draw Photos
            const promises = state.capturedImages.map((src, i) => {
                return new Promise(resolve => {
                    const img = new Image();
                    img.onload = () => {
                        let c = i % cols;
                        let r = Math.floor(i / cols);
                        let x = padding + (c * (photoW + gap));
                        let y = padding + (r * (photoH + gap));
                        
                        cx.save();
                        
                        // Apply rudimentary filter
                        if(state.selectedEffect === 'filter-grayscale') cx.filter = 'grayscale(100%)';
                        else if(state.selectedEffect === 'filter-sepia') cx.filter = 'sepia(100%)';
                        else if(state.selectedEffect === 'filter-vintage') cx.filter = 'sepia(50%) contrast(120%) brightness(90%)';
                        else if(state.selectedEffect === 'filter-bright') cx.filter = 'brightness(120%) saturate(120%)';
                        else cx.filter = 'none';

                        // Mirror drawing
                        cx.translate(x + photoW, y);
                        cx.scale(-1, 1);
                        cx.drawImage(img, 0, 0, photoW, photoH);
                        
                        cx.restore();
                        
                        // Draw inner border for aesthetics
                        cx.strokeStyle = 'rgba(0,0,0,0.1)';
                        cx.lineWidth = 2;
                        cx.strokeRect(x, y, photoW, photoH);

                        resolve();
                    };
                    img.src = src;
                });
            });

            Promise.all(promises).then(() => {
                // Draw HustleSpace watermark at bottom
                cx.fillStyle = frameConfig.text;
                cx.font = 'bold 26px Inter, sans-serif';
                cx.textAlign = 'center';
                cx.fillText('HustleSpace', canv.width/2, canv.height - 30);
            });
        }

        function initStep4() {
            const opts = document.getElementById('frame-options');
            opts.innerHTML = '';
            
            themes.forEach((frm, idx) => {
                const card = document.createElement('div');
                card.className = `frame-item-card ${idx === state.selectedFrameIndex ? 'selected' : ''}`;
                
                // Create thematic visual representation
                card.innerHTML = `<div style="width:100%; height:100%; background:${frm.bg}; border-radius:4px; ${frm.border?`border:4px solid ${frm.borderColor}`:''}; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:8px;">
                    <div style="background:rgba(0,0,0,0.2); width:60%; height:40%; border-radius:2px;"></div>
                    <div style="color:${frm.text}; font-size:0.8rem; font-weight:700; text-align:center;">${frm.name}</div>
                </div>`;
                
                card.addEventListener('click', () => {
                    document.querySelectorAll('.frame-item-card').forEach(c=>c.classList.remove('selected'));
                    card.classList.add('selected');
                    state.selectedFrameIndex = idx;
                    saveState();
                    drawComposition('composition-canvas');
                });
                opts.appendChild(card);
            });

            drawComposition('composition-canvas');
        }

        function initStep5() {
            // Re-draw final to ensure pristine quality
            drawComposition('final-canvas');
            
            // Fetch remaining limits if demo
            if (state.mode !== 'pro') {
                document.getElementById('info-photos').textContent = "Batas: 3";
                document.getElementById('info-downloads').textContent = "Batas: 1";
            }
        }

        // Download logic
        btnDownload.addEventListener('click', async () => {
            const res = await fetch(`/api/photobooth/download`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': state.csrfToken },
                body: JSON.stringify({ mode: state.mode })
            });
            const data = await res.json();
            if (!res.ok || !data.allowed) {
                Swal.fire({
                    title: 'Limit Unduh Tercapai',
                    text: data.message || 'Limit download harian tercapai.',
                    icon: 'info',
                    confirmButtonColor: 'var(--primary)',
                    background: document.documentElement.classList.contains('theme-dark') ? 'var(--card-bg)' : '#fff',
                    color: 'var(--text-main)'
                });
                return;
            }

            const canvas = document.getElementById('final-canvas');
            const dataUrl = canvas.toDataURL('image/png', 1.0);
            const link = document.createElement('a');
            link.download = `HustleSpace-Photobooth-${new Date().getTime()}.png`;
            link.href = dataUrl;
            link.click();
            
            if (state.mode !== 'pro') {
                document.getElementById('info-downloads').textContent = "Habis (0)";
            }
        });

        // Initialize UI
        loadState();
        
        // Ensure UI visually matches loaded state selections
        document.querySelectorAll('.layout-card').forEach(c => {
            if(parseInt(c.dataset.layout) === state.layout) c.classList.add('selected');
            else c.classList.remove('selected');
        });
        
        document.querySelectorAll('.effect-card').forEach(c => {
            if(c.dataset.effect === state.selectedEffect) c.classList.add('selected');
            else c.classList.remove('selected');
        });

        updateWizardUI();

    </script>
</body>
</html>
