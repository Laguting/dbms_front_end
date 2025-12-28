<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ink & Solace Library</title>
    <style>
        /* IMPORT FONTS */
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Pinyon+Script&family=Montserrat:wght@300;400;500;600&display=swap');

        :root {
            --bg-color: #1c202a;
            --card-bg: #2a2e38;
            --text-white: #ffffff;
            --gap-size: 12px;
            --radius: 20px;
        }

        body, html {
            margin: 0;
            padding: 0;
            background-color: var(--bg-color);
            font-family: 'Montserrat', sans-serif;
            color: var(--text-white);
            box-sizing: border-box;
            overflow-x: hidden;
        }

        *, *::before, *::after { box-sizing: inherit; }

        a { text-decoration: none; color: inherit; }

        /* --- HERO SECTION --- */
        .hero {
            position: relative;
            height: 100vh;
            width: 100%;
            /* UPDATED PATH: 'Images/Background.png'
               Ensure the filename matches exactly (case-sensitive)
            */
            background: linear-gradient(to bottom, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.3) 60%, rgba(28, 32, 42, 1) 100%), 
                        url('Images/Background.png') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            padding: 40px 60px;
        }

        .nav-top {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.5px;
            z-index: 10;
        }

        .hero-center {
            position: absolute;
            top: 15%;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            z-index: 10;
        }

        .hero-center .subtitle {
            font-size: 12px;
            letter-spacing: 4px;
            margin-bottom: 20px;
            text-transform: uppercase;
            font-weight: 300;
        }

        .logo-graphic {
            width: 90px;
            height: 90px;
            /* UPDATED PATH: 'Images/logo.png' */
            background: url('Images/logo.png') center/contain no-repeat;
            margin: 0 auto 15px;
        }

        .hero-center h1 {
            font-family: 'Cinzel', serif;
            font-size: 32px;
            margin: 0;
            color: #dcdcdc;
            text-shadow: 0 4px 12px rgba(0,0,0,0.5);
        }

        /* --- DUAL FONT OVERLAY SECTION --- */
        .script-overlay {
            position: absolute;
            bottom: 80px;
            left: 60px;
            z-index: 10;
            pointer-events: none;
            display: flex;
            flex-direction: column;
            line-height: 0.6;
        }

        .text-ink {
            font-family: 'Cinzel', serif;
            font-weight: 400;
            font-size: 10vw;
            color: #ffffff;
            letter-spacing: -2px;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.3);
            margin-left: 10px;
        }

        .text-solace {
            font-family: 'Pinyon Script', cursive;
            font-size: 12vw;
            color: #ffffff;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.3);
            margin-top: -2vw;
            margin-left: 0;
            transform: rotate(-3deg);
        }

        .proceed-link {
            position: absolute;
            bottom: 60px;
            right: 60px;
            display: flex;
            align-items: center;
            font-size: 13px;
            letter-spacing: 1px;
            font-weight: 600;
            text-transform: uppercase;
            z-index: 10;
            cursor: pointer;
            transition: opacity 0.3s;
        }
        .proceed-link:hover { opacity: 0.8; }
        .proceed-link span { margin-right: 12px; }


        /* --- GALLERY GRID SECTION --- */
        .gallery-container {
            width: 95%; 
            max-width: 1800px;
            margin: 0 auto 80px auto;
        }

        .bento-grid {
            display: grid;
            grid-template-columns: 22% 1fr; 
            gap: var(--gap-size);
            height: 750px; 
        }

        .grid-img {
            background-color: var(--card-bg);
            border-radius: var(--radius);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            overflow: hidden;
        }
        
        .g-item-1 {
            grid-column: 1;
            /* UPDATED PATH: 'Images/tall_left.png' */
            background-image: url('Images/tall_left.png');
        }

        .right-col {
            display: flex;
            flex-direction: column;
            gap: var(--gap-size);
            height: 100%;
        }

        .g-item-2 {
            height: 42%;
            width: 100%;
            /* UPDATED PATH: 'Images/mid_level.png' */
            background-image: url('Images/mid_level.png');
        }

        .bottom-row {
            flex: 1;
            display: grid;
            grid-template-columns: 1.6fr 1fr; 
            gap: var(--gap-size);
        }

        .g-item-3 {
            /* UPDATED PATH: 'Images/medium_bottom.png' */
            background-image: url('Images/medium_bottom.png');
        }

        .stacked-col {
            display: flex;
            flex-direction: column;
            gap: var(--gap-size);
        }

        .g-item-4 {
            flex: 1;
            /* UPDATED PATH: 'Images/small_top.png' */
            background-image: url('Images/small_top.png');
        }

        .g-item-5 {
            flex: 1;
            /* UPDATED PATH: 'Images/small_bottom.png' */
            background-image: url('Images/small_bottom.png');
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .text-ink { font-size: 80px; }
            .text-solace { font-size: 100px; margin-top: -20px; }
            .bento-grid { grid-template-columns: 1fr; height: auto; }
            .g-item-1 { height: 400px; }
            .right-col { height: auto; }
            .g-item-2 { height: 250px; }
            .bottom-row { height: 300px; }
            .stacked-col { height: 100%; }
        }

        @media (max-width: 768px) {
            .text-ink { font-size: 60px; }
            .text-solace { font-size: 80px; }
            .bottom-row { grid-template-columns: 1fr; height: auto; }
            .g-item-3 { height: 250px; }
            .stacked-col { flex-direction: row; height: 180px; }
        }
    </style>
</head>
<body>

    <header class="hero">
        <nav class="nav-top">
            <a href="#">Metro Manila</a>
            <a href="login.php">Admin Log In</a>
        </nav>

        <div class="hero-center">
            <div class="subtitle">BESPOKE SOLITUDE</div>
            <div class="logo-graphic"></div>
            <h1>Ink & Solace</h1>
        </div>

        <div class="script-overlay">
            <div class="text-ink">INK &</div>
            <div class="text-solace">Solace</div>
        </div>

        <a href="menu.php" class="proceed-link">
            <span>PROCEED TO MAIN MENU</span>
            <span>&rarr;</span>
        </a>
    </header>

    <section class="gallery-container">
        <div class="bento-grid">
            <div class="grid-img g-item-1"></div>
            <div class="right-col">
                <div class="grid-img g-item-2"></div>
                <div class="bottom-row">
                    <div class="grid-img g-item-3"></div>
                    <div class="stacked-col">
                        <div class="grid-img g-item-4"></div>
                        <div class="grid-img g-item-5"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>