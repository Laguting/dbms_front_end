<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Database | Ink & Solace</title>
    <style>
        /* Import Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500&family=Pinyon+Script&family=Montserrat:wght@300;400;500;600;700&display=swap');

        :root {
            --light-bg: #e6e6e6; 
            --dark-bg: #1c202a; /* Deep Navy */
            --text-dark: #1a1a1a;
            --text-white: #ffffff;
            --font-serif: 'Cinzel', serif;
            --font-script: 'Pinyon Script', cursive;
            --font-sans: 'Montserrat', sans-serif;
        }

        body, html {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            font-family: var(--font-sans);
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* --- TOP SECTION (Light Header) --- */
        .top-section {
            background-color: var(--light-bg);
            height: 25vh; 
            min-height: 180px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            padding: 0 60px;
        }

        /* Navbar elements */
        .nav-bar {
            position: absolute;
            top: 30px;
            left: 0;
            width: 100%;
            padding: 0 60px;
            box-sizing: border-box;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            z-index: 10;
        }

        .custom-logo {
            width: 100px;
            height: auto;
            display: block;
        }

        .menu-icon {
            font-size: 32px;
            cursor: pointer;
            color: #333;
            margin-top: 10px;
        }

        /* Title: MAIN Menu */
        .title-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
            width: 100%;
        }

        .text-main {
            font-family: var(--font-serif);
            font-size: 90px;
            font-weight: 400;
            color: var(--text-dark);
            letter-spacing: -2px;
            line-height: 1;
        }

        .text-menu {
            font-family: var(--font-script);
            font-size: 120px;
            color: var(--text-dark);
            margin-left: -15px;
            transform: translateY(15px);
            line-height: 1;
        }

        /* --- BOTTOM SECTION (Dark Content) --- */
        .bottom-section {
            background-color: var(--dark-bg);
            flex: 1;
            padding: 40px 60px;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        /* 1. Large Banner Image */
        .banner-container {
            width: 100%;
            max-width: 1200px;
            height: 180px; 
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 50px;
            background-color: #fff; 
        }

        .banner-img {
            width: 100%;
            height: 100%;
            /* Faded banner image - You can change this image to distinguish it from Edit */
            background-image: url('https://via.placeholder.com/1400x300/cccccc/ffffff?text=');
            background-size: cover;
            background-position: center;
            opacity: 0.8; 
        }

        .banner-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: var(--font-serif);
            font-size: 60px;
            color: var(--text-dark); 
            font-weight: 400;
            z-index: 2;
            white-space: nowrap;
        }

        /* 2. Grid of Options */
        .options-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            width: 100%;
            max-width: 1200px;
        }

        /* Option Item */
        .option-item {
            display: flex;
            flex-direction: column;
            position: relative;
        }

        /* The Box (Transparent with White Border) */
        .option-box {
            border: 1px solid rgba(255, 255, 255, 0.7); 
            height: 140px;
            display: flex;
            align-items: center;
            padding: 25px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .option-box:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .option-box h2 {
            font-family: var(--font-serif);
            font-size: 32px;
            color: var(--text-white); 
            margin: 0;
            font-weight: 400;
            line-height: 0.9;
            text-transform: uppercase;
        }

        /* Proceed Link (White, Bottom Right) */
        .proceed-link {
            text-align: right;
            margin-top: 10px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--text-white);
            display: flex;
            justify-content: flex-end;
            align-items: center;
            cursor: pointer;
            text-decoration: none;
        }

        .proceed-link svg {
            width: 20px;
            height: 12px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.5;
            margin-left: 8px;
        }

        /* 3. Return Button */
        .return-btn-container {
            width: 100%;
            max-width: 1200px;
            display: flex;
            justify-content: flex-end;
            margin-top: 40px;
        }

        .btn-return {
            background-color: #f2f2f2; 
            color: #1c202a; 
            padding: 12px 30px;
            border-radius: 50px;
            border: none;
            font-family: var(--font-sans);
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: transform 0.2s;
            text-decoration: none;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        .btn-return:hover {
            transform: scale(1.05);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .options-grid { grid-template-columns: 1fr; }
            .text-main { font-size: 70px; }
            .text-menu { font-size: 90px; }
            .banner-text { font-size: 40px; }
            .return-btn-container { justify-content: center; }
        }
    </style>
</head>
<body>

    <div class="top-section">
        <div class="nav-bar">
            <img src="https://via.placeholder.com/100x100/3b4252/e6e6e6?text=LOGO" alt="Logo" class="custom-logo">
            
            <div class="menu-icon">
                <svg width="40" height="25" viewBox="0 0 30 20" fill="none" stroke="#333" stroke-width="2">
                    <line x1="0" y1="2" x2="30" y2="2" />
                    <line x1="0" y1="10" x2="30" y2="10" />
                    <line x1="0" y1="18" x2="30" y2="18" />
                </svg>
            </div>
        </div>

        <div class="title-container">
            <span class="text-main">MAIN</span>
            <span class="text-menu">Menu</span>
        </div>
    </div>

    <div class="bottom-section">

        <div class="banner-container">
            <div class="banner-img"></div>
            <div class="banner-text">View Database</div>
        </div>

        <div class="options-grid">
            
            <div class="option-item">
                <a href="publishers_titles.php" class="option-box">
                    <h2>Publishers &<br>Titles</h2>
                </a>
                <a href="publishers_titles.php" class="proceed-link">
                    PROCEED <svg viewBox="0 0 24 12"><path d="M0 6L22 6M22 6L17 1M22 6L17 11"></path></svg>
                </a>
            </div>

            <div class="option-item">
                <a href="publishers_employees.php" class="option-box">
                    <h2>Publishers &<br>Employees</h2>
                </a>
                <a href="publishers_employees.php" class="proceed-link">
                    PROCEED <svg viewBox="0 0 24 12"><path d="M0 6L22 6M22 6L17 1M22 6L17 11"></path></svg>
                </a>
            </div>

            <div class="option-item">
                <a href="authors_titles.php" class="option-box">
                    <h2>Authors &<br>Titles</h2>
                </a>
                <a href="authors_titles.php" class="proceed-link">
                    PROCEED <svg viewBox="0 0 24 12"><path d="M0 6L22 6M22 6L17 1M22 6L17 11"></path></svg>
                </a>
            </div>
            
            </div>

        <div class="return-btn-container">
            <a href="main_menu.php" class="btn-return">Return to Main Menu</a>
        </div>

    </div>

</body>
</html>