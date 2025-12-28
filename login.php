<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Log-in | Ink & Solace</title>
    <style>
        /* Import Fonts: Cinzel (Serif), Pinyon Script (Cursive), Montserrat (Body) */
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500&family=Pinyon+Script&family=Montserrat:wght@300;400;500;600&display=swap');

        :root {
            --bg-color: #e6e6e6; /* Light gray background */
            --input-bg: #f2f2f2;
            --text-color: #2c2c2c;
            --btn-confirm: #8c827d; /* Taupe/Brownish gray */
            --btn-return: #3b4252;  /* Dark Navy */
            --font-serif: 'Cinzel', serif;
            --font-script: 'Pinyon Script', cursive;
        }

        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: var(--bg-color);
            font-family: 'Montserrat', sans-serif;
            display: flex;
            flex-direction: column;
        }

        /* --- HEADER (Logo & Menu) --- */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start; /* Align to top */
            padding: 30px 40px;
        }

        /* Logo Placeholder located here */
        .logo-placeholder {
            width: 80px;
            height: 80px;
            /* Replace this URL with your actual logo image */
            background: url('https://via.placeholder.com/80x80/3b4252/e6e6e6?text=LOGO') center/contain no-repeat;
        }

        .menu-icon {
            font-size: 32px;
            cursor: pointer;
            color: #555;
            margin-top: 10px; /* Slight adjustment to match image */
        }

        /* --- MAIN CONTENT --- */
        .main-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            /* Added padding to prevent touching edges on small screens */
            padding: 20px; 
            margin-top: -80px; /* Adjusted visual lift */
        }

        /* --- DUAL FONT TITLE --- */
        .title-container {
            display: flex;
            align-items: baseline;
            margin-bottom: 50px;
            position: relative;
        }

        .text-admin {
            font-family: var(--font-serif);
            font-size: 90px; /* Increased size */
            color: var(--text-color);
            letter-spacing: 2px;
            font-weight: 400;
        }

        .text-login {
            font-family: var(--font-script);
            font-size: 110px; /* Increased size */
            color: var(--text-color);
            margin-left: -25px; /* Overlap the 'N' of Admin */
            transform: translateY(8px);
            z-index: 2;
        }

        /* --- FORM STYLING --- */
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* UPDATED WIDTH: Set to 75% as requested */
            width: 75%; 
            /* Added a max-width so it doesn't look ridiculous on huge monitors */
            max-width: 900px; 
        }

        .input-group {
            width: 100%;
            margin-bottom: 30px;
            display: flex;
            flex-direction: column;
            align-items: center; /* Center labels */
        }

        label {
            font-family: var(--font-serif);
            font-size: 28px; /* Increased label size */
            color: #444;
            margin-bottom: 15px;
            font-weight: 500;
            text-transform: uppercase; /* Matches reference image */
            letter-spacing: 1px;
        }

        input {
            width: 100%;
            /* Increased padding for larger, taller inputs */
            padding: 20px 30px; 
            border-radius: 50px; /* Pill shape */
            border: none;
            background-color: var(--input-bg);
            font-size: 18px; /* Increased input text size */
            outline: none;
            box-shadow: inset 2px 2px 5px rgba(0,0,0,0.05);
            text-align: center;
        }

        /* --- BUTTONS --- */
        .btn {
            border: none;
            border-radius: 50px;
            padding: 15px 70px; /* Larger buttons */
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 18px;
            cursor: pointer;
            transition: transform 0.2s, opacity 0.2s;
            margin-top: 20px;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
            transform: scale(1.02);
        }

        .btn-confirm {
            background-color: var(--btn-confirm);
            box-shadow: 0 4px 10px rgba(140, 130, 125, 0.4);
            margin-bottom: 15px;
        }

        .btn-return {
            background-color: var(--btn-return);
            box-shadow: 0 4px 10px rgba(59, 66, 82, 0.4);
            padding: 15px 50px;
        }

        /* Responsive sizes for smaller screens */
        @media (max-width: 768px) {
            .text-admin { font-size: 60px; }
            .text-login { font-size: 75px; margin-left: -15px; }
            form { width: 90%; } /* Wider on mobile */
            label { font-size: 22px; }
            input { padding: 15px 20px; font-size: 16px; }
        }
    </style>
</head>
<body>

    <header class="header">
        <div class="logo-placeholder"></div> 
        <div class="menu-icon">&#9776;</div> 
    </header>

    <div class="main-container">
        
        <div class="title-container">
            <span class="text-admin">ADMIN</span>
            <span class="text-login">Log-in</span>
        </div>

        <form action="" method="POST">
            
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <a href="admin_welcome.php">
                <button type="button" class="btn btn-confirm">Confirm</button>
            </a>
            
            <a href="index.php">
                <button type="button" class="btn btn-return">Return to Home Page</button>
            </a>

        </form>
    </div>

</body>
</html>