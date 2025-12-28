<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report | Ink & Solace</title>
    <style>
        /* Import Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500&family=Montserrat:wght@300;400;500;600;700&display=swap');

        :root {
            --light-bg: #e6e6e6; 
            --dark-bg: #1c202a; 
            --input-bg: #f2f2f2;
            --text-white: #ffffff;
            --text-dark: #1a1a1a;
            --btn-confirm: #8c827d; 
            --btn-return: #3b4252;  
            
            --font-serif: 'Cinzel', serif;
            --font-sans: 'Montserrat', sans-serif;
        }

        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: var(--font-sans);
            display: flex;
            flex-direction: column;
        }

        /* --- TOP SECTION (Dark) --- */
        .top-section {
            background-color: var(--dark-bg);
            height: 45%; 
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .logo-top {
            position: absolute;
            top: 40px;
            width: 100px;
            height: auto;
        }

        .page-title {
            font-family: var(--font-serif);
            font-size: 64px;
            color: var(--text-white);
            text-align: center;
            font-weight: 400;
            line-height: 1.1;
            letter-spacing: 2px;
            margin-top: 20px;
            text-transform: uppercase;
        }

        /* --- BOTTOM SECTION (Light) --- */
        .bottom-section {
            background-color: var(--light-bg);
            height: 55%;
            display: flex;
            flex-direction: column;
            padding: 20px 30px 15px 30px;
        }

        .form-container {
            flex: 1; 
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 600px;
        }

        .input-group {
            width: 100%;
            margin-bottom: 25px;
            display: flex;
            flex-direction: column;
        }

        label {
            font-family: var(--font-serif);
            font-size: 20px;
            color: #444;
            margin-bottom: 10px;
            margin-left: 15px; 
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .input-wrapper {
            position: relative;
            width: 100%;
        }

        /* Search Icon SVG */
        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            fill: none;
            stroke: #666;
            stroke-width: 2;
        }

        input {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border-radius: 50px;
            border: none;
            background-color: var(--input-bg);
            font-size: 16px;
            font-family: var(--font-serif);
            color: #666;
            outline: none;
            box-shadow: inset 1px 1px 4px rgba(0,0,0,0.05);
            box-sizing: border-box;
        }
        
        input::placeholder { color: #888; letter-spacing: 1px; text-transform: uppercase; }

        /* Buttons */
        .btn {
            border: none;
            border-radius: 50px;
            padding: 12px 0;
            width: 160px;
            font-family: var(--font-sans);
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            color: white;
            margin-top: 15px;
            transition: transform 0.2s, opacity 0.2s;
            text-align: center;
        }

        .btn:hover { opacity: 0.9; transform: scale(1.02); }
        .btn-confirm { background-color: var(--btn-confirm); box-shadow: 0 4px 10px rgba(140, 130, 125, 0.4); margin-bottom: 10px; }
        .btn-return { background-color: var(--btn-return); box-shadow: 0 4px 10px rgba(59, 66, 82, 0.4); }
        a.btn-link { text-decoration: none; display: flex; justify-content: center; }

        /* --- FOOTER --- */
        .footer {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 10px;
        }

        .footer-img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: #ccc; 
        }

        .footer-text {
            font-family: var(--font-sans);
            font-weight: 700;
            font-size: 14px;
            color: #333;
            text-transform: uppercase;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-title { font-size: 42px; }
            .top-section { height: 40%; }
            .bottom-section { height: 60%; }
            form { width: 90%; }
        }
    </style>
</head>
<body>

    <div class="top-section">
        <img src="https://via.placeholder.com/100x100/3b4252/e6e6e6?text=LOGO" alt="Logo" class="logo-top">
        
        <h1 class="page-title">REPORT</h1>
    </div>

    <div class="bottom-section">
        
        <div class="form-container">
            <form action="" method="POST">
                
                <div class="input-group">
                    <label for="search_query">SEARCH</label>
                    <div class="input-wrapper">
                        <svg class="search-icon" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <input type="text" id="search_query" name="search_query" placeholder="SEARCH">
                    </div>
                </div>

                <button type="submit" class="btn btn-confirm">Search</button>
                
                <a href="menu.php" class="btn-link">
                    <button type="button" class="btn btn-return">Return to Main Menu</button>
                </a>
            </form>
        </div>

        <footer class="footer">
            <img src="https://via.placeholder.com/35x35/555555/ffffff?text=" alt="Group Logo" class="footer-img">
            <div class="footer-text"></div>
        </footer>

    </div>

</body>
</html>