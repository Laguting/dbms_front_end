<?php
// PHP Logic to handle the search
$publisher_search = "";
$title_search = "";
$data = "DATABASE_DATA_HERE"; // Placeholder

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $publisher_search = htmlspecialchars($_POST['publisher'] ?? "");
    $title_search = htmlspecialchars($_POST['title'] ?? "");
    
    // Future Database Integration:
    // $conn = new mysqli($servername, $username, $password, $dbname);
    // $sql = "SELECT ... WHERE publisher LIKE '%$publisher_search%'";
    // $result = $conn->query($sql);
    // $data = $result->fetch_assoc()['column_name'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publishers & Authors | Ink & Solace</title>

    <style>
        :root {
            --light-bg: #dbdbdb; 
            --dark-bg: #20252d;
            --btn-return: #3c4862;
            --btn-hover: #4a5a7a;
        }

        * { box-sizing: border-box; }

        html, body {
            margin: 0; padding: 0;
            height: 100%;
            font-family: 'Segoe UI', Arial, sans-serif;
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
            padding: 20px 50px;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .results-label-img {
            width: 150px;
            margin-top: 20px;
            align-self: flex-start;
        }

        /* CENTERED CONTENT AREA */
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

        /* ================= BACK BUTTON (ROUNDED) ================= */
        .footer-nav {
            display: flex;
            justify-content: flex-end;
            padding-bottom: 25px;
        }

        .btn-back-wrap {
            background-color: var(--btn-return);
            padding: 12px 45px;
            /* 50px radius ensures perfectly round edges/pill shape */
            border-radius: 50px; 
            cursor: pointer;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .btn-back-wrap:hover {
            transform: translateY(-2px);
            background-color: var(--btn-hover);
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
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
            .bottom-section { padding: 20px 25px; }
        }
    </style>
</head>

<body>

<div class="top-section">
    <img src="assets/text/logo.png" class="logo-top" alt="Logo">
    <img src="assets/text/title-publishers-titles.png" class="page-title-img" alt="Publishers & Titles">
</div>

<div class="bottom-section">
    <img src="assets/text/results-text.png" class="results-label-img" alt="RESULTS:">

    <div class="results-display-container">
        <h1 class="database-data-text"><?php echo $data; ?></h1>
    </div>

    <div class="footer-nav">
        <a href="menu.php" class="btn-back-wrap">
            <img src="assets/text/btn-back-small.png" class="btn-back-img" alt="BACK">
        </a>
    </div>
</div>

</body>
</html>