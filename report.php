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
    <title>Report | Ink & Solace</title>

    <style>
        :root {
            --light-bg: #dbdbdb; 
            --dark-bg: #20252d;
            --input-bg: #f2f2f2;
            --btn-return: #3c4862;
        }

        * { box-sizing: border-box; }

        html, body {
            margin: 0; padding: 0;
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
        }

        body { display: flex; flex-direction: column; }

        /* ================= TOP SECTION (Symmetrical Dark Area) ================= */
        .top-section {
            background-color: var(--dark-bg);
            /* This height controls the overall size of the dark bar */
            height: 45%; 
            display: flex;
            flex-direction: column;
            justify-content: center; /* Centers the content group vertically */
            align-items: center;
        }

        .header-content-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* The gap between the Logo and the Report Title */
            gap: 40px; 
        }

        .logo-top {
            width: 180px;
            height: auto;
        }

        .page-title-img {
            width: 500px;
            max-width: 90%;
            height: auto;
        }

        /* ================= BOTTOM SECTION (Light Area) ================= */
        .bottom-section {
            flex: 1;
            padding: 50px 10% 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        /* SEARCH BAR */
        .search-container {
            width: 100%;
            max-width: 800px;
            position: relative;
            margin-bottom: 40px;
        }

        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            opacity: 0.5;
        }

        .search-input {
            width: 100%;
            padding: 15px 15px 15px 55px;
            border-radius: 50px;
            border: 1px solid #ccc;
            background-color: var(--input-bg);
            outline: none;
            font-size: 18px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* DATA PLACEHOLDER */
        .results-placeholder {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .placeholder-data-img {
            width: 380px;
            max-width: 90%;
            opacity: 0.9;
        }

        /* ================= RETURN BUTTON (Bottom Right) ================= */
        .return-footer {
            position: absolute;
            bottom: 30px;
            right: 5%;
        }

        .btn-return-wrap {
            background-color: var(--btn-return);
            padding: 12px 30px;
            border-radius: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            transition: transform 0.2s ease;
        }

        .btn-return-img {
            width: 160px;
            height: auto;
        }

        @media (max-width: 768px) {
            .page-title-img { width: 350px; }
            .logo-top { width: 130px; }
            .top-section { height: 40%; }
            .return-footer { position: static; margin-top: 30px; }
        }
    </style>
</head>

<body>

    <div class="top-section">
        <div class="header-content-group">
            <img src="assets/text/logo.png" class="logo-top" alt="Logo">
            <img src="assets/text/title-report.png" class="page-title-img" alt="REPORT">
        </div>
    </div>

    <div class="bottom-section">
        
        <div class="search-container">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" class="search-input" placeholder="SEARCH">
        </div>

        <div class="results-placeholder">
            <img src="assets/text/placeholder-results.png" class="placeholder-data-img" alt="Data Results">
        </div>

        <div class="return-footer">
            <a href="menu.php" style="text-decoration:none;">
                <div class="btn-return-wrap">
                    <img src="assets/text/btn-return.png" class="btn-return-img" alt="Return to Main Menu">
                </div>
            </a>
        </div>

    </div>

</body>
</html>
