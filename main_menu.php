<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Menu | Ink & Solace</title>
    <style>
        /* Import Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500&family=Pinyon+Script&family=Montserrat:wght@300;400;500&display=swap');

        :root {
            --light-bg: #e6e6e6; 
            --dark-bg: #1c202a; 
            --text-dark: #1a1a1a;
            --font-serif: 'Cinzel', serif;
            --font-script: 'Pinyon Script', cursive;
            --font-sans: 'Montserrat', sans-serif;
        }

        body, html {
            margin: 0;
            padding: 0;
            /* CHANGED: Use min-height instead of fixed height to allow scrolling */
            min-height: 100vh;
            font-family: var(--font-sans);
            display: flex;
            flex-direction: column;
            /* CHANGED: Removed 'overflow: hidden' to enable scrolling */
            overflow-x: hidden; 
        }

        /* --- TOP SECTION --- */
        .top-section {
            background-color: var(--light-bg);
            /* Fixed height for header */
            height: 35vh; 
            min-height: 250px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            padding: 0 80px;
        }

        /* Navigation Bar */
        .nav-bar {
            position: absolute;
            top: 50px;
            left: 0;
            width: 100%;
            padding: 0 80px;
            box-sizing: border-box;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            z-index: 10;
        }

        /* Logo */
        .custom-logo {
            width: 120px;
            height: auto;
            display: block;
        }

        .menu-icon {
            font-size: 40px;
            cursor: pointer;
            color: #333;
            margin-top: 10px;
        }

        /* Title */
        .title-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
            width: 100%;
        }

        .text-main {
            font-family: var(--font-serif);
            font-size: 130px;
            font-weight: 400;
            color: var(--text-dark);
            letter-spacing: -3px;
            line-height: 1;
        }

        .text-menu {
            font-family: var(--font-script);
            font-size: 160px;
            color: var(--text-dark);
            margin-left: -20px;
            transform: translateY(15px);
            line-height: 1;
        }

        /* --- BOTTOM SECTION --- */
        .bottom-section {
            background-color: var(--dark-bg);
            /* CHANGED: Allow this section to grow based on content */
            flex: 1; 
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 80px;
            padding: 60px 40px; /* Added vertical padding for spacing */
            flex-wrap: wrap; /* Allows cards to stack on small screens */
        }

        /* --- CARDS --- */
        .card-link {
            width: 600px;
            height: 600px;
            position: relative;
            border-radius: 50px;
            overflow: hidden;
            text-decoration: none;
            transition: transform 0.3s ease;
            background-color: #fff;
            /* Added margin to ensure space when scrolling on mobile */
            margin: 10px; 
        }

        .card-link:hover {
            transform: scale(1.02);
        }

        .card-image {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
        }

        /* PLACEHOLDER IMAGES */
        .img-edit {
            background-image: url('https://via.placeholder.com/800x800/555555/ffffff?text=Place+Image+Here');
        }

        .img-view {
            background-image: url('https://via.placeholder.com/800x800/666666/ffffff?text=Place+Image+Here');
        }

        /* Overlay */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.85); 
            transition: background-color 0.3s;
        }

        .card-link:hover .overlay {
            background-color: rgba(255, 255, 255, 0.7); 
        }

        /* Text Centering */
        .card-text-wrapper {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 5;
            text-align: center;
        }

        .card-text {
            font-family: var(--font-serif);
            font-size: 56px;
            color: #1a1a1a;
            font-weight: 400;
            letter-spacing: -1px;
            border-bottom: 2px solid #1a1a1a;
            padding-bottom: 4px;
            white-space: nowrap;
            text-transform: uppercase;
        }

        /* Responsive */
        @media (max-width: 1400px) {
            .card-link { width: 450px; height: 450px; }
            .text-main { font-size: 100px; }
            .text-menu { font-size: 130px; }
        }

        @media (max-width: 1024px) {
            .bottom-section { height: auto; padding: 60px 20px; }
            .card-link { width: 90%; max-width: 600px; height: 350px; }
            .top-section { height: auto; padding-bottom: 40px; }
            .nav-bar { position: relative; top: 0; margin-bottom: 20px; padding: 20px 0; }
            .text-main { font-size: 70px; }
            .text-menu { font-size: 90px; }
        }
    </style>
</head>
<body>

    <div class="top-section">
        <div class="nav-bar">
            <img src="https://via.placeholder.com/120x120/3b4252/e6e6e6?text=LOGO" alt="Logo" class="custom-logo">
            
            <div class="menu-icon">
                <svg width="50" height="30" viewBox="0 0 30 20" fill="none" stroke="#333" stroke-width="2">
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
        <a href="edit_database.php" class="card-link">
            <div class="card-image img-edit"></div>
            <div class="overlay"></div>
            <div class="card-text-wrapper">
                <div class="card-text">Edit Database</div>
            </div>
        </a>

        <a href="view_database.php" class="card-link">
            <div class="card-image img-view"></div>
            <div class="overlay"></div>
            <div class="card-text-wrapper">
                <div class="card-text">View Database</div>
            </div>
        </a>
    </div>

</body>
</html>