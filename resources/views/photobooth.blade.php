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
            padding: 2rem 3rem;
            flex: 1;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        
        .wizard-step.active {
            display: flex;
            flex-direction: column;
            opacity: 1;
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
        .tab-btn {
            background: rgba(0,0,0,0.1);
            color: var(--text-muted);
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            flex: 1;
        }

        .theme-dark .tab-btn { background: rgba(255,255,255,0.05); }

        .tab-btn.active {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 4px 10px rgba(85,68,255,0.3);
        }

        .wizard-footer {
            padding: 1.5rem 3rem;
            background: var(--card-bg);
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
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
                <a href="{{ route('hustle-posed.frame-creation') }}" style="text-decoration: none; color: #fff; background: rgba(255,255,255,0.1); padding: 6px 14px; border-radius: 20px; font-weight: 600; font-size: 0.9rem; transition: background 0.3s; border: 1px solid rgba(255,255,255,0.2);">
                    🎨 Custom Frame
                </a>
                <div class="promo-banner" style="background: linear-gradient(135deg, #f59e0b, #ef4444); color: #fff; border:none; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);">
                    <span style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">👑</span> Pro Mode Active
                </div>
                <form method="POST" action="{{ route('hustle-posed.logout') }}" style="margin: 0;" id="logoutForm">
                    @csrf
                    <button type="button" id="btnLogout" onclick="confirmLogout()" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239,68,68,0.3); border-radius: 20px; padding: 6px 14px; font-weight: 600; cursor: pointer; transition: all 0.3s; box-shadow: 0 2px 10px rgba(239,68,68,0.15);">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ auth()->check() ? url('/hustle-posed-pro') : url('/#pricing') }}" class="promo-banner" style="text-decoration:none; cursor:pointer;"><span>✨</span> Level up your moments with HustleSpace!</a>
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
                            <div class="sidebar-title" style="display: flex; gap: 10px; margin-bottom: 10px;">
                                <button id="tab-default-frames" class="tab-btn active">Default</button>
                                <button id="tab-custom-frames" class="tab-btn">Custom Frames</button>
                            </div>
                            <div class="frame-list-grid" id="frame-options">
                                <!-- Default frames injected here via JS -->
                            </div>
                            <div class="frame-list-grid" id="custom-frame-options" style="display:none;">
                                <!-- Custom frames injected here via JS -->
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
                <button class="btn btn-outline" id="btn-back">← Kembali</button>
                <div style="flex:1;"></div>
                <button class="btn btn-outline" id="btn-restart" style="display: none; margin-right: 15px;">Mulai Baru</button>
                <button class="btn btn-primary" id="btn-next">Lanjut →</button>
                <button class="btn btn-primary" id="btn-download" style="display: none; align-items:center; justify-content:center;">↓ Download Foto</button>
            </div>
        </main>
    </div>
    
    <!-- Global Footer -->
    <footer style="text-align: center; padding: 15px; background: var(--bg-color); color: var(--text-muted); font-size: 0.85rem; border-top: 1px solid var(--border-color);">
        &copy; {{ date('Y') }} HustleSpace. All rights reserved.
    </footer>

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
            selectedFrameType: 'default', // 'default' or 'custom'
            customFramesData: [],
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
                selectedFrameType: state.selectedFrameType,
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
                        state.selectedFrameType = parsed.selectedFrameType || 'default';
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
        const btnRestart = document.getElementById('btn-restart');
        
        // Navigation Logic
        function updateWizardUI() {
            const step = state.currentStep;
            
            // Animasi Fade Out step sebelumnya
            const currentStepEl = document.querySelector('.wizard-step.active');
            if (currentStepEl && currentStepEl.id !== `step-${step}`) {
                currentStepEl.style.opacity = '0';
                setTimeout(() => {
                    document.querySelectorAll('.wizard-step').forEach(el => {
                        el.classList.remove('active');
                        el.style.display = 'none';
                    });
                    
                    // Show next step
                    const nextStepEl = document.getElementById(`step-${step}`);
                    nextStepEl.style.display = 'flex';
                    // Trigger reflow
                    void nextStepEl.offsetWidth;
                    nextStepEl.classList.add('active');
                    nextStepEl.style.opacity = '1';
                }, 300); // Wait for fade out
            } else if (!currentStepEl) {
                // Initial load
                document.querySelectorAll('.wizard-step').forEach(el => {
                    el.classList.remove('active');
                    el.style.display = 'none';
                });
                const nextStepEl = document.getElementById(`step-${step}`);
                nextStepEl.style.display = 'flex';
                void nextStepEl.offsetWidth;
                nextStepEl.classList.add('active');
                nextStepEl.style.opacity = '1';
            }

            // Update Steps Nav
            document.querySelectorAll('.step').forEach((el, index) => {
                const stepNum = index + 1;
                const nav = document.getElementById(`nav-step-${stepNum}`);
                const line = document.getElementById(`line-${stepNum}`);
                
                if(stepNum < step) {
                    nav.classList.add('completed'); nav.classList.remove('active');
                    if(line) line.classList.add('active');
                } else if (stepNum === step) {
                    nav.classList.add('active'); nav.classList.remove('completed');
                    if(line) line.classList.remove('active');
                } else {
                    nav.classList.remove('active', 'completed');
                    if(line) line.classList.remove('active');
                }
            });

            // Button visibility & state
            if (state.currentStep === 1) {
                btnBack.style.visibility = 'hidden';
            } else {
                btnBack.style.visibility = 'visible';
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
                btnRestart.style.display = 'inline-flex';
            } else {
                btnNext.style.display = 'inline-flex';
                btnDownload.style.display = 'none';
                btnRestart.style.display = 'none';
            }

            // Specific step initializations
            if (state.currentStep === 2) {
                initStep2();
            } else {
                if (typeof stream !== 'undefined' && stream) {
                    stream.getTracks().forEach(t => t.stop());
                    stream = null;
                }
            }

            if (state.currentStep === 3) {
                document.querySelectorAll('.effect-card').forEach(c => c.classList.remove('selected'));
                const sel = document.querySelector(`.effect-card[data-effect="${state.selectedEffect}"]`);
                if(sel) sel.classList.add('selected');
                initStep3();
            }

            if (state.currentStep === 4) {
                // Render Frame Options
                const opts = document.getElementById('frame-options');
                const customOpts = document.getElementById('custom-frame-options');
                const tabDefault = document.getElementById('tab-default-frames');
                const tabCustom = document.getElementById('tab-custom-frames');
                opts.innerHTML = '';
                
                let cols = 1, rows = 1;
                if (state.layout === 2) { rows = 2; cols = 1; }
                if (state.layout === 4) { rows = 2; cols = 2; }

                themes.forEach((frm, idx) => {
                    const card = document.createElement('div');
                    card.className = `frame-item-card ${state.selectedFrameType === 'default' && idx === state.selectedFrameIndex ? 'selected' : ''}`;
                    card.style.aspectRatio = '2/3';
                    card.style.overflow = 'hidden';
                    card.style.position = 'relative';

                    const cvs = document.createElement('canvas');
                    cvs.width = 160; cvs.height = 240;
                    cvs.style.cssText = 'width:100%;height:100%;display:block;image-rendering:crisp-edges;';
                    drawMiniFrame(cvs, frm.id, cols, rows);

                    card.appendChild(cvs);
                    
                    card.addEventListener('click', () => {
                        document.querySelectorAll('.frame-item-card').forEach(c=>c.classList.remove('selected'));
                        card.classList.add('selected');
                        state.selectedFrameType = 'default';
                        state.selectedFrameIndex = idx;
                        saveState();
                        drawComposition('composition-canvas');
                    });
                    opts.appendChild(card);
                });

                if (tabCustom) {
                    tabDefault.onclick = () => {
                        tabDefault.classList.add('active');
                        tabCustom.classList.remove('active');
                        opts.style.display = 'grid';
                        customOpts.style.display = 'none';
                    };
                    tabCustom.onclick = () => {
                        tabCustom.classList.add('active');
                        tabDefault.classList.remove('active');
                        customOpts.style.display = 'grid';
                        opts.style.display = 'none';
                    };

                    fetch(`/api/photobooth/custom-frames?mode=${state.mode}`)
                        .then(res => res.json())
                        .then(data => {
                            state.customFramesData = data.frames.filter(f => f.layout === state.layout);
                            customOpts.innerHTML = '';
                            if (state.customFramesData.length === 0) {
                                customOpts.innerHTML = '<div style="grid-column: 1/-1; text-align:center; padding: 20px; color: var(--text-muted); font-size: 0.9rem;">Belum ada Custom Frame untuk layout ini. <br><a href="{{ route("hustle-posed.frame-creation") }}" style="color:var(--primary); font-weight:600;">Buat Sekarang</a></div>';
                            } else {
                                state.customFramesData.forEach((frm, idx) => {
                                    const card = document.createElement('div');
                                    card.className = `frame-item-card ${state.selectedFrameType === 'custom' && idx === state.selectedFrameIndex ? 'selected' : ''}`;
                                    card.style.aspectRatio = '2/3';
                                    card.style.overflow = 'hidden';
                                    card.style.position = 'relative';

                                    const cvs = document.createElement('canvas');
                                    cvs.width = 160; cvs.height = 240;
                                    cvs.style.cssText = 'width:100%;height:100%;display:block;border-radius:10px;image-rendering:crisp-edges;';
                                    drawMiniFrame(cvs, frm.base_theme, cols, rows, frm.decorations);

                                    const label = document.createElement('div');
                                    label.innerHTML = `${frm.name}<br><small style="font-size:0.5rem;color:#ccc;">by ${frm.user?.name || 'User'}</small>`;
                                    label.style.cssText = `
                                        position:absolute; bottom:0; left:0; right:0;
                                        background:rgba(0,0,0,0.65);
                                        color:#fff; font-size:0.62rem; font-weight:700;
                                        text-align:center; padding:4px 2px;
                                        border-radius:0 0 10px 10px; letter-spacing:0.02em; line-height:1.2;
                                    `;

                                    card.appendChild(cvs);
                                    card.appendChild(label);
                                    
                                    card.addEventListener('click', () => {
                                        document.querySelectorAll('.frame-item-card').forEach(c=>c.classList.remove('selected'));
                                        card.classList.add('selected');
                                        state.selectedFrameType = 'custom';
                                        state.selectedFrameIndex = idx;
                                        saveState();
                                        drawComposition('composition-canvas');
                                    });
                                    customOpts.appendChild(card);
                                });
                            }
                        })
                        .catch(err => console.error(err));
                }

                // Delay until after fade-in animation so canvas has real dimensions
                setTimeout(() => drawComposition('composition-canvas'), 350);
            }

            if (state.currentStep === 5) {
                // Re-draw final to ensure pristine quality — delay for fade-in
                setTimeout(() => drawComposition('final-canvas'), 350);
                
                // Fetch remaining limits if demo
                if (state.mode !== 'pro') {
                    document.getElementById('info-photos').textContent = "Batas: 3";
                    document.getElementById('info-downloads').textContent = "Batas: 1";
                }
            }
        }

        btnNext.addEventListener('click', () => {
            if (state.currentStep < state.totalSteps) {
                state.currentStep++;
                saveState();
                updateWizardUI();
            }
        });

        btnBack.addEventListener('click', () => {
            if (state.currentStep > 1) {
                state.currentStep--;
                saveState();
                updateWizardUI();
            }
        });
        
        if(btnRestart) {
            btnRestart.addEventListener('click', () => {
                Swal.fire({
                    title: 'Mulai Baru?',
                    text: "Foto sebelumnya akan terhapus.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    cancelButtonColor: '#9ca3af',
                    confirmButtonText: 'Ya, Mulai Baru',
                    cancelButtonText: 'Batal',
                    background: localStorage.getItem('theme') === 'dark' ? '#111827' : '#fff',
                    color: localStorage.getItem('theme') === 'dark' ? '#fff' : '#000'
                }).then((result) => {
                    if (result.isConfirmed) {
                        state.currentStep = 1;
                        state.capturedImages = [];
                        state.selectedEffect = 'filter-none';
                        state.selectedFrameIndex = 0;
                        state.selectedFrameType = 'default';
                        saveState();
                        updateWizardUI();
                    }
                });
            });
        }

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

        // Frame Themes — 21 frames matching the frame selection page
        const themes = [
            { id: 'minimal_clean',  name: 'Minimal Clean' },
            { id: 'purple_vibes',   name: 'Purple Vibes' },
            { id: 'nature_green',   name: 'Nature Green' },
            { id: 'elegant_gold',   name: 'Elegant Gold' },
            { id: 'daily_film',     name: 'Daily Film' },
            { id: 'pastel_dream',   name: 'Pastel Dream' },
            { id: 'party_time',     name: 'Party Time' },
            { id: 'classic_white',  name: 'Classic White' },
            { id: 'grid_tape',      name: 'Grid Tape' },
            { id: 'soft_beige',     name: 'Soft Beige' },
            { id: 'blue_modern',    name: 'Blue Modern' },
            { id: 'black_film2',    name: 'Black Film 2' },
            { id: 'floral',         name: 'Floral' },
            { id: 'fun_doodle',     name: 'Fun Doodle' },
            { id: 'simple_black',   name: 'Simple Black' },
            { id: 'purple_grid',    name: 'Purple Grid' },
            { id: 'film_strip4',    name: 'Film Strip 4' },
            { id: 'cute_pastel',    name: 'Cute Pastel' },
            { id: 'green_garden',   name: 'Green Garden' },
            { id: 'kraft',          name: 'Kraft Memories' },
            { id: 'colorful_pop',   name: 'Colorful Pop' },
        ];

        function drawMiniFrame(canvas, themeId, cols, rows, decorations = [], showLabel = true) {
            const mc = canvas.getContext('2d');
            const W = canvas.width, H = canvas.height;

            const pad   = Math.round(W * 0.07);
            const gap   = Math.round(W * 0.03);
            const btm   = Math.round(H * 0.09);
            const slotW = (W - pad*2 - gap*(cols-1)) / cols;
            const slotH = (H - pad   - btm  - gap*(rows-1)) / rows;

            /* ── helpers ──────────────────────────────────────────── */
            function bg(style) {
                if (style.includes('gradient')) {
                    const stops = [...style.matchAll(/#[0-9a-fA-F]{3,6}/g)].map(m => m[0]);
                    if (stops.length >= 2) {
                        const g = mc.createLinearGradient(0,0,W,H);
                        stops.forEach((c,i) => g.addColorStop(i/(stops.length-1), c));
                        mc.fillStyle = g;
                    } else { mc.fillStyle = '#fff'; }
                    mc.fillRect(0,0,W,H);
                } else {
                    mc.fillStyle = style; mc.fillRect(0,0,W,H);
                }
            }
            function slots(fillColor='rgba(0,0,0,0.12)') {
                for(let r=0;r<rows;r++) for(let c=0;c<cols;c++) {
                    const x = pad + c*(slotW+gap), y = pad + r*(slotH+gap);
                    mc.fillStyle = fillColor;
                    mc.beginPath(); mc.roundRect(x,y,slotW,slotH,2); mc.fill();
                }
            }
            function border(color, lw=2, offset=2) {
                mc.strokeStyle = color; mc.lineWidth = lw;
                mc.strokeRect(offset, offset, W-offset*2, H-offset*2);
            }
            function label(color) {
                if (!showLabel) return;
                mc.fillStyle = color;
                mc.font = `bold ${Math.max(5,W*0.07)}px Inter,sans-serif`;
                mc.textAlign = 'center';
                mc.fillText('HustleSpace', W/2, H - btm*0.55);
                mc.font = `${Math.max(4,W*0.055)}px Inter,sans-serif`;
                mc.globalAlpha = 0.6;
                mc.fillText('Your moment, your way.', W/2, H - btm*0.2);
                mc.globalAlpha = 1;
            }
            function filmHoles(holeColor='rgba(255,255,255,0.85)') {
                const hw=Math.max(2,W*0.05), hh=Math.max(1.5,W*0.035), hsp=slotH/4;
                [pad*0.25, W-pad*0.25-hw].forEach(sx => {
                    for(let ri=0;ri<rows;ri++){
                        const sy = pad + ri*(slotH+gap);
                        for(let hi=0;hi<4;hi++){
                            mc.fillStyle = holeColor;
                            mc.beginPath(); mc.roundRect(sx, sy+hi*hsp+hsp*0.1, hw, hh, 1); mc.fill();
                        }
                    }
                });
            }
            // Tiny star at (x,y) with radius r
            function star(x,y,r,color='rgba(255,255,255,0.7)'){
                mc.fillStyle=color; mc.beginPath();
                for(let i=0;i<5;i++){
                    const a=Math.PI/2+i*Math.PI*0.4;
                    const a2=a+Math.PI*0.2;
                    i===0?mc.moveTo(x+r*Math.cos(a),y-r*Math.sin(a)):mc.lineTo(x+r*Math.cos(a),y-r*Math.sin(a));
                    mc.lineTo(x+r*0.4*Math.cos(a2),y-r*0.4*Math.sin(a2));
                }
                mc.closePath(); mc.fill();
            }
            // Small circle dot
            function dot(x,y,r,color){ mc.fillStyle=color; mc.beginPath(); mc.arc(x,y,r,0,Math.PI*2); mc.fill(); }
            // Corner tape strip
            function tape(x,y,angle=0){
                mc.save(); mc.translate(x,y); mc.rotate(angle);
                mc.fillStyle='rgba(220,210,180,0.65)';
                mc.fillRect(-W*0.12,-H*0.02,W*0.24,H*0.04);
                mc.restore();
            }
            // Leaf shape at (x,y) scaled s, rotated angle
            function leaf(x,y,s,angle,color){
                mc.save(); mc.translate(x,y); mc.rotate(angle); mc.scale(s,s);
                mc.fillStyle=color; mc.beginPath();
                mc.moveTo(0,0); mc.bezierCurveTo(6,-10,14,-6,10,0);
                mc.bezierCurveTo(14,6,6,10,0,0);
                mc.fill(); mc.restore();
            }
            // Small flower
            function flower(x,y,r,pColor,cColor){
                for(let i=0;i<6;i++){
                    const a=i*Math.PI/3;
                    dot(x+Math.cos(a)*r*1.2, y+Math.sin(a)*r*1.2, r, pColor);
                }
                dot(x,y,r*0.9,cColor);
            }
            // Gold corner ornament
            function goldCorner(x,y,flip=false){
                mc.save(); mc.translate(x,y); if(flip) mc.scale(-1,-1);
                mc.strokeStyle='#c9a227'; mc.lineWidth=1;
                mc.beginPath(); mc.moveTo(0,H*0.08); mc.lineTo(0,0); mc.lineTo(W*0.12,0); mc.stroke();
                mc.beginPath(); mc.arc(0,0,W*0.06,0,Math.PI/2); mc.stroke();
                dot(W*0.04,H*0.04,W*0.02,'#e8c441');
                mc.restore();
            }
            // Smiley face
            function smiley(x,y,r,color){
                dot(x,y,r,color);
                mc.fillStyle='#333';
                dot(x-r*0.35,y-r*0.1,r*0.15,'#333');
                dot(x+r*0.35,y-r*0.1,r*0.15,'#333');
                mc.strokeStyle='#333'; mc.lineWidth=r*0.12;
                mc.beginPath(); mc.arc(x,y+r*0.05,r*0.4,0.1,Math.PI-0.1); mc.stroke();
            }
            // Diamond shape
            function diamond(x,y,r,color){
                mc.fillStyle=color; mc.beginPath();
                mc.moveTo(x,y-r); mc.lineTo(x+r*0.6,y); mc.lineTo(x,y+r); mc.lineTo(x-r*0.6,y);
                mc.closePath(); mc.fill();
            }

            /* ── theme switch ─────────────────────────────────────── */
            if (themeId === 'minimal_clean') {
                bg('#ffffff'); border('#e0e0e0',1.5); slots('rgba(0,0,0,0.07)'); label('#444');

            } else if (themeId === 'classic_white') {
                bg('#f9f9f9'); border('#cccccc',1.5); slots('rgba(0,0,0,0.07)'); label('#333');

            } else if (themeId === 'purple_vibes') {
                bg('linear-gradient(135deg,#c9b8ff,#e8d5ff)');
                border('#9b59b6',2); slots('rgba(255,255,255,0.45)');
                // Corner deco flowers + star
                flower(W*0.12,H*0.05,W*0.05,'#e8b4f8','#fff');
                flower(W*0.88,H*0.06,W*0.04,'#c9b8ff','#f8e8ff');
                star(W*0.82,H*0.12,W*0.04,'rgba(180,120,240,0.8)');
                star(W*0.18,H*0.93,W*0.03,'rgba(180,120,240,0.7)');
                dot(W*0.05,H*0.85,W*0.03,'rgba(200,160,255,0.7)');
                label('#4a0080');

            } else if (themeId === 'nature_green') {
                bg('linear-gradient(135deg,#d4edda,#c8e6c0)');
                slots('rgba(255,255,255,0.5)');
                // Botanical leaves
                leaf(W*0.08,H*0.06,1.4,-0.3,'#5a9e6f');
                leaf(W*0.15,H*0.04,1.1,0.5,'#3a7d50');
                leaf(W*0.85,H*0.08,1.3,2.8,'#4a8e60');
                leaf(W*0.92,H*0.15,1.0,3.5,'#5aae70');
                leaf(W*0.1,H*0.92,1.2,0.8,'#5a9e6f');
                leaf(W*0.88,H*0.88,1.1,3.8,'#3a7d50');
                leaf(W*0.03,H*0.5,0.9,1.6,'#6ab880');
                leaf(W*0.96,H*0.5,0.9,-1.6,'#4a8e60');
                label('#1a5c2a');

            } else if (themeId === 'elegant_gold') {
                bg('linear-gradient(135deg,#fffbe6,#fff4c2)');
                // Double gold border
                mc.strokeStyle='#c9a227'; mc.lineWidth=2; mc.strokeRect(2,2,W-4,H-4);
                mc.strokeStyle='#e8c441'; mc.lineWidth=0.8; mc.strokeRect(5,5,W-10,H-10);
                slots('rgba(201,162,39,0.12)');
                goldCorner(0,0,false); goldCorner(W,H,true);
                // small diamond ornaments
                diamond(W/2,H*0.03,W*0.025,'#c9a227');
                diamond(W/2,H*0.97,W*0.025,'#c9a227');
                label('#7a5c00');

            } else if (themeId === 'daily_film') {
                bg('#111111');
                // Film border strips
                mc.fillStyle='#1c1c1c'; mc.fillRect(0,0,pad*0.7,H); mc.fillRect(W-pad*0.7,0,pad*0.7,H);
                slots('rgba(30,30,30,0.9)');
                filmHoles('rgba(255,255,255,0.6)');
                label('#ffffff');

            } else if (themeId === 'pastel_dream') {
                bg('linear-gradient(135deg,#fce4f4,#e4d9ff)');
                slots('rgba(255,255,255,0.5)');
                // Stars + small flowers
                star(W*0.07,H*0.07,W*0.04,'rgba(200,150,255,0.8)');
                star(W*0.92,H*0.06,W*0.035,'rgba(255,150,200,0.8)');
                star(W*0.85,H*0.92,W*0.04,'rgba(180,140,255,0.7)');
                flower(W*0.1,H*0.94,W*0.04,'#f9b8e0','#fff');
                dot(W*0.9,H*0.93,W*0.025,'rgba(200,180,255,0.7)');
                label('#7b2d8b');

            } else if (themeId === 'party_time') {
                bg('#0a0020');
                // Neon border glow
                mc.shadowColor='#c800ff'; mc.shadowBlur=8;
                border('#c800ff',1.5);
                mc.shadowBlur=0;
                slots('rgba(255,255,255,0.07)');
                // Stars scattered
                [[W*0.08,H*0.06],[W*0.88,H*0.08],[W*0.15,H*0.94],[W*0.82,H*0.92],[W*0.5,H*0.04]].forEach(([x,y]) => {
                    star(x,y,W*0.04,'rgba(255,100,255,0.8)');
                });
                dot(W*0.2,H*0.1,W*0.02,'#ffcc00'); dot(W*0.75,H*0.05,W*0.015,'#00ffff');
                label('#ffffff');

            } else if (themeId === 'grid_tape') {
                bg('linear-gradient(135deg,#f5e6c8,#ede0c0)');
                // Grid lines subtle
                mc.strokeStyle='rgba(180,160,120,0.3)'; mc.lineWidth=0.5;
                for(let gx=0;gx<W;gx+=W*0.1){ mc.beginPath();mc.moveTo(gx,0);mc.lineTo(gx,H);mc.stroke(); }
                for(let gy=0;gy<H;gy+=H*0.07){ mc.beginPath();mc.moveTo(0,gy);mc.lineTo(W,gy);mc.stroke(); }
                slots('rgba(255,255,255,0.6)');
                // Tape corners
                tape(W*0.22,pad*0.5, 0.1); tape(W*0.78,pad*0.5,-0.1);
                tape(W*0.22,H-btm*0.5, 0.05); tape(W*0.78,H-btm*0.5,-0.05);
                label('#5c3d1e');

            } else if (themeId === 'soft_beige') {
                bg('linear-gradient(135deg,#f5e6c8,#e8d5b0)');
                border('#c8a878',1.5);
                slots('rgba(255,255,255,0.55)');
                // Diamond pattern corners
                diamond(W*0.08,H*0.04,W*0.04,'rgba(200,160,100,0.5)');
                diamond(W*0.92,H*0.04,W*0.04,'rgba(200,160,100,0.5)');
                diamond(W*0.08,H*0.96,W*0.04,'rgba(200,160,100,0.5)');
                diamond(W*0.92,H*0.96,W*0.04,'rgba(200,160,100,0.5)');
                label('#5c3d1e');

            } else if (themeId === 'blue_modern') {
                bg('linear-gradient(135deg,#b3d9ff,#d0eaff)');
                border('#5ba3e8',2);
                slots('rgba(255,255,255,0.55)');
                dot(W*0.07,H*0.06,W*0.04,'rgba(91,163,232,0.4)');
                dot(W*0.93,H*0.06,W*0.03,'rgba(91,163,232,0.35)');
                dot(W*0.07,H*0.94,W*0.03,'rgba(91,163,232,0.35)');
                label('#003a6b');

            } else if (themeId === 'black_film2') {
                bg('#0a0a0a');
                mc.fillStyle='#141414'; mc.fillRect(0,0,pad*0.65,H); mc.fillRect(W-pad*0.65,0,pad*0.65,H);
                slots('rgba(20,20,20,0.9)');
                filmHoles('rgba(255,255,255,0.55)');
                label('#ffffff');

            } else if (themeId === 'floral') {
                bg('linear-gradient(135deg,#ffd6e7,#ffecf5)');
                slots('rgba(255,255,255,0.55)');
                // Corner floral clusters
                [[W*0.1,H*0.06],[W*0.85,H*0.07],[W*0.12,H*0.92],[W*0.88,H*0.91]].forEach(([x,y],i)=>{
                    const colors=['#ff9eb5','#ff6b9d','#ffc0cb','#ff85a2'];
                    flower(x,y,W*0.045,colors[i%4],'#fff8fa');
                    leaf(x+W*0.08,y-H*0.01,0.9, i%2===0?0.5:-0.5,'#5aae70');
                });
                label('#8b1a4a');

            } else if (themeId === 'fun_doodle') {
                bg('#fffef0');
                border('#555',1);
                slots('rgba(0,0,0,0.06)');
                // Smiley faces + stars
                smiley(W*0.1,H*0.05,W*0.07,'#ffe066');
                smiley(W*0.88,H*0.06,W*0.065,'#ffe066');
                star(W*0.82,H*0.93,W*0.04,'#ffb347');
                star(W*0.17,H*0.93,W*0.035,'#ffb347');
                // wavy doodle border hint
                mc.strokeStyle='rgba(100,100,100,0.2)'; mc.lineWidth=0.8; mc.setLineDash([2,3]);
                mc.strokeRect(8,8,W-16,H-16); mc.setLineDash([]);
                label('#333333');

            } else if (themeId === 'simple_black') {
                bg('#0d0d0d');
                mc.fillStyle='#1a1a1a'; mc.fillRect(2,2,W-4,H-4);
                border('#333',1.5);
                slots('rgba(255,255,255,0.06)');
                label('#ffffff');

            } else if (themeId === 'purple_grid') {
                bg('linear-gradient(135deg,#c9b8ff,#e8d5ff)');
                mc.strokeStyle='rgba(120,80,200,0.15)'; mc.lineWidth=0.5;
                for(let gx=0;gx<W;gx+=W*0.1){ mc.beginPath();mc.moveTo(gx,0);mc.lineTo(gx,H);mc.stroke(); }
                for(let gy=0;gy<H;gy+=H*0.07){ mc.beginPath();mc.moveTo(0,gy);mc.lineTo(W,gy);mc.stroke(); }
                border('#9b59b6',2);
                slots('rgba(255,255,255,0.45)');
                flower(W*0.9,H*0.07,W*0.04,'#e8b4f8','#fff');
                label('#4a0080');

            } else if (themeId === 'film_strip4') {
                bg('#0d0d0d');
                mc.fillStyle='#161616'; mc.fillRect(0,0,pad*0.7,H); mc.fillRect(W-pad*0.7,0,pad*0.7,H);
                slots('rgba(20,20,20,0.9)');
                filmHoles('rgba(255,255,255,0.5)');
                label('#dddddd');

            } else if (themeId === 'cute_pastel') {
                bg('linear-gradient(135deg,#ffe4f0,#fff0e4)');
                slots('rgba(255,255,255,0.55)');
                // Hearts + stars
                [[W*0.1,H*0.05],[W*0.88,H*0.06],[W*0.08,H*0.92],[W*0.9,H*0.93]].forEach(([x,y])=>{
                    mc.fillStyle='rgba(255,120,160,0.7)';
                    mc.font=`${W*0.09}px serif`; mc.textAlign='center';
                    mc.fillText('♥',x,y+W*0.04);
                });
                star(W*0.5,H*0.03,W*0.03,'rgba(255,160,180,0.8)');
                label('#b85c7a');

            } else if (themeId === 'green_garden') {
                bg('linear-gradient(135deg,#e8f5e2,#d4f0c4)');
                slots('rgba(255,255,255,0.55)');
                // Scattered small flowers + leaves
                [[W*0.08,H*0.05],[W*0.9,H*0.07],[W*0.1,H*0.93],[W*0.88,H*0.92]].forEach(([x,y],i)=>{
                    flower(x,y,W*0.045,'#7ecf6e','#fffbe0');
                    leaf(x+W*0.07,y+H*0.01,0.8,i%2===0?0.8:-0.8,'#4a8e50');
                });
                label('#2d5a1b');

            } else if (themeId === 'kraft') {
                bg('linear-gradient(135deg,#c8a96e,#b89050)');
                // Subtle texture lines
                mc.strokeStyle='rgba(80,50,10,0.15)'; mc.lineWidth=0.6;
                for(let y=0;y<H;y+=H*0.06){ mc.beginPath();mc.moveTo(0,y);mc.lineTo(W,y);mc.stroke(); }
                border('#8b6535',2);
                slots('rgba(255,255,255,0.3)');
                tape(W*0.25,pad*0.5,0.08); tape(W*0.75,pad*0.5,-0.08);
                label('#3d2200');

            } else if (themeId === 'colorful_pop') {
                // Rainbow gradient border sections
                const cg = mc.createLinearGradient(0,0,W,H);
                cg.addColorStop(0,'#ff6b9d'); cg.addColorStop(0.33,'#ffcc00');
                cg.addColorStop(0.66,'#00d4ff'); cg.addColorStop(1,'#c800ff');
                mc.fillStyle = cg; mc.fillRect(0,0,W,H);
                // Inner white padding area
                mc.fillStyle='#ffffff'; mc.fillRect(pad*0.5,pad*0.5,W-pad,H-pad);
                slots('rgba(255,100,150,0.1)');
                star(W*0.08,H*0.05,W*0.04,'#ff6b9d');
                star(W*0.9,H*0.06,W*0.04,'#ffcc00');
                label('#333333');

            } else {
                // Fallback
                bg('#ffffff'); slots('rgba(0,0,0,0.08)'); label('#333');
            }

            // Render custom decorations if provided (for custom frame preview in mini)
            if(decorations && decorations.length > 0) {
                if(typeof decorations === 'string') {
                    try { decorations = JSON.parse(decorations); } catch(e){ decorations = []; }
                }
                decorations.forEach(d => {
                    const img = new Image();
                    img.crossOrigin = 'Anonymous';
                    img.onload = () => {
                        const dw = W * (d.width_percent / 100);
                        const dh = H * (d.height_percent / 100);
                        const dx = W * (d.x_percent / 100);
                        const dy = H * (d.y_percent / 100);
                        mc.drawImage(img, dx, dy, dw, dh);
                    };
                    img.src = d.image_url;
                });
            }
        }


        // ============================================================
        // DRAWING ENGINE
        // ============================================================
        function drawComposition(canvasId) {
            const canv = document.getElementById(canvasId);
            const cx = canv.getContext('2d');
            
            let themeId = 'minimal_clean';
            let customDecorations = [];
            
            if (state.selectedFrameType === 'custom' && state.customFramesData[state.selectedFrameIndex]) {
                themeId = state.customFramesData[state.selectedFrameIndex].base_theme;
                customDecorations = state.customFramesData[state.selectedFrameIndex].decorations || [];
                if (typeof customDecorations === 'string') {
                    try { customDecorations = JSON.parse(customDecorations); } catch(e){}
                }
            } else if (state.selectedFrameType === 'default') {
                if(themes[state.selectedFrameIndex]) {
                    themeId = themes[state.selectedFrameIndex].id;
                }
            }

            const photoW = 600;
            const photoH = 450;
            const padding = 45;
            const gap = 18;
            const bottomPad = 90;

            let cols = 1, rows = 1;
            if (state.layout === 2) { rows = 2; cols = 1; }
            if (state.layout === 4) { rows = 2; cols = 2; }

            canv.width  = (photoW * cols) + (padding * 2) + (gap * (cols - 1));
            canv.height = (photoH * rows) + padding + bottomPad + (gap * (rows - 1));

            const W = canv.width;
            const H = canv.height;

            // ── tColor for watermark text only (BG handled by drawMiniFrame offscreen) ──
            const tColorMap = {
                minimal_clean:'#444', classic_white:'#333', purple_vibes:'#4a0080',
                nature_green:'#1a5c2a', elegant_gold:'#7a5c00', daily_film:'#ffffff',
                pastel_dream:'#7b2d8b', party_time:'#ffffff', grid_tape:'#5c3d1e',
                soft_beige:'#5c3d1e', blue_modern:'#003a6b', black_film2:'#ffffff',
                floral:'#8b1a4a', fun_doodle:'#333333', simple_black:'#ffffff',
                purple_grid:'#4a0080', film_strip4:'#dddddd', cute_pastel:'#b85c7a',
                green_garden:'#2d5a1b', kraft:'#3d2200', colorful_pop:'#333333',
            };
            const tColor = tColorMap[themeId] || '#000000';

            function drawWatermark() {
                cx.fillStyle = tColor;
                cx.font = 'bold 32px "Inter", sans-serif';
                cx.textAlign = 'center';
                cx.fillText('HustleSpace', W/2, H - 44);
                cx.font = '15px "Inter", sans-serif';
                cx.globalAlpha = 0.65;
                cx.fillText('Capture. Create. Share.', W/2, H - 22);
                cx.globalAlpha = 1.0;
            }

            function applyFilter(cx, x, y, w, h) {
                if (state.selectedEffect === 'filter-bw') {
                    const imgData = cx.getImageData(x, y, w, h);
                    const d = imgData.data;
                    for(let i=0; i<d.length; i+=4) {
                        const gray = 0.299*d[i] + 0.587*d[i+1] + 0.114*d[i+2];
                        d[i] = d[i+1] = d[i+2] = gray;
                    }
                    cx.putImageData(imgData, x, y);
                } else if (state.selectedEffect === 'filter-sepia') {
                    const imgData = cx.getImageData(x, y, w, h);
                    const d = imgData.data;
                    for(let i=0; i<d.length; i+=4) {
                        const r = d[i], g = d[i+1], b = d[i+2];
                        d[i] = (r*0.393)+(g*0.769)+(b*0.189);
                        d[i+1] = (r*0.349)+(g*0.686)+(b*0.168);
                        d[i+2] = (r*0.272)+(g*0.534)+(b*0.131);
                    }
                    cx.putImageData(imgData, x, y);
                }
            }
            
            function drawDecorations(layer) {
                return new Promise(resolve => {
                    if(!customDecorations || customDecorations.length === 0) return resolve();

                    // Support both old format (is_front/x/y) and new format (zIndex_mode/x_percent/y_percent)
                    const toDraw = customDecorations.filter(d => {
                        const isFront = (d.zIndex_mode === 'front') || (d.is_front === true) || (d.is_front === 1);
                        return layer === 'front' ? isFront : !isFront;
                    });
                    if(toDraw.length === 0) return resolve();

                    let loaded = 0;
                    toDraw.forEach(dec => {
                        const img = new Image();
                        img.crossOrigin = 'Anonymous';
                        img.onload = () => {
                            // New format: x_percent/y_percent/width_percent/height_percent
                            if (dec.x_percent !== undefined) {
                                const dx = W * (dec.x_percent / 100);
                                const dy = H * (dec.y_percent / 100);
                                const dw = W * (dec.width_percent / 100);
                                const dh = H * (dec.height_percent / 100);
                                cx.drawImage(img, dx, dy, dw, dh);
                            } else {
                                // Old format: absolute x/y with rotation/scale
                                cx.save();
                                cx.translate(dec.x || 0, dec.y || 0);
                                cx.rotate((dec.rotation || 0) * Math.PI / 180);
                                cx.scale(dec.scale || 1, dec.scale || 1);
                                cx.drawImage(img, -img.width/2, -img.height/2);
                                cx.restore();
                            }
                            loaded++;
                            if(loaded === toDraw.length) resolve();
                        };
                        img.onerror = () => {
                            loaded++;
                            if(loaded === toDraw.length) resolve();
                        };
                        // Support both image_url and url field names
                        img.src = dec.image_url || dec.url || '';
                    });
                });
            }

            function drawPhotos() {
                return new Promise(resolve => {
                    let loaded = 0;
                    const count = state.capturedImages.length;
                    if (count === 0) return resolve();

                    // ── Use SAME slot formula as drawMiniFrame ──
                    const pad  = Math.round(W * 0.07);
                    const gapP = Math.round(W * 0.03);
                    const btm  = Math.round(H * 0.09);
                    const slotW = (W - pad*2 - gapP*(cols-1)) / cols;
                    const slotH = (H - pad   - btm  - gapP*(rows-1)) / rows;

                    state.capturedImages.forEach((src, i) => {
                        const img = new Image();
                        img.onload = () => {
                            // Calculate slot position for index i
                            const col = cols === 2 ? (i % 2) : 0;
                            const row = rows === 1 ? 0 : (cols === 2 ? Math.floor(i/2) : i);
                            const slotX = pad  + col * (slotW + gapP);
                            const slotY = pad  + row * (slotH + gapP);

                            // Clip to slot so photo doesn't overflow over frame border
                            cx.save();
                            cx.beginPath();
                            cx.rect(slotX, slotY, slotW, slotH);
                            cx.clip();

                            // Mirror-flip the photo (webcam mirror)
                            cx.translate(slotX + slotW, slotY);
                            cx.scale(-1, 1);

                            // Center-crop to fill slot
                            const ir = img.width / img.height;
                            const pr = slotW / slotH;
                            let sx=0, sy=0, sw=img.width, sh=img.height;
                            if (ir > pr) { sw = img.height * pr; sx = (img.width - sw) / 2; }
                            else         { sh = img.width  / pr; sy = (img.height - sh) / 2; }

                            cx.drawImage(img, sx, sy, sw, sh, 0, 0, slotW, slotH);
                            cx.restore();

                            applyFilter(cx, slotX, slotY, slotW, slotH);

                            loaded++;
                            if (loaded === count) resolve();
                        };
                        img.src = src;
                    });
                });
            }

            function finalizeLayout() {
                // Step 1: Draw full frame (BG + border decorations) onto offscreen
                const offBg = document.createElement('canvas');
                offBg.width = W; offBg.height = H;
                drawMiniFrame(offBg, themeId, cols, rows, customDecorations, false);
                cx.drawImage(offBg, 0, 0);

                // Step 2: Draw photos in correct slots (clips to slot boundaries)
                drawPhotos().then(() => {
                    // Step 3: Re-draw frame ON TOP of photos (border/deco overlay)
                    // Uses a blank offscreen so only drawn pixels composite over photos
                    const offFg = document.createElement('canvas');
                    offFg.width = W; offFg.height = H;
                    drawMiniFrame(offFg, themeId, cols, rows, [], false);

                    // Only paint border area pixels (mask out photo slot regions)
                    const fgCtx = offFg.getContext('2d');
                    const pad  = Math.round(W * 0.07);
                    const gapP = Math.round(W * 0.03);
                    const btm  = Math.round(H * 0.09);
                    const slotW = (W - pad*2 - gapP*(cols-1)) / cols;
                    const slotH = (H - pad   - btm  - gapP*(rows-1)) / rows;
                    // Erase the slot regions from the overlay so photos show through
                    fgCtx.globalCompositeOperation = 'destination-out';
                    for (let r = 0; r < rows; r++) {
                        for (let c = 0; c < cols; c++) {
                            fgCtx.fillStyle = 'rgba(0,0,0,1)';
                            fgCtx.fillRect(
                                pad + c*(slotW+gapP),
                                pad + r*(slotH+gapP),
                                slotW, slotH
                            );
                        }
                    }
                    // Also erase watermark area so our drawWatermark controls it
                    fgCtx.fillRect(0, H - btm, W, btm);
                    fgCtx.globalCompositeOperation = 'source-over';

                    // Composite border overlay on top of photos
                    cx.drawImage(offFg, 0, 0);

                    // Step 4: Front custom stickers (user-uploaded, zIndex=front)
                    drawDecorations('front').then(() => {
                        // Step 5: Watermark
                        drawWatermark();
                    });
                });
            }

            finalizeLayout();
        }

        // Download logic
        btnDownload.addEventListener('click', async () => {
            if (state.mode !== 'pro') {
                try {
                    const res = await fetch('/api/photobooth/download-usage', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': state.csrfToken
                        }
                    });
                    const data = await res.json();
                    if (!data.success) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Batas Tercapai',
                            text: 'Mode Demo hanya dapat mengunduh 1 foto. Upgrade ke Pro untuk unduhan tanpa batas!',
                            background: localStorage.getItem('theme') === 'dark' ? '#111827' : '#fff',
                            color: localStorage.getItem('theme') === 'dark' ? '#fff' : '#000'
                        });
                        return;
                    }
                } catch(e) {
                    console.error(e);
                }
            }
            
            const originalHTML = btnDownload.innerHTML;
            btnDownload.innerHTML = `<svg style="animation: spin 1s linear infinite; height: 1.2rem; width: 1.2rem; margin-right: 8px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...`;
            btnDownload.disabled = true;

            setTimeout(() => {
                const canv = document.getElementById('final-canvas');
                const link = document.createElement('a');
                link.download = `hustlespace-${Date.now()}.png`;
                link.href = canv.toDataURL('image/png', 1.0);
                link.click();
                
                btnDownload.innerHTML = originalHTML;
                btnDownload.disabled = false;
            }, 800);
        });

        function confirmLogout() {
            Swal.fire({
                title: 'Logout',
                text: "Apakah Anda yakin ingin keluar?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                background: localStorage.getItem('theme') === 'dark' ? '#111827' : '#fff',
                color: localStorage.getItem('theme') === 'dark' ? '#fff' : '#000'
            }).then((result) => {
                if (result.isConfirmed) {
                    const btn = document.getElementById('btnLogout');
                    if(btn) {
                        btn.innerHTML = `<svg style="animation: spin 1s linear infinite; height: 1.2rem; width: 1.2rem; margin-right: 8px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Keluar...`;
                    }
                    document.getElementById('logoutForm').submit();
                }
            });
        }

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
