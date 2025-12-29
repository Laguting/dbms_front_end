<?php
// PHP Logic to handle the search
$publisher_search = "";
$employee_search = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $publisher_search = htmlspecialchars($_POST['publisher'] ?? "");
    $employee_search = htmlspecialchars($_POST['employee'] ?? "");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publishers & Employees | Ink & Solace</title>

    <style>
        :root {
            --light-bg: #dbdbdb; 
            --dark-bg: #20252d;
            --input-bg: #f2f2f2;
            --btn-confirm: #8f8989;
            --btn-return: #3c4862;
        }

        * { box-sizing: border-box; }

        html, body {
            margin: 0; padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }

        body { display: flex; flex-direction: column; }

        /* ================= TOP SECTION ================= */
        .top-section {
            background-color: var(--dark-bg);
            height: 45%;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 130px;
        }

        .logo-top {
            position: absolute;
            top: 30px;
            width: 220px;
            max-width: 40vw;
            min-width: 180px;
        }

        .page-title-img {
            width: 520px;
            max-width: 90%;
        }

        /* ================= BOTTOM SECTION ================= */
        .bottom-section {
            background-color: var(--light-bg);
            height: 55%;
            padding: 20px 30px 15px;
            display: flex;
            flex-direction: column;
        }

        .form-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        form {
            width: 100%;
            max-width: 600px;
            text-align: center;
        }

        /* ================= INPUT GROUP ================= */
        .input-group {
            margin-bottom: 22px;
            text-align: left;
        }

        .label-img {
            width: 180px;
            margin: 0 0 10px 15px;
        }

        .input-wrapper {
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            stroke: #666;
            stroke-width: 2;
            fill: none;
        }

        input[type="text"] {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border-radius: 50px;
            border: none;
            outline: none;
            background-color: var(--input-bg);
            font-size: 16px;
        }

        .placeholder-img {
            position: absolute;
            left: 50px;
            top: 50%;
            transform: translateY(-50%);
            width: 90px;
            opacity: 0.6;
            pointer-events: none;
        }

        input:focus + .placeholder-img,
        input:not(:placeholder-shown) + .placeholder-img {
            display: none;
        }

        /* ================= BUTTONS ================= */
        .btn-confirm-wrap,
        .btn-return-wrap {
            margin: 14px auto 0;
            border-radius: 50px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            border: none;
            transition: transform 0.2s ease, filter 0.2s ease;
        }

        .btn-confirm-wrap {
            background-color: var(--btn-confirm);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            padding: 10px 35px;
        }

        /* UPDATED: SMALLER RETURN BUTTON */
        .btn-return-wrap {
            background-color: var(--btn-return);
            box-shadow: 0 5px 12px rgba(0,0,0,0.25);
            margin-top: 18px; /* Slightly less margin */
            padding: 14px 45px; /* Reduced padding from 18px 60px */
            max-width: 80%;
        }

        .btn-img {
            display: block;
            width: 90px; /* Base width for confirm */
        }

        /* UPDATED: SMALLER TEXT IMAGE FOR RETURN */
        .btn-return-wrap .btn-img {
            width: 180px; /* Reduced width from 220px to make button smaller */
            max-width: 100%;
            height: auto;
        }

        .btn-confirm-wrap:hover, .btn-return-wrap:hover {
            transform: scale(1.03); /* Subtle hover scale */
            filter: brightness(1.1);
        }

        /* ================= FOOTER ================= */
        footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 10px;
        }

        .footer-img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #555;
        }

        .footer-text-img {
            width: 120px;
        }

        /* ================= RESPONSIVE ================= */
        @media (max-width: 768px) {
            .logo-top { width: 110px; top: 20px; }
            .top-section { padding-top: 110px; }
            .page-title-img { width: 380px; }
            .btn-return-wrap { padding: 10px 30px; }
            .btn-return-wrap .btn-img { width: 140px; }
        }
    </style>
</head>

<body>

<div class="top-section">
    <img src="assets/text/logo.png" class="logo-top" alt="Logo">
    <img src="assets/text/title-publishers-authors.png" class="page-title-img" alt="Publishers & Employees">
</div>

<div class="bottom-section">
    <div class="form-container">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

            <div class="input-group">
                <img src="assets/text/label-publisher.png" class="label-img" alt="Publisher">
                <div class="input-wrapper">
                    <svg class="search-icon" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" name="publisher" placeholder=" " value="<?php echo $publisher_search; ?>">
                    <img src="assets/text/placeholder-search.png" class="placeholder-img" alt="">
                </div>
            </div>

            <div class="input-group">
                <img src="assets/text/label-employee.png" class="label-img" alt="Employee">
                <div class="input-wrapper">
                    <svg class="search-icon" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" name="employee" placeholder=" " value="<?php echo $employee_search; ?>">
                    <img src="assets/text/placeholder-search.png" class="placeholder-img" alt="">
                </div>
            </div>

            <button type="submit" class="btn-confirm-wrap">
                <img src="assets/text/btn-confirm.png" class="btn-img" alt="Confirm">
            </button>

            <div style="display: block;">
                <a href="menu.php" style="text-decoration:none;">
                    <div class="btn-return-wrap">
                        <img src="assets/text/btn-return.png" class="btn-img" alt="Return to Main Menu">
                    </div>
                </a>
            </div>

        </form>
    </div>

    <footer>
        <img src="https://via.placeholder.com/35x35/555555/ffffff?text=" class="footer-img" alt="">
        <img src="assets/text/footer-by-group2.png" class="footer-text-img" alt="">
    </footer>
</div>

</body>
</html>