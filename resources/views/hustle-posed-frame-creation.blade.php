<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Frame Creator — HustleSpace Photobooth</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #5544ff;
            --primary-hover: #4433ee;
            --primary-glow: rgba(85,68,255,0.18);
            --bg: #0d0d12;
            --surface: #15151e;
            --card: #1c1c28;
            --card-hover: #222230;
            --border: rgba(255,255,255,0.08);
            --border-accent: rgba(85,68,255,0.35);
            --text: #f0f0f8;
            --muted: #8888aa;
            --danger: #ef4444;
            --success: #10b981;
            --warning: #f59e0b;
        }

        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── NAVBAR ──────────────────────────────────── */
        .navbar {
            background: rgba(13,13,18,0.92);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            padding: 0 28px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .navbar-brand img {
            height: 34px;
            object-fit: contain;
        }
        .navbar-subtitle {
            font-size: 0.7rem;
            color: var(--muted);
            font-weight: 400;
        }
        .navbar-title-wrap { display: flex; flex-direction: column; }
        .navbar-title-wrap span { font-size: 0.85rem; font-weight: 700; color: var(--text); }

        .navbar-center {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 6px 14px;
        }
        .navbar-center span { font-size: 0.82rem; color: var(--primary); font-weight: 700; }
        .navbar-center small { font-size: 0.72rem; color: var(--muted); }

        .navbar-right { display: flex; align-items: center; gap: 10px; }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 9px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-hover); transform: translateY(-1px); box-shadow: 0 6px 18px rgba(85,68,255,0.35); }
        .btn-ghost { background: transparent; color: var(--muted); border: 1px solid var(--border); }
        .btn-ghost:hover { background: var(--card); color: var(--text); border-color: var(--border-accent); }
        .btn-danger-soft { background: rgba(239,68,68,0.12); color: var(--danger); border: 1px solid rgba(239,68,68,0.2); }
        .btn-danger-soft:hover { background: rgba(239,68,68,0.2); }
        .btn-success-soft { background: rgba(16,185,129,0.12); color: var(--success); border: 1px solid rgba(16,185,129,0.2); }
        .btn-sm { padding: 5px 11px; font-size: 0.75rem; }

        /* ── MAIN CONTENT ─────────────────────────────── */
        .main {
            flex: 1;
            padding: 28px;
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 24px;
            max-width: 1240px;
            margin: 0 auto;
            width: 100%;
        }

        /* ── EDITOR PANEL ─────────────────────────────── */
        .editor-panel {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
        }
        .panel-header {
            background: var(--card);
            padding: 16px 22px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .panel-header-icon {
            width: 32px; height: 32px;
            background: var(--primary-glow);
            border: 1px solid var(--border-accent);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
        }
        .panel-header h2 {
            font-size: 0.95rem;
            font-weight: 700;
        }
        .panel-header small { color: var(--muted); font-size: 0.75rem; }

        .panel-body { padding: 22px; }

        /* ── FORM ──────────────────────────────────────── */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 14px;
        }
        .form-grid-full { grid-column: 1/-1; }

        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* ── CUSTOM SELECT ─────────────────────────────── */
        .custom-select-wrapper { position: relative; }
        .custom-select-wrapper::after {
            content: '▾';
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            pointer-events: none;
            font-size: 0.85rem;
        }
        select {
            width: 100%;
            padding: 10px 36px 10px 12px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 9px;
            color: var(--text);
            font-size: 0.84rem;
            font-family: 'Inter', sans-serif;
            appearance: none;
            -webkit-appearance: none;
            cursor: pointer;
            transition: border-color 0.2s;
            outline: none;
        }
        select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-glow); }
        select option {
            background: #1c1c28;
            color: var(--text);
            padding: 8px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px 12px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 9px;
            color: var(--text);
            font-size: 0.84rem;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.2s;
            outline: none;
        }
        input[type="text"]:focus { border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-glow); }
        input[type="text"]::placeholder { color: var(--muted); }

        /* ── FILE UPLOAD ZONE ──────────────────────────── */
        .upload-zone {
            border: 2px dashed var(--border);
            border-radius: 12px;
            padding: 18px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            background: var(--card);
        }
        .upload-zone:hover { border-color: var(--primary); background: var(--primary-glow); }
        .upload-zone input[type="file"] {
            position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
        }
        .upload-zone-icon { font-size: 1.8rem; margin-bottom: 6px; }
        .upload-zone p { font-size: 0.82rem; color: var(--muted); }
        .upload-zone strong { color: var(--primary); }
        .upload-zone small { display: block; margin-top: 4px; font-size: 0.72rem; color: var(--muted); opacity: 0.7; }

        /* ── CANVAS PREVIEW ─────────────────────────────── */
        .canvas-section {
            margin-top: 20px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px;
        }
        .canvas-section-title {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .preview-wrapper {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
            aspect-ratio: 2/3;
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 16px 48px rgba(0,0,0,0.6), 0 0 0 1px var(--border);
        }
        #baseBg { position: absolute; inset: 0; z-index: 0; }
        .slot {
            position: absolute;
            background: rgba(0,0,0,0.12);
            border: 1.5px dashed rgba(255,255,255,0.2);
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.25);
            font-size: 0.7rem;
        }
        .draggable-item { position: absolute; cursor: move; border: 1px dashed transparent; }
        .draggable-item.selected { border: 1px dashed var(--primary); border-radius: 3px; }
        .draggable-item img { width: 100%; height: 100%; pointer-events: none; object-fit: contain; }
        .resize-handle {
            position: absolute; bottom: -5px; right: -5px;
            width: 10px; height: 10px;
            background: var(--primary); border-radius: 50%; cursor: se-resize; display: none;
        }
        .draggable-item.selected .resize-handle { display: block; }

        /* ── STICKER TOOLBAR ────────────────────────────── */
        .sticker-toolbar {
            display: none;
            align-items: center;
            gap: 8px;
            margin-top: 14px;
            padding: 10px 14px;
            background: rgba(85,68,255,0.08);
            border: 1px solid var(--border-accent);
            border-radius: 10px;
            flex-wrap: wrap;
        }
        .sticker-toolbar.visible { display: flex; }
        .sticker-toolbar span { font-size: 0.75rem; color: var(--muted); margin-right: 4px; }

        /* ── ACTIONS ────────────────────────────────────── */
        .action-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 18px;
            flex-wrap: wrap;
        }

        /* ── SIDEBAR ────────────────────────────────────── */
        .sidebar { display: flex; flex-direction: column; gap: 18px; }

        .sidebar-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
        }
        .sidebar-card-header {
            background: var(--card);
            padding: 13px 18px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .sidebar-card-header h3 {
            font-size: 0.85rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 7px;
        }
        .badge {
            background: var(--primary-glow);
            color: var(--primary);
            border: 1px solid var(--border-accent);
            font-size: 0.7rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
        }
        .sidebar-card-body { padding: 14px 16px; }

        .frame-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 12px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 10px;
            margin-bottom: 10px;
            transition: border-color 0.2s;
        }
        .frame-item:hover { border-color: var(--border-accent); }
        .frame-item:last-child { margin-bottom: 0; }
        .frame-item-icon {
            width: 36px; height: 36px;
            background: var(--primary-glow);
            border: 1px solid var(--border-accent);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }
        .frame-item-info { flex: 1; min-width: 0; }
        .frame-item-name { font-size: 0.82rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .frame-item-meta { font-size: 0.7rem; color: var(--muted); margin-top: 2px; }
        .frame-item-actions { display: flex; gap: 5px; flex-shrink: 0; }

        .empty-state {
            text-align: center;
            padding: 28px 16px;
            color: var(--muted);
        }
        .empty-state .empty-icon { font-size: 2rem; margin-bottom: 8px; }
        .empty-state p { font-size: 0.82rem; }

        /* ── TIPS CARD ──────────────────────────────────── */
        .tips-list { list-style: none; }
        .tips-list li {
            font-size: 0.78rem;
            color: var(--muted);
            padding: 6px 0;
            border-bottom: 1px solid var(--border);
            display: flex;
            gap: 7px;
        }
        .tips-list li:last-child { border-bottom: none; }
        .tips-list li::before { content: '✦'; color: var(--primary); font-size: 0.65rem; margin-top: 2px; }

        /* ── FOOTER ─────────────────────────────────────── */
        footer {
            background: var(--surface);
            border-top: 1px solid var(--border);
            padding: 16px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        footer p { font-size: 0.75rem; color: var(--muted); }
        footer a { color: var(--primary); text-decoration: none; }

        /* ── SCROLLBAR ──────────────────────────────────── */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(85,68,255,0.3); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(85,68,255,0.55); }

        /* ── RESPONSIVE HINT ─────────────────────────────── */
        @media(max-width: 900px) {
            .main { grid-template-columns: 1fr; }
            .navbar-center { display: none; }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <a href="{{ route('hustle-posed.pro') }}" class="navbar-brand">
            <img src="{{ asset('assets/hustle/hustle-space-logo-white.png') }}" alt="HustleSpace">
            <div class="navbar-title-wrap">
                <span>HustleSpace</span>
                <span class="navbar-subtitle">Photobooth Pro</span>
            </div>
        </a>

        <div class="navbar-center">
            <span>🎨</span>
            <div>
                <span>Custom Frame Creator</span><br>
                <small>Design your own photobooth frame</small>
            </div>
        </div>

        <div class="navbar-right">
            <a href="{{ route('hustle-posed.pro') }}" class="btn btn-ghost">
                ← Kembali ke Photobooth
            </a>
        </div>
    </nav>

    <!-- MAIN -->
    <div class="main">

        <!-- LEFT: EDITOR -->
        <div class="editor-panel">
            <div class="panel-header">
                <div class="panel-header-icon">🖼️</div>
                <div>
                    <h2>Buat Frame Baru</h2>
                    <small>Desain frame kustom Anda dengan stiker dekorasi PNG</small>
                </div>
            </div>

            <div class="panel-body">
                <!-- Form Controls -->
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nama Frame</label>
                        <input type="text" id="frameName" placeholder="Contoh: My Sweet 17">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Layout Foto</label>
                        <div class="custom-select-wrapper">
                            <select id="frameLayout" onchange="updatePreview()">
                                <option value="1">1 Foto (Single)</option>
                                <option value="2">2 Foto (Dual)</option>
                                <option value="4">4 Foto (Grid)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-grid-full">
                        <label class="form-label">Base Theme (Background & Frame Default)</label>
                        <div class="custom-select-wrapper">
                            <select id="baseTheme" onchange="updatePreview()">
                                <!-- Populated by JS -->
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Upload Zone -->
                <div class="form-group" style="margin-top:4px;">
                    <label class="form-label">Dekorasi / Stiker PNG</label>
                    <div class="upload-zone">
                        <input type="file" id="imageUpload" accept=".png" onchange="handleUpload(this)">
                        <div class="upload-zone-icon">🖼️</div>
                        <p><strong>Klik atau seret file PNG</strong> ke sini</p>
                        <small>Maksimal 4 gambar · maks 256KB per file · hanya PNG</small>
                    </div>
                </div>

                <!-- Canvas Preview -->
                <div class="canvas-section">
                    <div class="canvas-section-title">
                        <span>👁️</span> Live Preview — <span style="color:var(--primary)">WYSIWYG</span>
                    </div>
                    <div class="preview-wrapper" id="previewContainer">
                        <div id="baseBg"></div>
                        <!-- Slots & stickers injected here -->
                    </div>

                    <!-- Sticker toolbar -->
                    <div class="sticker-toolbar" id="selectedTools">
                        <span>Stiker terpilih:</span>
                        <button class="btn btn-ghost btn-sm" onclick="setLayer('back')">↓ Ke Belakang Foto</button>
                        <button class="btn btn-ghost btn-sm" onclick="setLayer('front')">↑ Ke Depan Foto</button>
                        <button class="btn btn-danger-soft btn-sm" onclick="deleteSelectedItem()">🗑 Hapus</button>
                    </div>
                </div>

                <!-- Action Bar -->
                <div class="action-bar">
                    <button class="btn btn-primary" onclick="saveFrame()" id="saveBtn">
                        💾 Simpan Frame
                    </button>
                    <span style="font-size:0.76rem; color:var(--muted);">
                        Stiker bisa digeser & diubah ukuran
                    </span>
                </div>
            </div>
        </div>

        <!-- RIGHT: SIDEBAR -->
        <div class="sidebar">

            <!-- My Frames -->
            <div class="sidebar-card">
                <div class="sidebar-card-header">
                    <h3>
                        🗂 Frame Saya
                        <span class="badge" id="frameCount">{{ $frames->count() }}/3</span>
                    </h3>
                </div>
                <div class="sidebar-card-body">
                    @if($frames->count() === 0)
                    <div class="empty-state">
                        <div class="empty-icon">🖼️</div>
                        <p>Belum ada frame. Buat frame pertamamu!</p>
                    </div>
                    @else
                    <div id="frameListContainer">
                        @foreach($frames as $f)
                        <div class="frame-item" id="frame-row-{{$f->id}}">
                            <div class="frame-item-icon">🎨</div>
                            <div class="frame-item-info">
                                <div class="frame-item-name">{{ $f->name }}</div>
                                <div class="frame-item-meta">{{ $f->layout }} Foto · {{ $f->base_theme }}</div>
                            </div>
                            <div class="frame-item-actions">
                                <button class="btn btn-sm {{ $f->is_public ? 'btn-success-soft' : 'btn-ghost' }}"
                                    onclick="togglePublish({{$f->id}})">
                                    {{ $f->is_public ? '🌐' : '🔒' }}
                                </button>
                                <button class="btn btn-danger-soft btn-sm" onclick="deleteFrame({{$f->id}})">
                                    🗑
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Tips -->
            <div class="sidebar-card">
                <div class="sidebar-card-header">
                    <h3>💡 Tips</h3>
                </div>
                <div class="sidebar-card-body">
                    <ul class="tips-list">
                        <li>Upload stiker PNG transparan untuk hasil terbaik.</li>
                        <li>Seret stiker untuk ubah posisinya di kanvas.</li>
                        <li>Klik handle pojok bawah kanan stiker untuk resize.</li>
                        <li>"Ke Belakang Foto" → stiker ada di balik foto.</li>
                        <li>"Ke Depan Foto" → stiker menutupi foto.</li>
                        <li>Maks 4 stiker per frame, maks 256KB/file.</li>
                        <li>Frame yang disimpan dapat dipakai di Photobooth Pro.</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        <p>© 2026 <a href="/">HustleSpace</a>. All rights reserved.</p>
        <p style="font-size:0.72rem; color:var(--muted);">Custom Frame Creator · Pro Mode Only</p>
    </footer>

    <script>
        // ── Themes (must match photobooth) ──────────────────────────────
        const themes = [
            {id:'minimal_clean',  name:'Minimal Clean'},
            {id:'purple_vibes',   name:'Purple Vibes'},
            {id:'nature_green',   name:'Nature Green'},
            {id:'elegant_gold',   name:'Elegant Gold'},
            {id:'daily_film',     name:'Daily Film'},
            {id:'pastel_dream',   name:'Pastel Dream'},
            {id:'party_time',     name:'Party Time'},
            {id:'classic_white',  name:'Classic White'},
            {id:'grid_tape',      name:'Grid Tape'},
            {id:'soft_beige',     name:'Soft Beige'},
            {id:'blue_modern',    name:'Blue Modern'},
            {id:'black_film2',    name:'Black Film 2'},
            {id:'floral',         name:'Floral'},
            {id:'fun_doodle',     name:'Fun Doodle'},
            {id:'simple_black',   name:'Simple Black'},
            {id:'purple_grid',    name:'Purple Grid'},
            {id:'film_strip4',    name:'Film Strip 4'},
            {id:'cute_pastel',    name:'Cute Pastel'},
            {id:'green_garden',   name:'Green Garden'},
            {id:'kraft',          name:'Kraft Memories'},
            {id:'colorful_pop',   name:'Colorful Pop'},
        ];

        const selTheme = document.getElementById('baseTheme');
        themes.forEach(t => {
            const opt = document.createElement('option');
            opt.value = t.id; opt.textContent = t.name;
            selTheme.appendChild(opt);
        });

        // ── App State ────────────────────────────────────────────────────
        let decorations = [];
        let selectedElement = null;
        const preview = document.getElementById('previewContainer');

        // ── Theme BG helper (reuse from photobooth theme colors) ─────────
        const themeBgs = {
            minimal_clean: '#ffffff',
            classic_white: '#f9f9f9',
            purple_vibes: 'linear-gradient(135deg,#c9b8ff,#e8d5ff)',
            nature_green: 'linear-gradient(135deg,#d4edda,#c8e6c0)',
            elegant_gold: 'linear-gradient(135deg,#fffbe6,#fff4c2)',
            daily_film: '#111111',
            pastel_dream: 'linear-gradient(135deg,#fce4f4,#e4d9ff)',
            party_time: '#0a0020',
            grid_tape: 'linear-gradient(135deg,#f5e6c8,#ede0c0)',
            soft_beige: 'linear-gradient(135deg,#f5e6c8,#e8d5b0)',
            blue_modern: 'linear-gradient(135deg,#b3d9ff,#d0eaff)',
            black_film2: '#0a0a0a',
            floral: 'linear-gradient(135deg,#ffd6e7,#ffecf5)',
            fun_doodle: '#fffef0',
            simple_black: '#0d0d0d',
            purple_grid: 'linear-gradient(135deg,#c9b8ff,#e8d5ff)',
            film_strip4: '#0d0d0d',
            cute_pastel: 'linear-gradient(135deg,#ffe4f0,#fff0e4)',
            green_garden: 'linear-gradient(135deg,#e8f5e2,#d4f0c4)',
            kraft: 'linear-gradient(135deg,#c8a96e,#b89050)',
            colorful_pop: 'linear-gradient(135deg,#ff6b9d,#ffc93c)',
        };

        function updatePreview() {
            const layout = parseInt(document.getElementById('frameLayout').value);
            const themeId = document.getElementById('baseTheme').value;
            const bg = themeBgs[themeId] || '#fff';

            document.getElementById('baseBg').style.background = bg;

            // Clear slots
            preview.querySelectorAll('.slot').forEach(e => e.remove());

            const W = preview.offsetWidth;
            const H = preview.offsetHeight;
            let rows = 1, cols = 1;
            if (layout === 2) { rows = 2; }
            if (layout === 4) { rows = 2; cols = 2; }

            const padPx = Math.round(W * 0.07);
            const gapPx = Math.round(W * 0.03);
            const btmPx = Math.round(H * 0.09);

            const slotW_px = (W - padPx*2 - gapPx*(cols-1)) / cols;
            const slotH_px = (H - padPx - btmPx - gapPx*(rows-1)) / rows;

            for (let r = 0; r < rows; r++) {
                for (let c = 0; c < cols; c++) {
                    const slot = document.createElement('div');
                    slot.className = 'slot';
                    slot.style.zIndex = '10';
                    const x = padPx + c*(slotW_px + gapPx);
                    const y = padPx + r*(slotH_px + gapPx);
                    slot.style.left = x + 'px';
                    slot.style.top = y + 'px';
                    slot.style.width = slotW_px + 'px';
                    slot.style.height = slotH_px + 'px';
                    slot.textContent = `Foto ${r*cols+c+1}`;
                    preview.appendChild(slot);
                }
            }
        }

        window.addEventListener('resize', updatePreview);
        setTimeout(updatePreview, 100);

        // ── Upload Handling ──────────────────────────────────────────────
        function handleUpload(input) {
            if (!input.files || input.files.length === 0) return;
            if (decorations.length >= 4) {
                alert('Maksimal 4 gambar dekorasi!');
                return;
            }
            const file = input.files[0];
            if (file.size > 256 * 1024) {
                alert('Ukuran file maksimal 256KB!');
                return;
            }
            const formData = new FormData();
            formData.append('image', file);
            formData.append('_token', '{{ csrf_token() }}');

            fetch('/api/photobooth/custom-frames/upload', {
                method: 'POST',
                body: formData
            }).then(r => r.json()).then(data => {
                if (data.url) { addDecorationToCanvas(data.url); }
            }).catch(() => alert('Gagal mengupload gambar.'));
            input.value = '';
        }

        function addDecorationToCanvas(url) {
            const decId = 'dec_' + Date.now();
            const el = document.createElement('div');
            el.className = 'draggable-item';
            el.id = decId;
            el.style.left = '35%'; el.style.top = '35%';
            el.style.width = '30%'; el.style.zIndex = '15';

            const img = document.createElement('img');
            img.src = url;
            const handle = document.createElement('div');
            handle.className = 'resize-handle';
            el.appendChild(img);
            el.appendChild(handle);
            preview.appendChild(el);

            img.onload = () => {
                const pctH = (el.offsetHeight / preview.offsetHeight) * 100;
                el.style.height = pctH + '%';
                decorations.push({ id: decId, url, zIndex_mode: 'front' });
            };

            makeDraggableAndResizable(el, handle);
            el.addEventListener('mousedown', e => { e.stopPropagation(); selectElement(el); });
        }

        function selectElement(el) {
            document.querySelectorAll('.draggable-item').forEach(e => e.classList.remove('selected'));
            const toolbar = document.getElementById('selectedTools');
            if (el) {
                el.classList.add('selected');
                selectedElement = el;
                toolbar.classList.add('visible');
            } else {
                selectedElement = null;
                toolbar.classList.remove('visible');
            }
        }
        preview.addEventListener('mousedown', () => selectElement(null));

        function deleteSelectedItem() {
            if (selectedElement) {
                decorations = decorations.filter(d => d.id !== selectedElement.id);
                selectedElement.remove();
                selectElement(null);
            }
        }

        function setLayer(mode) {
            if (!selectedElement) return;
            const dec = decorations.find(d => d.id === selectedElement.id);
            if (dec) {
                dec.zIndex_mode = mode;
                selectedElement.style.zIndex = mode === 'front' ? '15' : '5';
            }
        }

        function makeDraggableAndResizable(el, handle) {
            let isDragging = false, isResizing = false;
            let startX, startY, startW, startH, startLeft, startTop;

            el.addEventListener('mousedown', e => {
                if (e.target === handle) { isResizing = true; }
                else { isDragging = true; }
                startX = e.clientX; startY = e.clientY;
                startW = el.offsetWidth; startH = el.offsetHeight;
                startLeft = el.offsetLeft; startTop = el.offsetTop;
                e.preventDefault();
            });

            document.addEventListener('mousemove', e => {
                if (!isDragging && !isResizing) return;
                const W = preview.offsetWidth, H = preview.offsetHeight;
                if (isDragging) {
                    el.style.left = ((startLeft + e.clientX - startX) / W * 100) + '%';
                    el.style.top  = ((startTop  + e.clientY - startY) / H * 100) + '%';
                }
                if (isResizing) {
                    const newW = startW + (e.clientX - startX);
                    const aspect = startW / startH;
                    el.style.width  = (newW / W * 100) + '%';
                    el.style.height = ((newW / aspect) / H * 100) + '%';
                }
            });
            document.addEventListener('mouseup', () => { isDragging = false; isResizing = false; });
        }

        // ── Save Frame ───────────────────────────────────────────────────
        function saveFrame() {
            const name = document.getElementById('frameName').value.trim();
            if (!name) { alert('Nama frame wajib diisi!'); return; }

            const btn = document.getElementById('saveBtn');
            btn.disabled = true;
            btn.innerHTML = '<svg style="animation:spin 1s linear infinite;width:14px;height:14px;display:inline-block;vertical-align:middle;margin-right:6px;" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" opacity=".25"/><path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" opacity=".75"/></svg> Menyimpan...';

            const W = preview.offsetWidth, H = preview.offsetHeight;
            const finalDecorations = decorations.map(d => {
                const el = document.getElementById(d.id);
                return {
                    image_url: d.url,
                    x_percent: (el.offsetLeft / W) * 100,
                    y_percent: (el.offsetTop / H) * 100,
                    width_percent: (el.offsetWidth / W) * 100,
                    height_percent: (el.offsetHeight / H) * 100,
                    zIndex_mode: d.zIndex_mode
                };
            });

            fetch('/api/photobooth/custom-frames', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    name,
                    layout: document.getElementById('frameLayout').value,
                    base_theme: document.getElementById('baseTheme').value,
                    decorations: finalDecorations,
                    _token: '{{ csrf_token() }}'
                })
            }).then(r => r.json()).then(res => {
                if (res.success) {
                    alert('✅ Frame berhasil disimpan!');
                    window.location.reload();
                } else {
                    alert('Gagal: ' + (res.message || 'Unknown error'));
                    btn.disabled = false;
                    btn.innerHTML = '💾 Simpan Frame';
                }
            }).catch(() => {
                alert('Terjadi kesalahan server.');
                btn.disabled = false;
                btn.innerHTML = '💾 Simpan Frame';
            });
        }

        function deleteFrame(id) {
            if (!confirm('Yakin ingin menghapus frame ini?')) return;
            fetch('/api/photobooth/custom-frames/' + id, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
            }).then(r => r.json()).then(res => { if (res.success) window.location.reload(); });
        }

        function togglePublish(id) {
            fetch('/api/photobooth/custom-frames/' + id + '/publish', {
                method: 'PUT',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
            }).then(r => r.json()).then(res => { if (res.success) window.location.reload(); });
        }
    </script>

    <style>
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>

</body>
</html>
