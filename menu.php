<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Menu | Ink & Solace</title>
    <style>
        /* Import Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500&family=Pinyon+Script&family=Montserrat:wght@400;500;600&display=swap');

        :root {
            --bg-color: #e6e6e6; 
            --border-color: #666; 
            --text-color: #1a1a1a;
            --font-serif: 'Cinzel', serif;
            --font-script: 'Pinyon Script', cursive;
            --font-sans: 'Montserrat', sans-serif;
        }

        body, html {
            margin: 0;
            padding: 0;
            background-color: var(--bg-color);
            font-family: var(--font-sans);
            color: var(--text-color);
            overflow-x: hidden;
        }

        /* --- HEADER --- */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 40px 60px; /* Increased padding */
        }

        /* LOGO PLACEHOLDER */
        .logo-placeholder {
            width: 100px;  /* Enlarged Logo Area */
            height: 100px;
            /* Replace the URL below with your actual logo file path */
            background: url('https://via.placeholder.com/100x100/3b4252/e6e6e6?text=LOGO') center/contain no-repeat;
        }

        .menu-icon {
            font-size: 40px; /* Larger icon */
            cursor: pointer;
            color: #333;
            margin-top: 15px;
        }

        /* --- TITLE SECTION --- */
        .title-container {
            text-align: center;
            margin-top: -30px;
            margin-bottom: 80px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .text-main {
            font-family: var(--font-serif);
            font-size: 140px; /* Significantly Larger */
            font-weight: 400;
            letter-spacing: -4px;
            line-height: 1;
        }

        .text-menu {
            font-family: var(--font-script);
            font-size: 170px; /* Significantly Larger */
            margin-left: -20px;
            transform: translateY(20px);
            line-height: 1;
        }

        /* --- MENU GRID --- */
        .menu-grid {
            max-width: 1700px; /* Much wider container */
            margin: 0 auto;
            padding: 0 60px 100px 60px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            column-gap: 50px; /* Wider gaps */
            row-gap: 70px;
        }

        /* Grid Item Wrapper */
        .grid-item {
            display: flex;
            flex-direction: column;
            position: relative;
        }

        /* The Box Styling - ENLARGED */
        .menu-box {
            border: 1px solid var(--border-color);
            height: 200px; /* Taller boxes */
            padding: 30px; /* More internal space */
            display: flex;
            align-items: center; 
            justify-content: flex-start;
            transition: background-color 0.3s;
            text-decoration: none;
        }
        
        .menu-box:hover {
            background-color: rgba(0,0,0,0.03);
        }

        .menu-box h2 {
            font-family: var(--font-serif);
            font-size: 48px; /* Larger text inside boxes */
            font-weight: 400;
            margin: 0;
            line-height: 0.9; 
            text-transform: uppercase;
            color: #222;
            letter-spacing: -1px;
        }

        /* PROCEED Link */
        .proceed-link {
            text-align: right;
            margin-top: 15px;
            font-size: 14px; /* Larger link text */
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #333;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            cursor: pointer;
            text-decoration: none;
            align-self: flex-end; 
        }

        .proceed-link:hover { opacity: 0.7; }
        
        .proceed-link svg {
            width: 30px; /* Larger arrow */
            height: 14px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.5;
            margin-left: 10px;
        }

        /* --- Full Width Item (Report) --- */
        .full-width {
            grid-column: 1 / -1;
        }

        .full-width .menu-box {
            height: 150px; /* Taller report bar */
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .menu-grid { grid-template-columns: 1fr; }
            .text-main { font-size: 90px; }
            .text-menu { font-size: 110px; }
            .menu-box { height: auto; min-height: 160px; }
            .menu-box h2 { font-size: 36px; }
        }
    </style>
</head>
<body>

    <header class="header">
        <div class="logo-placeholder"></div>
        
        <div class="menu-icon">
            <svg width="40" height="25" viewBox="0 0 30 20" fill="none" stroke="#333" stroke-width="2">
                <line x1="0" y1="2" x2="30" y2="2" />
                <line x1="0" y1="10" x2="30" y2="10" />
                <line x1="0" y1="18" x2="30" y2="18" />
            </svg>
        </div>
    </header>

    <div class="title-container">
        <span class="text-main">MAIN</span>
        <span class="text-menu">Menu</span>
    </div>

    <div class="menu-grid">

        <div class="grid-item">
            <a href="publishers_title.php" class="menu-box">
                <h2>Publishers &<br>Titles</h2>
            </a>
            <a href="publishers_title.php" class="proceed-link">
                PROCEED
                <svg viewBox="0 0 24 12"><path d="M0 6L22 6M22 6L17 1M22 6L17 11"></path></svg>
            </a>
        </div>

        <div class="grid-item">
            <a href="publisher_employee.php" class="menu-box">
                <h2>Publishers &<br>Employees</h2>
            </a>
            <a href="publisher_employee.php" class="proceed-link">
                PROCEED
                <svg viewBox="0 0 24 12"><path d="M0 6L22 6M22 6L17 1M22 6L17 11"></path></svg>
            </a>
        </div>

        <div class="grid-item">
            <a href="authors_title.php" class="menu-box">
                <h2>Authors &<br>Titles</h2>
            </a>
            <a href="authors_title.php" class="proceed-link">
                PROCEED
                <svg viewBox="0 0 24 12"><path d="M0 6L22 6M22 6L17 1M22 6L17 11"></path></svg>
            </a>
        </div>

        <div class="grid-item full-width">
            <a href="report.php" class="menu-box">
                <h2>Report</h2>
            </a>
            <a href="report.php" class="proceed-link">
                PROCEED
                <svg viewBox="0 0 24 12"><path d="M0 6L22 6M22 6L17 1M22 6L17 11"></path></svg>
            </a>
        </div>

    </div>

</body>
</html>