<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Description | Ink & Solace</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --light-bg: #dbdbdb; 
            --dark-bg: #20252d; 
            --card-gray: #8f8989;
            --overlay-color: rgba(143, 137, 137, 0.7); 
            --transition: all 0.3s ease;
        }

        * { box-sizing: border-box; }

        body, html {
            margin: 0;
            padding: 0;
            height: 100vh;
            font-family: 'Montserrat', sans-serif;
            background-color: var(--dark-bg);
            overflow: hidden;
        }

        /* --- HEADER --- */
        header {
            background-color: var(--light-bg);
            height: 20vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 20px; 
            height: 85%; 
        }

        .header-logo, .header-text {
            height: 100%;
            width: auto;
            object-fit: contain;
        }

        /* --- BENTO GRID --- */
        .grid-container {
            height: 80vh;
            padding: 40px;
            display: grid;
            grid-template-columns: 1.2fr 1fr 0.8fr;
            grid-template-rows: 1fr 1.2fr;
            gap: 25px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .bento-item {
            border-radius: 30px;
            text-decoration: none;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
            transition: var(--transition);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .bento-item:hover {
            transform: translateY(-5px);
            filter: brightness(1.05);
        }

        .card-top-label {
            grid-column: 1 / 3;
            background-image: linear-gradient(var(--overlay-color), var(--overlay-color)), 
                              url('assets/text/library-bg.png');
            background-size: cover;
            background-position: center;
        }

        .card-image {
            grid-column: 1;
            grid-row: 2;
            background-image: url('assets/text/library-counter.png');
            background-size: cover;
            background-position: center;
        }

        .card-explore {
            grid-column: 2;
            grid-row: 2;
            background-color: var(--card-gray);
        }

        .card-menu {
            grid-column: 3;
            grid-row: 1 / 3;
            background-color: var(--card-gray);
        }

        .text-img {
            max-width: 80%;
            max-height: 60%;
            object-fit: contain;
        }

        .label-main-title {
            max-width: 70%;
            filter: drop-shadow(0 5px 15px rgba(0,0,0,0.3));
        }

        .footer-text {
            position: absolute;
            bottom: 20px;
            right: 40px;
            color: #ffffff;
            font-size: 14px;
            opacity: 0.5;
            letter-spacing: 1px;
        }

        @media (max-width: 1000px) {
            .grid-container {
                grid-template-columns: 1fr;
                grid-template-rows: repeat(4, 250px);
                overflow-y: auto;
            }
            .card-top-label, .card-menu, .card-explore, .card-image {
                grid-column: auto;
                grid-row: auto;
            }
        }
    </style>
</head>
<body>

    <header>
        <div class="logo-container">
            <img src="assets/text/logo-img.png" alt="Logo" class="header-logo">
            <img src="assets/text/logo-text.png" alt="Ink & Solace" class="header-text">
        </div>
    </header>

    <div class="grid-container">
        <div class="bento-item card-top-label">
            <img src="assets/text/label-description.png" alt="Description" class="label-main-title">
        </div>

        <div class="bento-item card-image"></div>

        <div class="bento-item card-explore">
            <img src="assets/text/about_explore.png" alt="Explore" class="text-img">
        </div>

        <a href="main_menu.php" class="bento-item card-menu">
            <img src="assets/text/about_main_menu.png" alt="Main Menu" class="text-img">
        </a>
    </div>

    <div class="footer-text">
        <?php echo "BY GROUP 2"; ?>
    </div>

</body>
</html>