<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Awards | Ink & Solace</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --dark-bg: #20252d; 
            --border-color: rgba(255, 255, 255, 0.15);
            --hover-border: rgba(255, 255, 255, 0.4);
            --bezier: cubic-bezier(0.34, 1.56, 0.64, 1); 
            --transition-speed: 0.4s;
        }

        body {
            margin: 0;
            padding: 5vh 5vw; 
            background-color: var(--dark-bg);
            font-family: 'Montserrat', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            color: white;
            overflow-x: hidden;
        }

        /* --- TITLE: Scales but stays readable --- */
        .title-container {
            width: 100%;
            max-width: 1250px; 
            margin-bottom: clamp(20px, 4vw, 60px);
        }

        .awards-title-img {
            /* clamp ensures it never gets smaller than 28px or larger than 82px */
            height: clamp(28px, 6vw, 82px); 
            width: auto;
            display: block;
            transition: transform 0.6s var(--bezier);
        }

        /* --- GRID: Locked 3-Column but adjusts gap --- */
        .awards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: clamp(10px, 2vw, 30px); /* Gap shrinks but stays clickable */
            max-width: 1250px; 
            width: 100%;
        }

        /* --- AWARD BOXES: Aspect ratio is key for format --- */
        .award-box {
            position: relative;
            border: 1px solid var(--border-color);
            display: flex;
            justify-content: center;
            align-items: center;
            aspect-ratio: 16 / 10; /* Slightly taller for better readability of text-images */
            background: rgba(255, 255, 255, 0.02);
            box-sizing: border-box;
            cursor: pointer;
            overflow: hidden;
            transition: all var(--transition-speed) var(--bezier);
        }

        .award-box:hover {
            transform: translateY(-5px); 
            border-color: var(--hover-border);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .award-text-img {
            width: 80%; /* Shrinks slightly to provide internal padding/breathing room */
            height: auto;
            max-height: 70%;
            object-fit: contain;
            filter: brightness(0.85);
            transition: all var(--transition-speed) var(--bezier);
        }

        .award-box:hover .award-text-img {
            filter: brightness(1.1);
            transform: scale(1.05);
        }

        /* --- BOTTOM ROW: Mathematical Alignment --- */
        .bottom-row-wrapper {
            grid-column: 1 / 4;
            display: flex;
            justify-content: center;
            gap: clamp(10px, 2vw, 30px); 
            width: 100%;
        }

        .bottom-box {
            /* Ensures these 2 boxes are exactly the same size as the 3 above */
            width: calc((100% - (clamp(10px, 2vw, 30px) * 2)) / 3); 
        }

        /* Shine Effect stays subtle */
        .award-box::after {
            content: "";
            position: absolute;
            top: 0; left: -100%;
            width: 50%; height: 100%;
            background: linear-gradient(to right, transparent, rgba(255,255,255,0.05), transparent);
            transform: skewX(-25deg);
            transition: 0.75s;
        }
        .award-box:hover::after { left: 150%; }

        /* Handle very small screens where 3-across might be too tiny */
        @media (max-width: 480px) {
            .award-box { border-width: 0.5px; } /* Thinner borders for tiny screens */
            .award-text-img { width: 90%; } /* Use more of the box space */
        }
    </style>
</head>
<body>

    <div class="title-container">
        <img src="assets/text/title_awards.png" alt="AWARDS TITLE" class="awards-title-img">
    </div>

    <div class="awards-grid">
        <div class="award-box">
            <img src="assets/text/award_sustainability.png" alt="Sustainability" class="award-text-img">
        </div>
        <div class="award-box">
            <img src="assets/text/award_technology.png" alt="Technology" class="award-text-img">
        </div>
        <div class="award-box">
            <img src="assets/text/award_marketing.png" alt="Marketing" class="award-text-img">
        </div>

        <div class="bottom-row-wrapper">
            <div class="award-box bottom-box">
                <img src="assets/text/award_no1.png" alt="No 1" class="award-text-img">
            </div>
            <div class="award-box bottom-box">
                <img src="assets/text/award_hallfame.png" alt="Hall of Fame" class="award-text-img">
            </div>
        </div>
    </div>

</body>
</html>