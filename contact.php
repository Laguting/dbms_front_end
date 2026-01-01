<?php
// PHP Logic to handle the success state
$show_success = false; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $show_success = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bespoke Solitude | Ink & Solace</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">

    <style>
        :root {
            --light-bg: #dbdbdb; 
            --dark-bg: #20252d; /* Your requested color */
            --btn-return: #3c4862;
        }

        * { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; height: 100%; font-family: 'Montserrat', sans-serif; }

        /* ================= BACKGROUND SECTION ================= */
        .hero-bg {
            /* Applied #20252d as a transparent overlay (0.7 opacity) */
            background-image: linear-gradient(rgba(32, 37, 45, 0.7), rgba(32, 37, 45, 0.7)), url('assets/text/contact-bg.png');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            color: white;
            text-align: center;
        }

        .text-bespoke {
            width: 180px; 
            max-width: 80%;
            height: auto;
            margin-bottom: 30px;
        }

        .divider {
            width: 90%;
            height: 1px;
            background: rgba(255,255,255,0.4);
            margin: 20px 0;
        }

        /* ================= INFO GRID ================= */
        .info-container {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            width: 90%;
            max-width: 1200px;
            margin-top: 30px;
        }

        .info-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0 20px;
        }

        .info-header {
            font-size: 18px;
            font-weight: 400; 
            letter-spacing: 2px;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .info-text {
            font-size: 14px;
            line-height: 1.8;
            opacity: 0.8;
            font-weight: 400;
        }

        /* ================= CSS SOCIAL ICONS ================= */
        .social-icons {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }

        .icon-tumblr {
            width: 20px;
            height: 20px;
            font-family: serif;
            font-weight: bold;
            font-size: 22px;
            line-height: 20px;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-style: italic;
        }

        .icon-messenger {
            position: relative;
            width: 22px;
            height: 22px;
            background: white;
            border-radius: 50%;
        }
        .icon-messenger::after {
            content: '';
            position: absolute;
            top: 5px; left: 4px;
            width: 0; height: 0;
            border-left: 7px solid transparent;
            border-right: 7px solid transparent;
            border-top: 12px solid var(--dark-bg); /* Using your color for the bolt icon */
            transform: rotate(-35deg);
        }

        /* ================= PROMPT STYLE ================= */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(32, 37, 45, 0.9); /* #20252d darker background for modal */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10000;
        }

        .modal-box {
            background: #ffffff;
            padding: 50px;
            border-radius: 25px;
            text-align: center;
            position: relative;
        }

        .btn-done-pill {
            background-color: var(--btn-return);
            color: white;
            text-decoration: none;
            padding: 12px 60px;
            border-radius: 50px;
            display: inline-block;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .info-container { grid-template-columns: 1fr; gap: 40px; }
        }
    </style>
</head>
<body>

<?php if ($show_success): ?>
<div class="modal-overlay">
    <div class="modal-box">
        <h2 style="color: var(--dark-bg); margin-bottom: 25px; font-weight: 400;">DATABASE UPDATED!</h2>
        <a href="menu.php" class="btn-done-pill">DONE</a>
    </div>
</div>
<?php endif; ?>

<div class="hero-bg">
    <img src="assets/text/text-bespoke-solitude.png" class="text-bespoke" alt="Bespoke Solitude">
    
    <div class="divider"></div>

    <div class="info-container">
        <div class="info-col">
            <div class="info-header">Location</div>
            <div class="info-text">
                123 Anywhere St. Any City ST 12345<br>
                Tel: +123-456-7890<br>
                hello@reallygreatsite.com
            </div>
        </div>

        <div class="info-col">
            <div class="info-header">Business Hours</div>
            <div class="info-text">
                Monday: 8am - 7pm<br>
                Tuesday: 8am - 5pm<br>
                Wednesday: 8am - 5pm<br>
                Thursday: 8am - 7pm<br>
                Friday: 8am - 5pm
            </div>
        </div>

        <div class="info-col">
            <div class="info-header">Get Social</div>
            <div class="social-icons">
                <div class="icon-tumblr" title="Tumblr">t</div>
                <div class="icon-messenger" title="Messenger"></div>
            </div>
        </div>
    </div>
</div>

</body>
</html>