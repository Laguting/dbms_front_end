<?php
// PHP Logic to handle the data
$publisher_search = "";
$employee_search = "";
$data = "DATABASE_DATA_HERE"; // Placeholder for your SQL result

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $publisher_search = htmlspecialchars($_POST['publisher'] ?? "");
    $employee_search = htmlspecialchars($_POST['employee'] ?? "");
    
    // Future Logic:
    // $data = Fetch from DB where publisher = $publisher_search...
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results | Ink & Solace</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --light-bg: #dbdbdb; 
            --dark-bg: #20252d;
            --btn-return: #3c4862;
        }

        * { box-sizing: border-box; }

        html, body {
            margin: 0; padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: var(--light-bg);
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
            flex: 1;
            padding: 20px 50px 30px; /* Added more bottom padding since footer is gone */
            display: flex;
            flex-direction: column;
        }

        /* RESULTS LABEL */
        .results-label-img {
            width: 150px;
            margin-top: 20px;
            align-self: flex-start;
        }

        /* CENTERED DATA DISPLAY */
        .results-display-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .database-data-text {
            font-family: 'Times New Roman', Times, serif; 
            font-size: 2.5rem;
            color: #3c4862;
            letter-spacing: 2px;
            margin: 0;
            font-weight: normal;
        }

        /* ================= BACK BUTTON (PILL SHAPE) ================= */
        .btn-back-wrap {
            background-color: var(--btn-return);
            padding: 12px 45px;
            border-radius: 50px; /* Fully Rounded */
            cursor: pointer;
            border: none;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            transition: transform 0.2s ease, filter 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .btn-back-wrap:hover {
            transform: scale(1.05);
            filter: brightness(1.1);
        }

        .btn-back-img {
            width: 60px; 
            display: block;
        }

        /* ================= RESPONSIVE ================= */
        @media (max-width: 768px) {
            .logo-top { width: 110px; top: 20px; }
            .top-section { padding-top: 110px; }
            .page-title-img { width: 380px; }
            .database-data-text { font-size: 1.8rem; }
        }
    </style>
</head>

<body>

<div class="top-section">
    <img src="assets/text/logo.png" class="logo-top" alt="Logo">
    <img src="assets/text/title-publishers-employees.png" class="page-title-img" alt="Publishers & Employees">
</div>

<div class="bottom-section">
    <img src="assets/text/results-text.png" class="results-label-img" alt="RESULTS:">

    <div class="results-display-container">
        <h1 class="database-data-text"><?php echo $data; ?></h1>
    </div>

    <div style="text-align: right;">
        <a href="menu.php" class="btn-back-wrap">
            <img src="assets/text/btn-back-small.png" class="btn-back-img" alt="BACK">
        </a>
    </div>
</div>

</body>
</html>