<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Database | Ink & Solace</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap');

        :root {
            --light-bg: #dbdbdb; 
            --dark-bg: #20252d; 
            --text-white: #ffffff;
            --font-sans: 'Montserrat', sans-serif;
            --banner-tint: rgba(143, 137, 137, 0.7); 
        }

        body, html {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            font-family: var(--font-sans);
            display: flex;
            flex-direction: column;
            background-color: var(--dark-bg);
            overflow-x: hidden; 
        }

        /* --- TOP SECTION --- */
        .top-section {
            background-color: var(--light-bg);
            height: 25vh; 
            min-height: 160px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            padding: 0 5%;
        }

        .nav-bar {
            position: absolute;
            top: 2vh;
            left: 0;
            width: 100%;
            padding: 0 5%;
            box-sizing: border-box;
            display: flex;
            justify-content: flex-start;
            z-index: 10;
        }

        .custom-logo {
            width: 8vw;
            min-width: 80px;
            max-width: 120px;
            height: auto;
        }

        .title-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .img-main-title {
            height: 12vh;
            max-width: 80%;
            width: auto;
            object-fit: contain;
        }

        /* --- BOTTOM SECTION --- */
        .bottom-section {
            background-color: var(--dark-bg);
            flex: 1;
            padding: 4vh 5%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .banner-container {
            width: 90%;
            max-width: 1200px;
            height: 20vh; 
            min-height: 140px; 
            margin-bottom: 5vh;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            border-radius: 15px;
            background-color: var(--banner-tint);
        }

        .banner-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('assets/text/banner-background-bubble.png'); 
            background-size: cover;
            background-position: center;
            opacity: 0.2; 
            z-index: 1;
        }

        .img-banner-label {
            position: relative;
            z-index: 2; 
            height: 75%; 
            width: auto;
            max-width: 90%;
            object-fit: contain;
            filter: drop-shadow(0px 6px 12px rgba(0,0,0,0.4));
        }

        .options-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2vw;
            width: 90%;
            max-width: 1200px;
        }

        .option-item {
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }

        .option-item:hover {
            transform: translateY(-8px);
        }

        .option-box {
            border: 1px solid rgba(255, 255, 255, 0.7); 
            height: 20vh; /* Increased height slightly to accommodate larger text */
            min-height: 120px;
            display: flex;
            align-items: center;
            justify-content: flex-start; 
            padding: 1.5vw 2.5vw; 
            text-decoration: none;
            box-sizing: border-box;
        }

        /* TEXT INSIDE BOX: Made bigger */
        .img-option-text {
            max-width: 100%;
            max-height: 85%; /* Increased from 70% to 85% */
            object-fit: contain;
        }

        .proceed-link {
            text-align: right;
            margin-top: 1vh;
            font-size: 0.8vw;
            min-font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.1vw;
            text-transform: uppercase;
            color: var(--text-white);
            display: flex;
            justify-content: flex-end;
            align-items: center;
            text-decoration: none;
        }

        .proceed-link svg {
            width: 1.5vw;
            min-width: 15px;
            margin-left: 0.5vw;
        }

        /* RETURN BUTTON CONTAINER: Moved further down */
        .return-btn-container {
            width: 90%;
            max-width: 1200px;
            display: flex;
            justify-content: flex-end;
            margin-top: 10vh; /* Increased from 5vh to 10vh to move it lower */
            padding-bottom: 5vh; /* Added padding to ensure it's not hugging the bottom of the screen */
        }

        .btn-return {
            background-color: #dbdbdb;
            color: #3c4862;
            padding: 1.2vh 2.5vw;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9vw;
            min-font-size: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.4);
            transition: transform 0.2s;
            white-space: nowrap;
        }

        .btn-return:hover { transform: scale(1.05); }

        @media (max-width: 800px) {
            .proceed-link { font-size: 10px; }
            .btn-return { font-size: 12px; }
            .banner-container { height: 120px; }
            .option-box { padding-left: 15px; height: 100px; }
            .return-btn-container { margin-top: 6vh; }
        }
    </style>
</head>
<body>

    <div class="top-section">
        <div class="nav-bar">
            <img src="assets/text/logo-img.png" alt="Ink & Solace" class="custom-logo">
        </div>

        <div class="title-container">
            <img src="assets/text/title-main-menu.png" alt="Main Menu" class="img-main-title">
        </div>
    </div>

    <div class="bottom-section">

        <div class="banner-container">
            <div class="banner-bg"></div> 
            <img src="assets/text/label-edit-database.png" alt="Edit Database" class="img-banner-label">
        </div>

        <div class="options-grid">
            
            <div class="option-item">
                <a href="publishers_titles.php" class="option-box">
                    <img src="assets/text/text-opt-publishers-titles.png" alt="Publishers & Titles" class="img-option-text">
                </a>
                <a href="publishers_titles.php" class="proceed-link">
                    PROCEED <svg viewBox="0 0 24 12" fill="none" stroke="currentColor" stroke-width="2"><path d="M0 6L22 6M22 6L17 1M22 6L17 11"></path></svg>
                </a>
            </div>

            <div class="option-item">
                <a href="publishers_employees.php" class="option-box">
                    <img src="assets/text/text-opt-publishers-employees.png" alt="Publishers & Employees" class="img-option-text">
                </a>
                <a href="publishers_employees.php" class="proceed-link">
                    PROCEED <svg viewBox="0 0 24 12" fill="none" stroke="currentColor" stroke-width="2"><path d="M0 6L22 6M22 6L17 11"></path></svg>
                </a>
            </div>

            <div class="option-item">
                <a href="authors_titles.php" class="option-box">
                    <img src="assets/text/text-opt-authors-titles.png" alt="Authors & Titles" class="img-option-text">
                </a>
                <a href="authors_titles.php" class="proceed-link">
                    PROCEED <svg viewBox="0 0 24 12" fill="none" stroke="currentColor" stroke-width="2"><path d="M0 6L22 6M22 6L17 1M22 6L17 11"></path></svg>
                </a>
            </div>

        </div>

        <div class="return-btn-container">
            <a href="main_menu.php" class="btn-return">Return to Main Menu</a>
        </div>

    </div>

</body>
</html>
