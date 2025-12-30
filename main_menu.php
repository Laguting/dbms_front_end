<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Menu | Ink & Solace</title>
    <style>
        :root {
            --light-bg: #dbdbdb; 
            --dark-bg: #20252d; 
        }

        body, html {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden; 
            background-color: var(--dark-bg);
        }

        /* --- TOP SECTION --- */
        .top-section {
            background-color: var(--light-bg);
            height: 35vh; 
            min-height: 250px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .nav-bar {
            position: absolute;
            top: 40px;
            left: 0;
            width: 100%;
            padding: 0 60px;
            box-sizing: border-box;
            display: flex;
            justify-content: flex-start; 
            align-items: center;
        }

        .logo-main {
            width: 120px; /* Balanced size */
            height: auto;
        }

        .title-img {
            width: 500px; /* Reduced from 600px */
            max-width: 85%;
            height: auto;
            margin-top: 30px;
        }

        /* --- BOTTOM SECTION --- */
        .bottom-section {
            flex: 1; 
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 40px; /* Reduced gap */
            padding: 40px;
            flex-wrap: wrap;
        }

        /* --- CARDS (Balanced Size) --- */
        .card-link {
            width: 420px; /* Reduced from 550px */
            height: 420px; /* Reduced from 550px */
            position: relative;
            border-radius: 30px;
            overflow: hidden;
            text-decoration: none;
            transition: transform 0.3s ease;
            background-color: #8f8989; /* Base color for transparency blend */
        }

        .card-link:hover {
            transform: scale(1.05);
        }

        .card-bg-image {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            /* Transparency: adjusts how much the image shows */
            opacity: 0.4; 
            transition: opacity 0.3s ease;
        }

        .card-link:hover .card-bg-image {
            opacity: 0.6;
        }

        /* Overlay */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* Light transparent overlay to keep text readable */
            background-color: rgba(255, 255, 255, 0.4); 
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Text Image inside Cards (Balanced Size) */
        .card-title-img {
            width: 260px; /* Reduced from 350px */
            max-width: 80%;
            height: auto;
            z-index: 2;
        }

        /* Background images */
        .img-edit { background-image: url('assets/text/bg-edit.png'); }
        .img-view { background-image: url('assets/text/bg-view.png'); }

        /* Responsive Adjustments */
        @media (max-width: 1024px) {
            .card-link { width: 340px; height: 340px; }
            .title-img { width: 400px; }
        }

        @media (max-width: 768px) {
            .top-section { height: auto; padding: 100px 20px 40px; }
            .nav-bar { padding: 0 30px; top: 20px; }
            .card-link { width: 100%; max-width: 380px; height: 300px; }
        }
    </style>
</head>
<body>

    <div class="top-section">
        <div class="nav-bar">
            <img src="assets/text/logo-img.png" alt="Ink & Solace" class="logo-main">
        </div>
        <img src="assets/text/title-main-menu.png" alt="Main Menu" class="title-img">
    </div>

    <div class="bottom-section">
        
        <a href="edit_database.php" class="card-link">
            <div class="card-bg-image img-edit"></div>
            <div class="overlay">
                <img src="assets/text/label-edit-database.png" alt="Edit Database" class="card-title-img">
            </div>
        </a>

        <a href="view_database.php" class="card-link">
            <div class="card-bg-image img-view"></div>
            <div class="overlay">
                <img src="assets/text/label-view-database.png" alt="View Database" class="card-title-img">
            </div>
        </a>
        
    </div>

</body>
</html>
