<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Admin | Ink & Solace</title>
    <style>
        /* Import Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500&family=Pinyon+Script&family=Montserrat:wght@400;500;600&display=swap');

        :root {
            --bg-color: #e6e6e6; 
            --text-color: #2c2c2c;
            --font-serif: 'Cinzel', serif;
            --font-script: 'Pinyon Script', cursive;
            --font-sans: 'Montserrat', sans-serif;
        }

        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: var(--bg-color);
            font-family: var(--font-sans);
            color: var(--text-color);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        /* --- HEADER --- */
        .header {
            padding: 40px 60px;
            display: flex;
            justify-content: flex-start;
        }

        /* Logo Image Style */
        .custom-logo {
            width: 120px; /* Adjust size as needed */
            height: auto; /* Maintains aspect ratio */
            display: block;
        }

        /* --- CENTER CONTENT --- */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: -80px; /* Pull up slightly for visual balance */
            text-align: center;
        }

        .welcome-title {
            display: flex;
            align-items: baseline;
            justify-content: center;
            margin-bottom: 20px;
        }

        .text-welcome {
            font-family: var(--font-serif);
            font-size: 100px;
            font-weight: 400;
            color: #333;
        }

        .text-admin {
            font-family: var(--font-script);
            font-size: 130px;
            margin-left: 20px;
            color: #333;
            transform: translateY(10px);
        }

        .subtitle {
            font-family: var(--font-serif);
            font-size: 32px;
            font-weight: 500;
            color: #444;
            margin-top: 0;
        }

        /* --- BOTTOM RIGHT LINK --- */
        .proceed-container {
            position: absolute;
            bottom: 60px;
            right: 80px;
        }

        .proceed-link {
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #555;
            text-decoration: none;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #555;
            padding-bottom: 2px;
            transition: opacity 0.3s;
        }

        .proceed-link:hover { opacity: 0.7; }

        .proceed-link svg {
            width: 24px;
            height: 14px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.5;
            margin-left: 10px;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .text-welcome { font-size: 60px; }
            .text-admin { font-size: 80px; }
            .subtitle { font-size: 24px; }
            .proceed-container { right: 40px; bottom: 40px; }
        }
    </style>
</head>
<body>

    <header class="header">
        <img src="https://via.placeholder.com/120x120/3b4252/e6e6e6?text=LOGO" alt="Ink & Solace Logo" class="custom-logo">
    </header>

    <div class="main-content">
        <div class="welcome-title">
            <span class="text-welcome">Welcome,</span>
            <span class="text-admin">Admin</span>
        </div>
        <p class="subtitle">What would you like to do today?</p>
    </div>

    <div class="proceed-container">
        <a href="main_menu.php" class="proceed-link">
            PROCEED TO MAIN MENU
            <svg viewBox="0 0 24 12"><path d="M0 6L22 6M22 6L17 1M22 6L17 11"></path></svg>
        </a>
    </div>

</body>
</html>