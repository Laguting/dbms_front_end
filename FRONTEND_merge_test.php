<?php
/**
 * Ink & Solace - Unified Merged Interface
 */
// Logic to handle which section to display
$view = isset($_GET['view']) ? $_GET['view'] : 'landing';

// Logic to handle search variables
$publisher_search = "";
$title_search = "";
$employee_search = "";
$author_search = ""; 
$data = "DATABASE_DATA_HERE"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($view === 'login') {
        $view = 'welcome';
    } elseif ($view === 'pub_titles' || $view === 'pub_titles_display') { 
        $publisher_search = htmlspecialchars($_POST['publisher'] ?? "");
        $title_search = htmlspecialchars($_POST['title'] ?? "");
        // This simulates finding the data from your search
        $data = "RESULTS FOR: " . $publisher_search; 
    } elseif ($view === 'pub_emp' || $view === 'pub_emp_display') { 
        $publisher_search = htmlspecialchars($_POST['publisher'] ?? "");
        $employee_search = htmlspecialchars($_POST['employee'] ?? "");
        $data = "RESULTS FOR EMP: " . $employee_search;
    } elseif ($view === 'auth_titles' || $view === 'auth_titles_display') { 
        $author_search = htmlspecialchars($_POST['author'] ?? "");
        $title_search = htmlspecialchars($_POST['title'] ?? "");
        $data = "RESULTS FOR AUTHOR: " . $author_search; // Simulate finding the data
    }
} // This brace closes the REQUEST_METHOD == POST block

// PHP variables for shared links
$login_page = "?view=login";
$menu_page = "?view=description";
$about_menu = "?view=about_main_menu";  // Added new variable [cite: 186, 187]
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ink & Solace Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* --- SHARED VARIABLES --- */
        :root {
            --bg-color: #1c202a;
            --overlay-tint: rgba(32, 37, 45, 0.6); 
            --card-bg: #2a2e38;
            --text-white: #ffffff;
            --gap-size: 24px;
            --radius: 20px;
            --transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
            
            /* UI Specific Colors */
            --light-bg: #dbdbdb; 
            --dark-bg: #20252d; 
            --card-gray: #8f8989;
            --overlay-color: rgba(143, 137, 137, 0.7); 
            --amenity-bg: #1a1e24; 
            --award-bg: #20252d; 
            --highlight-purple: #7d5fff;
            --border-color: rgba(255, 255, 255, 0.15);
            --hover-border: rgba(255, 255, 255, 0.4);
            --transition-explore: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            --bezier-awards: cubic-bezier(0.34, 1.56, 0.64, 1);

            /* Admin/Edit/View Specific Colors */
            --admin-bg: #dbdbdb;
            --input-bg: #ececec;
            --btn-confirm-bg: #8F8989; 
            --btn-return-bg: #3C4862; 
            --banner-tint: rgba(143, 137, 137, 0.7); 
            --banner-tint-view: rgba(143, 137, 137, 0.4);
            --font-sans: 'Montserrat', sans-serif;
            --btn-blue: #3c4862; 
            --text-view-white: #ececec;

            /* Publishers & Titles Specific */
            --pub-input-bg: #f2f2f2;
            --pub-btn-confirm: #8f8989;
            --pub-btn-return: #3c4862;
        }

        body, html {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            font-family: 'Montserrat', sans-serif;
            box-sizing: border-box;
            color: var(--text-white);
            overflow-x: hidden;
        }

        *, *::before, *::after { box-sizing: inherit; }

        .img-text {
            display: block;
            object-fit: contain;
            height: auto;
        }

        /* ============================================================
            VIEW 1: LANDING PAGE STYLES
           ============================================================ */
        .hero {
            position: relative;
            height: 100vh;
            width: 100%;
            background: linear-gradient(to bottom, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.3) 60%, var(--bg-color) 100%), 
                        url('assets/text/Background.png') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .script-overlay {
            position: absolute;
            inset: 0;
            z-index: 1; 
            pointer-events: none; 
            background: url('assets/text/Solace_Text_BG.png') no-repeat center center;
            background-size: cover;
            display: flex;
            align-items: flex-end; 
            justify-content: flex-start; 
        }

        .script-overlay::before {
            content: "";
            position: absolute;
            inset: 0;
            background-color: var(--overlay-tint);
            z-index: -1; 
        }

        .overlay-solace-img { 
            width: 55vw; 
            max-width: 850px; 
            filter: drop-shadow(5px 5px 25px rgba(0,0,0,0.7));
            opacity: 0.95;
            margin-left: -40px; 
            margin-bottom: -10px;
            transition: var(--transition);
        }

        .subtitle-underline {
            width: 100%;
            height: 1px;
            background-color: rgba(255, 255, 255, 0.2);
            position: absolute;
            top: 105px;
            z-index: 5;
        }

        .hero-top-center {
            position: absolute;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 30;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .subtitle-img { 
            height: 50px; 
            max-width: 80vw;
        } 

        .nav-top {
            position: absolute;
            top: 140px; 
            width: 100%;
            padding: 0 5%; 
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 20;
        }

        .nav-img { 
            height: 32px; 
            max-width: 40vw; 
            transition: var(--transition);
        } 

        .nav-top a:hover .nav-img {
            transform: translateY(-3px);
            opacity: 0.7;
        }

        .proceed-link-landing {
            position: absolute;
            bottom: 40px;
            right: 40px;
            z-index: 20;
            transition: var(--transition);
        }
        .proceed-img { 
            height: 50px; 
            width: auto;
        } 
        .proceed-link-landing:hover { transform: scale(1.08); }

        .gallery-container {
            width: 90%; 
            max-width: 1800px;
            margin: 80px auto;
        }

        .bento-grid {
            display: grid;
            grid-template-columns: 24% 1fr; 
            gap: var(--gap-size); 
            height: 850px; 
        }

        .grid-img {
            background-color: var(--card-bg);
            border-radius: var(--radius);
            background-size: cover;
            background-position: center;
            transition: var(--transition);
        }

        .grid-img:hover { transform: scale(1.01); }
        
        .g-item-1 { background-image: url('assets/text/tall_left.png'); }
        .g-item-2 { height: 45%; background-image: url('assets/text/mid_level.png'); }
        .g-item-3 { background-image: url('assets/text/medium_bottom.png'); }
        .g-item-4 { flex: 1; background-image: url('assets/text/small_top.png'); }
        .g-item-5 { flex: 1; background-image: url('assets/text/small_bottom.png'); }

        .right-col { display: flex; flex-direction: column; gap: var(--gap-size); }
        .bottom-row { flex: 1; display: grid; grid-template-columns: 1.5fr 1fr; gap: var(--gap-size); }
        .stacked-col { display: flex; flex-direction: column; gap: var(--gap-size); }

        /* ============================================================
            VIEW 2: DESCRIPTION & EXPLORE STYLES
           ============================================================ */
        .desc-body { background-color: var(--dark-bg); overflow: hidden; height: 100vh; }
        
        .desc-header {
            background-color: var(--light-bg);
            height: 20vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .desc-header .logo-container {
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
            cursor: pointer;
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

        .desc-footer {
            position: absolute;
            bottom: 20px;
            right: 40px;
            color: #ffffff;
            font-size: 14px;
            opacity: 0.5;
            letter-spacing: 1px;
        }

        /* EXPLORE SPECIFIC */
        .explore-body { background-color: var(--amenity-bg); color: white; overflow-x: hidden; }

        .amenities-section {
            background-color: var(--amenity-bg);
            padding-bottom: 50px;
        }

        .explore-header {
            width: 100%;
            padding: 3vw 5vw; 
            display: flex;
            justify-content: flex-start; 
            align-items: center;
        }

        .explore-header .logo-container {
            display: flex;
            align-items: center;
            gap: 1.5vw;
            height: 10vw; 
            min-height: 65px; 
            max-height: 140px; 
        }

        .header-text-img {
            height: 100%;
            width: auto;
            object-fit: contain;
        }

        .amenities-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr); 
            gap: 2vw; 
            width: 94%;
            max-width: 1400px;
            margin: 0 auto; 
        }

        .amenity-card {
            background-color: var(--card-bg);
            border-radius: 2.5vw;
            overflow: hidden; 
            display: flex;
            flex-direction: column;
            border: 2px solid transparent;
            transition: var(--transition-explore);
            text-decoration: none;
        }

        .amenity-card:hover {
            transform: translateY(-5px);
            border-color: var(--highlight-purple);
            box-shadow: 0 10px 25px rgba(125, 95, 255, 0.3);
        }

        .card-image-box {
            aspect-ratio: 4 / 3; 
            width: 100%;
            background-size: cover;
            background-position: center;
        }

        .card-content {
            padding: 2vw; 
            display: flex;
            flex-direction: column;
            background-color: var(--card-bg);
            flex-grow: 1;
            justify-content: center;
        }

        .text-img-title {
            width: 90%;
            height: auto;
            max-height: 80px;
            object-fit: contain;
            align-self: flex-start;
        }

        .awards-section {
            background-color: var(--award-bg);
            padding: 10vh 5vw;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .title-container-explore {
            width: 100%;
            max-width: 1250px; 
            margin-bottom: clamp(20px, 4vw, 60px);
            cursor: pointer;
        }

        .awards-title-img {
            height: clamp(28px, 6vw, 82px); 
            width: auto;
            display: block;
            transition: transform 0.6s var(--bezier-awards);
        }

        .title-container-explore:hover .awards-title-img {
            transform: translateX(15px) scale(1.02);
        }

        .awards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: clamp(10px, 2vw, 30px);
            max-width: 1250px; 
            width: 100%;
        }

        .award-box {
            position: relative;
            border: 1px solid var(--border-color);
            display: flex;
            justify-content: center;
            align-items: center;
            aspect-ratio: 16 / 10;
            background: rgba(255, 255, 255, 0.02);
            cursor: pointer;
            overflow: hidden;
            transition: all 0.4s var(--bezier-awards);
        }

        .award-box:hover {
            transform: translateY(-5px); 
            border-color: var(--hover-border);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .award-text-img {
            width: 80%;
            height: auto;
            max-height: 70%;
            object-fit: contain;
            filter: brightness(0.85);
            transition: all 0.4s var(--bezier-awards);
        }

        .award-box:hover .award-text-img {
            filter: brightness(1.1);
            transform: scale(1.05);
        }

        .bottom-row-wrapper {
            grid-column: 1 / 4;
            display: flex;
            justify-content: center;
            gap: clamp(10px, 2vw, 30px); 
            width: 100%;
        }

        .bottom-box {
            width: calc((100% - (clamp(10px, 2vw, 30px) * 2)) / 3); 
        }

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

        .explore-footer {
            text-align: right;
            padding: 40px 5%;
            opacity: 0.3;
            letter-spacing: 2px;
            font-size: clamp(8px, 1vw, 12px);
            background-color: var(--award-bg);
            color: white;
        }

        /* ============================================================
            VIEW 3: ADMIN LOGIN STYLES
           ============================================================ */
        .admin-body { background-color: var(--admin-bg); color: #000; }
        .admin-header { display: flex; justify-content: space-between; align-items: flex-start; padding: 15px 40px; }
        .logo-img-admin { width: 80px; height: auto; }
        .main-container-admin { display: flex; flex-direction: column; align-items: center; justify-content: flex-start; padding: 20px; margin-top: -90px; }
        .title-container-admin { display: flex; justify-content: center; margin-bottom: 0px; width: 100%; }
        .img-admin { height: 190px; width: auto; display: block; }
        .admin-form { display: flex; flex-direction: column; align-items: center; width: 80%; max-width: 650px; }
        .input-group-admin { width: 100%; margin-bottom: 25px; display: flex; flex-direction: column; align-items: flex-start; }
        .label-img-admin { height: 28px; width: auto; margin-bottom: 12px; margin-left: 25px; }
        .admin-input { width: 100%; padding: 18px 35px; border-radius: 60px; border: none; background-color: var(--input-bg); font-size: 18px; outline: none; box-shadow: inset 3px 3px 6px rgba(0,0,0,0.06); box-sizing: border-box; text-align: center; font-family: 'Montserrat'; }
        .btn-bubble { display: inline-flex; align-items: center; justify-content: center; border-radius: 70px; padding: 18px 60px; margin-top: 15px; text-decoration: none; transition: transform 0.2s, opacity 0.2s; border: none; cursor: pointer; width: auto; }
        .btn-confirm-bubble { background-color: var(--btn-confirm-bg); box-shadow: 0 6px 18px rgba(140, 130, 125, 0.4); }
        .btn-return-bubble { background-color: var(--btn-return-bg); box-shadow: 0 6px 18px rgba(59, 66, 82, 0.4); }
        .btn-bubble:hover { opacity: 0.95; transform: scale(1.04); }
        .img-btn-text { height: 34px; width: auto; pointer-events: none; display: block; }

        /* ============================================================
            VIEW 4: WELCOME STYLES
           ============================================================ */
        .welcome-body {
            background-color: #dbdbdb;
            color: #000;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .header-welcome {
            padding: 4vh 5vw;
            display: flex;
            justify-content: flex-start;
            z-index: 10;
        }

        .logo-img-welcome {
            width: 10vw;
            min-width: 80px;
            height: auto;
            display: block;
        }

        .main-content-welcome {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start; 
            padding-top: 5vh; 
            text-align: center;
            padding-left: 5vw;
            padding-right: 5vw;
        }

        .welcome-container-welcome {
            display: flex;
            justify-content: center;
            margin-bottom: 1vh; 
        }

        .img-welcome-v {
            height: 22vh;
            width: auto;
            max-width: 90vw;
            object-fit: contain;
        }

        .img-subtitle-welcome {
            height: 7vh;
            width: auto;
            max-width: 80vw;
            object-fit: contain;
        }

        .proceed-container-welcome {
            position: absolute;
            bottom: 6vh;
            right: 6vw;
        }

        .proceed-link-welcome {
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: transform 0.2s ease, opacity 0.3s;
        }

        .proceed-link-welcome:hover {
            opacity: 0.7;
            transform: translateY(-2px);
        }

        .img-proceed-text-welcome {
            height: 4vh;
            width: auto;
            max-width: 40vw;
        }

        /* ============================================================
            VIEW 5: MAIN MENU STYLES
           ============================================================ */
        .menu-body { background-color: var(--dark-bg); }
        .top-section-menu {
            background-color: var(--light-bg);
            height: 35vh; 
            min-height: 250px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        .nav-bar-menu {
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
        .logo-main-menu { width: 120px; height: auto; }
        .title-img-menu {
            width: 500px; 
            max-width: 85%;
            height: auto;
            margin-top: 30px;
        }
        .bottom-section-menu {
            flex: 1; 
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 40px; 
            padding: 40px;
            flex-wrap: wrap;
        }
        .card-link-menu {
            width: 420px; 
            height: 420px; 
            position: relative;
            border-radius: 30px;
            overflow: hidden;
            text-decoration: none;
            transition: transform 0.3s ease;
            background-color: #8f8989; 
        }
        .card-link-menu:hover { transform: scale(1.05); }
        .card-bg-image-menu {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0.4; 
            transition: opacity 0.3s ease;
        }
        .card-link-menu:hover .card-bg-image-menu { opacity: 0.6; }
        .overlay-menu {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.4); 
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card-title-img-menu {
            width: 260px; 
            max-width: 80%;
            height: auto;
            z-index: 2;
        }
        .img-edit { background-image: url('assets/text/bg-edit.png'); }
        .img-view { background-image: url('assets/text/bg-view.png'); }

        /* ============================================================
            VIEW 6: EDIT DATABASE STYLES
           ============================================================ */
        .edit-body { background-color: var(--dark-bg); color: var(--text-white); font-family: var(--font-sans); }
        
        .top-section-edit {
            background-color: var(--light-bg);
            height: 25vh; 
            min-height: 160px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            padding: 0 5%;
        }

        .nav-bar-edit {
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

        .custom-logo-edit {
            width: 8vw;
            min-width: 80px;
            max-width: 120px;
            height: auto;
        }

        .title-container-edit {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .img-main-title-edit {
            height: 12vh;
            max-width: 80%;
            width: auto;
            object-fit: contain;
        }

        .bottom-section-edit {
            background-color: var(--dark-bg);
            flex: 1;
            padding: 4vh 5%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .banner-container-edit {
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

        .banner-bg-edit {
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

        .img-banner-label-edit {
            position: relative;
            z-index: 2; 
            height: 75%; 
            width: auto;
            max-width: 90%;
            object-fit: contain;
            filter: drop-shadow(0px 6px 12px rgba(0,0,0,0.4));
        }

        .options-grid-edit {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2vw;
            width: 90%;
            max-width: 1200px;
        }

        .option-item-edit {
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }

        .option-item-edit:hover {
            transform: translateY(-8px);
        }

        .option-box-edit {
            border: 1px solid rgba(255, 255, 255, 0.7); 
            height: 20vh;
            min-height: 120px;
            display: flex;
            align-items: center;
            justify-content: flex-start; 
            padding: 1.5vw 2.5vw; 
            text-decoration: none;
            box-sizing: border-box;
        }

        .img-option-text-edit {
            max-width: 100%;
            max-height: 85%;
            object-fit: contain;
        }

        .proceed-link-edit {
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

        .proceed-link-edit svg {
            width: 1.5vw;
            min-width: 15px;
            margin-left: 0.5vw;
        }

        .return-btn-container-edit {
            width: 90%;
            max-width: 1200px;
            display: flex;
            justify-content: flex-end;
            margin-top: 10vh;
            padding-bottom: 5vh;
        }

        .btn-return-edit {
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

        .btn-return-edit:hover { transform: scale(1.05); }

        /* ============================================================
            VIEW 7: VIEW DATABASE STYLES
           ============================================================ */
        .view-db-body { background-color: var(--dark-bg); color: var(--text-view-white); font-family: var(--font-sans); }

        .top-section-view {
            background-color: var(--light-bg);
            height: 22vh; 
            min-height: 140px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            padding: 0 5%;
        }

        .nav-bar-view {
            position: absolute;
            top: 2vh; 
            left: 5%;
            right: 5%;
            display: flex;
            justify-content: space-between;
            align-items: flex-start; 
            z-index: 10;
        }

        .custom-logo-view {
            width: 8vw;
            min-width: 80px;
            max-width: 120px;
            height: auto;
        }

        .btn-return-view {
            margin-top: 13vh; 
            background-color: var(--btn-blue);
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .btn-return-view:hover { 
            background-color: #4e5e7a;
            opacity: 0.9;
        }

        .title-container-view {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .img-main-title-view {
            height: 12vh;
            max-width: 80%;
            object-fit: contain;
        }

        .bottom-section-view {
            background-color: var(--dark-bg);
            flex: 1;
            padding: 4vh 5% 5vh 5%;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .banner-container-view {
            width: 100%;
            max-width: 1100px;
            height: 20vh; 
            margin-bottom: 6vh;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: visible; 
            border-radius: 20px;
            background-color: var(--banner-tint-view);
        }

        .banner-bg-view {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('assets/text/banner-background-bubble.png'); 
            background-size: cover;
            background-position: center;
            opacity: 0.15; 
            border-radius: 20px;
        }

        .img-banner-label-view {
            position: relative;
            z-index: 2; 
            height: 60%;
            width: auto;
            object-fit: contain;
            transform: scale(2.0); 
            filter: drop-shadow(0px 10px 15px rgba(0,0,0,0.4));
        }

        .options-grid-view {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            width: 100%;
            max-width: 1100px;
            margin-bottom: 30px;
            margin-top: 2vh;
        }

        .option-item-view {
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }

        .option-item-view:hover { transform: translateY(-5px); }

        .option-box-view {
            border: 1px solid rgba(255, 255, 255, 0.8); 
            height: 140px;
            display: flex;
            align-items: center;
            justify-content: flex-start; 
            padding-left: 20px;
            text-decoration: none;
            box-sizing: border-box;
        }

        .report-item-view {
            width: 100%;
            max-width: 1100px;
            margin-top: 10px;
        }

        .img-option-text-view {
            max-height: 70%;
            max-width: 90%;
            object-fit: contain;
        }

        .proceed-link-view {
            margin-top: 8px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            color: var(--text-view-white);
            display: flex;
            justify-content: flex-end;
            align-items: center;
            text-decoration: none;
        }

        .proceed-link-view svg {
            width: 18px;
            margin-left: 8px;
        }

        /* ============================================================
            VIEW 8: PUBLISHERS & TITLES SEARCH STYLES
           ============================================================ */
        .pub-body { display: flex; flex-direction: column; height: 100vh; background-color: var(--dark-bg); color: #000; }

        .top-section-pub {
            background-color: var(--dark-bg);
            height: 45%;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 130px;
        }

        .logo-top-pub {
            position: absolute;
            top: 30px;
            width: 220px;
            max-width: 40vw;
            min-width: 180px;
        }

        .page-title-img-pub {
            width: 520px;
            max-width: 90%;
        }

        .bottom-section-pub {
            background-color: var(--light-bg);
            height: 55%;
            padding: 20px 30px 15px;
            display: flex;
            flex-direction: column;
        }

        .form-container-pub {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .admin-form-pub {
            width: 100%;
            max-width: 600px;
            text-align: center;
        }

        .input-group-pub {
            margin-bottom: 22px;
            text-align: left;
        }

        .label-img-pub {
            width: 180px;
            margin: 0 0 10px 15px;
        }

        .input-wrapper-pub {
            position: relative;
        }

        .search-icon-pub {
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

        .pub-input {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border-radius: 50px;
            border: none;
            outline: none;
            background-color: var(--pub-input-bg);
            font-size: 16px;
            font-family: 'Montserrat';
        }

        .placeholder-img-pub {
            position: absolute;
            left: 50px;
            top: 50%;
            transform: translateY(-50%);
            width: 90px;
            opacity: 0.6;
            pointer-events: none;
        }

        .pub-input:focus + .placeholder-img-pub,
        .pub-input:not(:placeholder-shown) + .placeholder-img-pub {
            display: none;
        }

        .btn-confirm-wrap-pub,
        .btn-return-wrap-pub {
            margin: 14px auto 0;
            border-radius: 50px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            border: none;
            transition: transform 0.2s ease, filter 0.2s ease;
        }

        .btn-confirm-wrap-pub {
            background-color: var(--pub-btn-confirm);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            padding: 10px 35px;
        }

        .btn-return-wrap-pub {
            background-color: var(--pub-btn-return);
            box-shadow: 0 5px 12px rgba(0,0,0,0.25);
            margin-top: 18px; 
            padding: 14px 45px; 
            max-width: 80%;
        }

        .btn-img-pub {
            display: block;
            width: 90px; 
        }

        .btn-return-wrap-pub .btn-img-pub {
            width: 180px; 
            max-width: 100%;
            height: auto;
        }

        .btn-confirm-wrap-pub:hover, .btn-return-wrap-pub:hover {
            transform: scale(1.03); 
            filter: brightness(1.1);
        }

        .footer-pub {
            display: flex;
            justify-content: flex-end; 
            align-items: center;
            padding-top: 10px;
        }

        .footer-text-img-pub {
            width: 120px;
        }

        /* --- RESPONSIVE ADJUSTMENTS --- */
        @media (max-width: 1024px) {
            .bento-grid { height: 700px; }
            .grid-container { grid-template-columns: 1fr; grid-template-rows: repeat(4, 250px); overflow-y: auto; }
            .card-link-menu { width: 340px; height: 340px; }
            .title-img-menu { width: 400px; }
        }

        @media (max-width: 800px) {
            /* Edit Specific */
            .proceed-link-edit { font-size: 10px; }
            .btn-return-edit { font-size: 12px; }
            .banner-container-edit { height: 120px; }
            .option-box-edit { padding-left: 15px; height: 100px; }
            .return-btn-container-edit { margin-top: 6vh; }
            
            /* View Specific */
            .options-grid-view { grid-template-columns: 1fr; }
            .img-banner-label-view { transform: scale(1.4); }
            .nav-bar-view { top: 2vh; } 
            .btn-return-view { margin-top: 20px; padding: 8px 15px; font-size: 11px; }

            /* Pub Specific */
            .logo-top-pub { width: 110px; top: 20px; }
            .top-section-pub { padding-top: 110px; }
            .page-title-img-pub { width: 380px; }
            .btn-return-wrap-pub { padding: 10px 30px; }
            .btn-return-wrap-pub .btn-img-pub { width: 140px; }
        }

        @media (max-width: 768px) {
            .hero { height: 80vh; min-height: 500px; }
            .bento-grid { grid-template-columns: 1fr; height: auto; }
            .g-item-1 { height: 400px; }
            .right-col { height: 1000px; }
            .overlay-solace-img { width: 80vw; margin-left: 0; margin-bottom: 0; }
            .nav-top { top: 110px; padding: 0 30px; }
            .nav-img { height: 22px; } 
            .subtitle-img { height: 35px; }
            .proceed-img { height: 40px; }
            .amenities-container { gap: 1vw; width: 98%; grid-template-columns: 1fr; }
            .main-container-admin { margin-top: -40px; }
            .img-admin { height: 150px; } 
            .btn-bubble { padding: 15px 45px; }
            .top-section-menu { height: auto; padding: 100px 20px 40px; }
            .nav-bar-menu { padding: 0 30px; top: 20px; }
            .card-link-menu { width: 100%; max-width: 380px; height: 300px; }
        }
    </style>
</head>
<body class="<?php 
    if($view === 'landing') echo '';
    elseif($view === 'description') echo 'desc-body'; 
    elseif($view === 'explore') echo 'explore-body'; 
    elseif($view === 'login') echo 'admin-body';
    elseif($view === 'welcome') echo 'welcome-body';
    elseif($view === 'main_menu') echo 'menu-body';
    elseif($view === 'edit_db') echo 'edit-body';
    elseif($view === 'view_db') echo 'view-db-body';
    elseif($view === 'pub_titles') echo 'pub-body';
?>">

<?php if ($view === 'landing'): ?>
    <header class="hero">
        <div class="subtitle-underline"></div>
        <div class="hero-top-center">
            <img src="assets/text/text-bespoke-solitude.png" alt="Bespoke Solitude" class="subtitle-img img-text">
        </div>
        <nav class="nav-top">
            <a href="#"><img src="assets/text/text-metro-manila.png" alt="Metro Manila" class="nav-img img-text"></a>
            <a href="<?php echo $login_page; ?>"><img src="assets/text/text-admin-login.png" alt="Admin Login" class="nav-img img-text"></a>
        </nav>
        <div class="script-overlay">
            <img src="assets/text/text-overlay-solace.png" alt="Solace" class="overlay-solace-img img-text">
        </div>
        <a href="<?php echo $menu_page; ?>" class="proceed-link-landing">
            <img src="assets/text/text-proceed-button.png" alt="Proceed" class="proceed-img img-text">
        </a>
    </header>

    <section class="gallery-container" style="background-color: #20252d; padding: 60px 0; width: 100%; max-width: none; margin: 0;">
        <div class="bento-grid" style="width: 90%; margin: 0 auto; max-width: 1800px;">
            <div class="grid-img g-item-1"></div>
            <div class="right-col">
                <div class="grid-img g-item-2"></div>
                <div class="bottom-row">
                    <div class="grid-img g-item-3"></div>
                    <div class="stacked-col">
                        <div class="grid-img g-item-4"></div>
                        <div class="grid-img g-item-5"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php elseif ($view === 'description'): ?>
    <header class="desc-header">
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
        <a href="?view=explore" class="bento-item card-explore">
            <img src="assets/text/about_explore.png" alt="Explore" class="text-img">
        </a>
        <a href="<?php echo $about_menu; ?>" class="bento-item card-menu">
            <img src="assets/text/about_main_menu.png" alt="Main Menu" class="text-img">
        </a>
    </div>
    <div class="desc-footer">BY GROUP 2</div>

    <?php elseif ($view === 'about_main_menu'): ?>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400&family=Montserrat:wght@600&display=swap');
        .mm-container { background-color: #dbdbdb; font-family: 'Montserrat', sans-serif; color: #1a1a1a; margin: 0; min-height: 100vh; overflow-x: hidden; }
        .mm-header { display: flex; justify-content: center; align-items: flex-start; padding: 0px 40px; position: relative; min-height: 150px; }
        .mm-logo { width: 100px; height: auto; margin-top: 45px; position: absolute; left: 40px; z-index: 10; }
        .mm-title-cont { text-align: center; line-height: 0; margin-top: 110px; }
        .mm-title-img { height: 160px; width: auto; display: inline-block; }
        .mm-grid { max-width: 1200px; margin: 60px auto 0; padding: 0 40px 80px 40px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; }
        .mm-grid-item { display: flex; flex-direction: column; text-decoration: none; cursor: pointer; color: inherit; }
        .mm-box { border: 1px solid #999; height: 140px; padding: 20px; display: flex; align-items: center; justify-content: flex-start; transition: all 0.3s ease; background-color: transparent; }
        .mm-grid-item:hover .mm-box { background-color: rgba(0,0,0,0.05); border-color: #000; }
        .mm-box img { max-width: 90%; max-height: 70%; object-fit: contain; }
        .mm-proceed { margin-top: 10px; font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: #444; display: flex; justify-content: flex-end; align-items: center; transition: color 0.3s ease; }
        .mm-proceed svg { width: 18px; height: 10px; margin-left: 8px; fill: none; stroke: currentColor; stroke-width: 2.5; transition: transform 0.3s ease; }
        .mm-grid-item:hover .mm-proceed { color: #000; }
        .mm-grid-item:hover .mm-proceed svg { transform: translateX(8px); }
        .mm-full { grid-column: 1 / -1; }
        .mm-full .mm-box { height: 100px; }

        @media (max-width: 900px) {
            .mm-logo { width: 60px; left: 20px; margin-top: 20px; }
            .mm-title-img { height: 100px; }
            .mm-title-cont { margin-top: 80px; }
            .mm-grid { grid-template-columns: repeat(3, 1fr); padding: 0 20px 40px 20px; gap: 15px; }
            .mm-box { height: 100px; padding: 10px; }
        }
    </style>

    <div class="mm-container">
        <header class="mm-header">
            <img src="assets/text/logo-img.png" alt="Logo" class="mm-logo">
            <div class="mm-title-cont">
                <img src="assets/text/title-main-menu.png" alt="Main Menu" class="mm-title-img">
            </div>
        </header>

        <main class="mm-grid">
            <a href="?view=pub_titles" class="mm-grid-item">
                <div class="mm-box"><img src="assets/text/text-publishers-titles.png" alt="Publishers and Titles"></div>
                <div class="mm-proceed">PROCEED <svg viewBox="0 0 24 12"><path d="M0 6L22 6M22 6L17 1M22 6L17 11"></path></svg></div>
            </a>

            <a href="?view=pub_emp" class="mm-grid-item">
                <div class="mm-box"><img src="assets/text/text-publishers-employees.png" alt="Publishers and Employees"></div>
                <div class="mm-proceed">PROCEED <svg viewBox="0 0 24 12"><path d="M0 6L22 6M22 6L17 1M22 6L17 11"></path></svg></div>
            </a>

            <a href="?view=auth_titles" class="mm-grid-item">
                <div class="mm-box"><img src="assets/text/text-authors-titles.png" alt="Authors and Titles"></div>
                <div class="mm-proceed">PROCEED <svg viewBox="0 0 24 12"><path d="M0 6L22 6M22 6L17 1M22 6L17 11"></path></svg></div>
            </a>

            <a href="?view=report" class="mm-grid-item mm-full">
                <div class="mm-box"><img src="assets/text/text-report.png" alt="Report"></div>
                <div class="mm-proceed">PROCEED <svg viewBox="0 0 24 12"><path d="M0 6L22 6M22 6L17 1M22 6L17 11"></path></svg></div>
            </a>
        </main>
    </div>

<?php elseif ($view === 'explore'): ?>
    <section class="amenities-section">
        <header class="explore-header">
            <div class="logo-container">
                <img src="assets/text/logo-img.png" alt="Icon" class="header-logo">
                <img src="assets/text/logo-text-white.png" alt="Ink & Solace" class="header-text-img">
            </div>
        </header>
        <main class="amenities-container">
            <div class="amenity-card">
                <div class="card-image-box" style="background-image: url('assets/text/concierge-bg.png');"></div>
                <div class="card-content"><img src="assets/text/title_concierge.png" alt="24/7 Concierge" class="text-img-title"></div>
            </div>
            <div class="amenity-card">
                <div class="card-image-box" style="background-image: url('assets/text/rooftop-bg.png');"></div>
                <div class="card-content"><img src="assets/text/title_rooftop.png" alt="Rooftop Lounge" class="text-img-title"></div>
            </div>
            <div class="amenity-card">
                <div class="card-image-box" style="background-image: url('assets/text/restaurant-bg.png');"></div>
                <div class="card-content"><img src="assets/text/title_restaurant.png" alt="Restaurant" class="text-img-title"></div>
            </div>
        </main>
    </section>
    <section class="awards-section">
        <div class="title-container-explore"><img src="assets/text/title_awards.png" alt="AWARDS" class="awards-title-img"></div>
        <div class="awards-grid">
            <div class="award-box"><img src="assets/text/award_sustainability.png" class="award-text-img"></div>
            <div class="award-box"><img src="assets/text/award_technology.png" class="award-text-img"></div>
            <div class="award-box"><img src="assets/text/award_marketing.png" class="award-text-img"></div>
            <div class="bottom-row-wrapper">
                <div class="award-box bottom-box"><img src="assets/text/award_no1.png" class="award-text-img"></div>
                <div class="award-box bottom-box"><img src="assets/text/award_hallfame.png" class="award-text-img"></div>
            </div>
        </div>
    </section>
    <div class="explore-footer">BY GROUP 2</div>

<?php elseif ($view === 'login'): ?>
    <header class="admin-header"><img src="assets/text/logo-img.png" class="logo-img-admin"></header>
    <div class="main-container-admin">
        <div class="title-container-admin"><img src="assets/text/text-admin.png" class="img-admin"></div>
        <form action="?view=login" method="POST" class="admin-form">
            <div class="input-group-admin">
                <img src="assets/text/label-username.png" class="label-img-admin">
                <input type="text" name="username" class="admin-input" required>
            </div>
            <div class="input-group-admin">
                <img src="assets/text/label-password.png" class="label-img-admin">
                <input type="password" name="password" class="admin-input" required>
            </div>
            <button type="submit" class="btn-bubble btn-confirm-bubble"><img src="assets/text/btn-confirm.png" class="img-btn-text"></button>
            <a href="?view=landing" class="btn-bubble btn-return-bubble"><img src="assets/text/btn-return.png" class="img-btn-text"></a>
        </form>
    </div>

<?php elseif ($view === 'welcome'): ?>
    <header class="header-welcome"><img src="assets/text/logo-img.png" class="logo-img-welcome"></header>
    <main class="main-content-welcome">
        <div class="welcome-container-welcome"><img src="assets/text/text-welcome.png" class="img-welcome-v"></div>
        <img src="assets/text/text-subtitle.png" class="img-subtitle-welcome">
    </main>
    <div class="proceed-container-welcome">
        <a href="?view=main_menu" class="proceed-link-welcome"><img src="assets/text/btn-proceed-menu.png" class="img-proceed-text-welcome"></a>
    </div>

<?php elseif ($view === 'main_menu'): ?>
    <div class="top-section-menu">
        <div class="nav-bar-menu"><img src="assets/text/logo-img.png" class="logo-main-menu"></div>
        <img src="assets/text/title-main-menu.png" class="title-img-menu">
    </div>
    <div class="bottom-section-menu">
        <a href="?view=edit_db" class="card-link-menu">
            <div class="card-bg-image-menu img-edit"></div>
            <div class="overlay-menu"><img src="assets/text/label-edit-database.png" class="card-title-img-menu"></div>
        </a>
        <a href="?view=view_db" class="card-link-menu">
            <div class="card-bg-image-menu img-view"></div>
            <div class="overlay-menu"><img src="assets/text/label-view-database.png" class="card-title-img-menu"></div>
        </a>
    </div>

<?php elseif ($view === 'edit_db'): ?>
    <div class="top-section-edit">
        <div class="nav-bar-edit"><img src="assets/text/logo-img.png" class="custom-logo-edit"></div>
        <div class="title-container-edit"><img src="assets/text/title-main-menu.png" class="img-main-title-edit"></div>
    </div>
    <div class="bottom-section-edit">
        <div class="banner-container-edit">
            <div class="banner-bg-edit"></div> 
            <img src="assets/text/label-edit-database.png" class="img-banner-label-edit">
        </div>
        <div class="options-grid-edit">
            <div class="option-item-edit">
                <a href="?view=pub_titles" class="option-box-edit"><img src="assets/text/text-opt-publishers-titles.png" class="img-option-text-edit"></a>
                <a href="?view=pub_titles" class="proceed-link-edit">PROCEED <svg viewBox="0 0 24 12" stroke="currentColor" stroke-width="2"><path d="M0 6L22 6M22 6L17 1M22 6L17 11"></path></svg></a>
            </div>
            <div class="option-item-edit">
                <a href="?view=pub_emp" class="option-box-edit"><img src="assets/text/text-opt-publishers-employees.png" class="img-option-text-edit"></a>
                <a href="?view=pub_emp"  class="proceed-link-edit">PROCEED <svg viewBox="0 0 24 12" stroke="currentColor" stroke-width="2"><path d="M0 6L22 6M22 6L17 11"></path></svg></a>
            </div>
            <div class="option-item-edit">
                <a href="?view=auth_titles" class="option-box-edit"><img src="assets/text/text-opt-authors-titles.png" class="img-option-text-edit"></a>
                <a href="?view=auth_titles" class="proceed-link-edit">PROCEED <svg viewBox="0 0 24 12" stroke="currentColor" stroke-width="2"><path d="M0 6L22 6M22 6L17 1M22 6L17 11"></path></svg></a>
            </div>
        </div>
        <div class="return-btn-container-edit"><a href="?view=main_menu" class="btn-return-edit">Return to Main Menu</a></div>
    </div>

<?php elseif ($view === 'view_db'): ?>
    <div class="top-section-view">
        <div class="nav-bar-view">
            <img src="assets/text/logo-img.png" alt="Ink & Solace" class="custom-logo-view">
            <a href="?view=main_menu" class="btn-return-view">Return to Main Menu</a>
        </div>
        <div class="title-container-view">
            <img src="assets/text/title-main-menu.png" alt="Main Menu" class="img-main-title-view">
        </div>
    </div>
    <div class="bottom-section-view">
        <div class="banner-container-view">
            <div class="banner-bg-view"></div> 
            <img src="assets/text/label-view-database.png" alt="View Database" class="img-banner-label-view">
        </div>
        <div class="options-grid-view">
            <div class="option-item-view">
                <a href="?view=pub_titles_display" class="option-box-view">
                    <img src="assets/text/text-opt-publishers-titles.png" alt="Publishers & Titles" class="img-option-text-view">
                </a>
                <a href="?view=pub_titles_display" class="proceed-link-view">
                    PROCEED <svg viewBox="0 0 24 12" fill="none" stroke="currentColor" stroke-width="2"><path d="M0 6L22 6M22 6L17 1M22 6L17 11"></path></svg>
                </a>
            </div>
            <div class="option-item-view">
                <a href="?view=pub_emp_display" class="option-box-view">
                    <img src="assets/text/text-opt-publishers-employees.png" alt="Publishers & Employees" class="img-option-text-view">
                </a>
                <a href="?view=pub_emp_display" class="proceed-link-view">
                    PROCEED <svg viewBox="0 0 24 12" fill="none" stroke="currentColor" stroke-width="2"><path d="M0 6L22 6M22 6L17 1M22 6L17 11"></path></svg>
                </a>
            </div>
            <div class="option-item-view">
                <a href="?view=auth_titles_display" class="option-box-view">
                    <img src="assets/text/text-opt-authors-titles.png" alt="Authors & Titles" class="img-option-text-view">
                </a>
                <a href="?view=auth_titles_display" class="proceed-link-view">
                    PROCEED <svg viewBox="0 0 24 12" fill="none" stroke="currentColor" stroke-width="2"><path d="M0 6L22 6M22 6L17 1M22 6L17 11"></path></svg>
                </a>
            </div>
        </div>
        <div class="report-item-view">
            <div class="option-item-view">
                <a href="?view=report" class="option-box-view">
                    <img src="assets/text/text-opt-report.png" alt="REPORT" class="img-option-text-view">
                </a>
                <a href="?view=report" class="proceed-link-view">
                    PROCEED <svg viewBox="0 0 24 12" fill="none" stroke="currentColor" stroke-width="2"><path d="M0 6L22 6M22 6L17 1M22 6L17 11"></path></svg>
                </a>
            </div>
        </div>
    </div>


<?php elseif ($view === 'pub_titles'): ?>
    <div class="top-section-pub">
        <img src="assets/text/logo.png" class="logo-top-pub" alt="Logo">
        <img src="assets/text/title-publishers-titles.png" class="page-title-img-pub" alt="Publishers & Titles">
    </div>

    <div class="bottom-section-pub">
        <div class="form-container-pub">
            <form action="?view=pub_titles" method="POST" class="admin-form-pub">

                <div class="input-group-pub">
                    <img src="assets/text/label-publisher.png" class="label-img-pub" alt="Publisher">
                    <div class="input-wrapper-pub">
                        <svg class="search-icon-pub" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <input type="text" name="publisher" class="pub-input" placeholder=" " value="<?php echo $publisher_search; ?>">
                        <img src="assets/text/placeholder-search.png" class="placeholder-img-pub" alt="">
                    </div>
                </div>

                <div class="input-group-pub">
                    <img src="assets/text/label-title.png" class="label-img-pub" alt="Title">
                    <div class="input-wrapper-pub">
                        <svg class="search-icon-pub" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <input type="text" name="title" class="pub-input" placeholder=" " value="<?php echo $title_search; ?>">
                        <img src="assets/text/placeholder-search.png" class="placeholder-img-pub" alt="">
                    </div>
                </div>

                <button type="submit" class="btn-confirm-wrap-pub">
                    <img src="assets/text/btn-confirm.png" class="btn-img-pub" alt="Confirm">
                </button>

                <div style="display: block;">
                    <a href="?view=main_menu" style="text-decoration:none;">
                        <div class="btn-return-wrap-pub">
                            <img src="assets/text/btn-return.png" class="btn-img-pub" alt="Return to Main Menu">
                        </div>
                    </a>
                </div>

            </form>
        </div>

        <footer class="footer-pub">
            <img src="assets/text/footer-by-group2.png" class="footer-text-img-pub" alt="">
        </footer>
    </div>

<?php elseif ($view === 'pub_emp'): ?>
<div class="pub-body">
    <div class="top-section-pub">
        <img src="assets/text/logo.png" class="logo-top-pub" alt="Logo">
        <img src="assets/text/title-publishers-employees.png" class="page-title-img-pub" alt="Publishers & Employees">
    </div>

    <div class="bottom-section-pub">
        <div class="form-container-pub">
            <form action="?view=pub_emp" method="POST" class="admin-form-pub">

                <div class="input-group-pub">
                    <img src="assets/text/label-publisher.png" class="label-img-pub" alt="Publisher">
                    <div class="input-wrapper-pub">
                        <svg class="search-icon-pub" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <input type="text" name="publisher" class="pub-input" placeholder=" " value="<?php echo $publisher_search; ?>">
                        <img src="assets/text/placeholder-search.png" class="placeholder-img-pub" alt="">
                    </div>
                </div>

                <div class="input-group-pub">
                    <img src="assets/text/label-employee.png" class="label-img-pub" alt="Employee">
                    <div class="input-wrapper-pub">
                        <svg class="search-icon-pub" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <input type="text" name="employee" class="pub-input" placeholder=" " value="<?php echo $employee_search; ?>">
                        <img src="assets/text/placeholder-search.png" class="placeholder-img-pub" alt="">
                    </div>
                </div>

                <button type="submit" class="btn-confirm-wrap-pub">
                    <img src="assets/text/btn-confirm.png" class="btn-img-pub" alt="Confirm">
                </button>

                <div style="display: block;">
                    <a href="?view=edit_db" style="text-decoration:none;">
                        <div class="btn-return-wrap-pub">
                            <img src="assets/text/btn-return.png" class="btn-img-pub" alt="Return to Edit Menu">
                        </div>
                    </a>
                </div>

            </form>
        </div>
        <footer class="footer-pub">
            <span style="font-family: 'Montserrat'; color: #666; font-size: 14px;">By Group 2</span>
        </footer>
    </div>
</div>
<?php elseif ($view === 'auth_titles'): ?>
    <style>
        :root {
            --auth-light: #dbdbdb; 
            --auth-dark: #20252d;
            --auth-input: #f2f2f2;
            --auth-confirm: #8f8989;
            --auth-return: #3c4862;
            --auth-transition: all 0.3s ease;
        }

        .auth-container {
            margin: 0; padding: 0; height: 100vh;
            display: flex; flex-direction: column;
            background-color: var(--auth-light);
            font-family: 'Montserrat', sans-serif;
        }

        .auth-top {
            background-color: var(--auth-dark);
            height: 45%;
            position: relative;
            display: flex; justify-content: center; align-items: center;
            padding-top: 60px;
        }

        .auth-logo { position: absolute; top: 30px; width: 200px; }
        .auth-title-img { width: 500px; max-width: 85%; height: auto; }

        .auth-bottom {
            flex: 1; padding: 20px;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
        }

        .auth-form { width: 100%; max-width: 500px; text-align: center; }

        .auth-input-group { margin-bottom: 20px; text-align: left; }
        .auth-label-img { width: 150px; margin-bottom: 10px; display: block; margin-left: 10px; }

        .auth-wrapper { position: relative; width: 100%; }
        .auth-icon {
            position: absolute; left: 18px; top: 50%;
            transform: translateY(-50%); width: 18px; height: 18px;
            stroke: #666; stroke-width: 2; fill: none;
        }

        .auth-input {
            width: 100%; padding: 14px 20px 14px 50px;
            border-radius: 50px; border: none; outline: none;
            background-color: var(--auth-input); font-size: 16px;
        }

        /* --- BUTTON ANIMATIONS --- */
        .auth-btn-confirm {
            background-color: var(--auth-confirm);
            border-radius: 50px; padding: 10px 40px;
            cursor: pointer; border: none;
            transition: var(--auth-transition);
            margin-bottom: 15px;
        }

        .auth-btn-return {
            background-color: var(--auth-return);
            border-radius: 50px; padding: 12px 40px;
            cursor: pointer; border: none;
            transition: var(--auth-transition);
            display: inline-flex;
        }

        .auth-btn-confirm:hover, .auth-btn-return:hover {
            transform: translateY(-3px); /* Button pops up */
            filter: brightness(1.15);    /* Button gets brighter */
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .auth-footer { width: 100%; display: flex; justify-content: flex-end; padding: 20px; }
    </style>

    <div class="auth-container">
        <div class="auth-top">
            <img src="assets/text/logo.png" class="auth-logo" alt="Logo">
            <img src="assets/text/title-authors-titles.png" class="auth-title-img" alt="Authors & Titles">
        </div>

        <div class="auth-bottom">
            <form action="?view=auth_titles" method="POST" class="auth-form">
                <div class="auth-input-group">
                    <img src="assets/text/label-author.png" class="auth-label-img" alt="Author">
                    <div class="auth-wrapper">
                        <svg class="auth-icon" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <input type="text" name="author" class="auth-input" placeholder="SEARCH" value="<?php echo $author_search; ?>">
                    </div>
                </div>

                <div class="auth-input-group">
                    <img src="assets/text/label-title.png" class="auth-label-img" alt="Title">
                    <div class="auth-wrapper">
                        <svg class="auth-icon" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <input type="text" name="title" class="auth-input" placeholder="SEARCH" value="<?php echo $title_search; ?>">
                    </div>
                </div>

                <button type="submit" class="auth-btn-confirm">
                    <img src="assets/text/btn-confirm.png" style="width:80px;" alt="Confirm">
                </button>

                <div style="margin-top: 10px;">
                    <a href="?view=edit_db" style="text-decoration:none;">
                        <div class="auth-btn-return">
                            <img src="assets/text/btn-return.png" style="width:150px;" alt="Return">
                        </div>
                    </a>
                </div>
            </form>
        </div>

        <div class="auth-footer">
            <span style="color:#666; font-size:14px;">By Group 2</span>
        </div>
    </div>

<?php elseif ($view === 'pub_titles_display'): ?>
    <style>
        .pub-display-body { 
            display: flex; flex-direction: column; height: 100vh; margin: 0; 
            background-color: #dbdbdb; font-family: 'Segoe UI', Arial, sans-serif;
        }

        .pub-top-section {
            background-color: #20252d; height: 45%;
            position: relative; display: flex; justify-content: center;
            align-items: center; padding-top: 130px;
        }

        .pub-logo-top { position: absolute; top: 30px; width: 220px; }
        .pub-page-title-img { width: 520px; max-width: 90%; }

        .pub-bottom-section {
            background-color: #dbdbdb; height: 55%;
            padding: 20px 50px; display: flex; flex-direction: column;
        }

        .pub-results-label-img { width: 150px; margin-top: 20px; align-self: flex-start; }

        .pub-results-container {
            flex: 1; display: flex; justify-content: center;
            align-items: center; text-align: center;
        }

        .pub-data-text {
            font-family: 'Times New Roman', Times, serif; font-size: 2.5rem;
            color: #3c4862; letter-spacing: 2px; font-weight: normal;
        }

        .pub-footer-nav { display: flex; justify-content: flex-end; padding-bottom: 25px; }

        .pub-btn-back-wrap {
            background-color: #3c4862; padding: 12px 45px;
            border-radius: 50px; cursor: pointer; border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: all 0.3s ease; display: flex; align-items: center; text-decoration: none;
        }

        .pub-btn-back-wrap:hover {
            transform: translateY(-2px);
            background-color: #4a5a7a;
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }

        .pub-btn-back-img { width: 60px; display: block; }

        @media (max-width: 768px) {
            .pub-logo-top { width: 110px; }
            .pub-page-title-img { width: 380px; }
            .pub-data-text { font-size: 1.8rem; }
        }
    </style>

    <div class="pub-display-body">
        <div class="pub-top-section">
            <img src="assets/text/logo.png" class="pub-logo-top" alt="Logo">
            <img src="assets/text/title-publishers-titles.png" class="pub-page-title-img" alt="Publishers & Titles">
        </div>

        <div class="pub-bottom-section">
            <img src="assets/text/results-text.png" class="pub-results-label-img" alt="RESULTS:">
            <div class="pub-results-container">
                <h1 class="pub-data-text"><?php echo $data; ?></h1>
            </div>
            <div class="pub-footer-nav">
                <a href="?view=view_db" class="pub-btn-back-wrap">
                    <img src="assets/text/btn-back-small.png" class="pub-btn-back-img" alt="BACK">
                </a>
            </div>
        </div>
    </div>

<?php elseif ($view === 'pub_emp_display'): ?>
    <style>
        .emp-res-body { display: flex; flex-direction: column; height: 100vh; background-color: #dbdbdb; margin:0; }
        .emp-res-top {
            background-color: #20252d; height: 45%; position: relative;
            display: flex; justify-content: center; align-items: center; padding-top: 130px;
        }
        .emp-res-logo { position: absolute; top: 30px; width: 220px; }
        .emp-res-title { width: 520px; max-width: 90%; }
        .emp-res-bottom { flex: 1; background-color: #dbdbdb; padding: 20px 50px 30px; display: flex; flex-direction: column; }
        .emp-res-label { width: 150px; margin-top: 20px; align-self: flex-start; }
        .emp-res-display { flex: 1; display: flex; justify-content: center; align-items: center; text-align: center; }
        .emp-res-text { font-family: 'Times New Roman', serif; font-size: 2.5rem; color: #3c4862; letter-spacing: 2px; font-weight: normal; }
        
        .emp-res-back-btn {
            background-color: #3c4862; padding: 12px 45px; border-radius: 50px;
            cursor: pointer; border: none; box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            transition: transform 0.2s ease, filter 0.2s ease;
            display: inline-flex; align-items: center; text-decoration: none;
        }
        .emp-res-back-btn:hover { transform: scale(1.05); filter: brightness(1.1); }
        .emp-res-back-img { width: 60px; display: block; }
    </style>

    <div class="emp-res-body">
        <div class="emp-res-top">
            <img src="assets/text/logo.png" class="emp-res-logo" alt="Logo">
            <img src="assets/text/title-publishers-employees.png" class="emp-res-title" alt="Publishers & Employees">
        </div>
        <div class="emp-res-bottom">
            <img src="assets/text/results-text.png" class="emp-res-label" alt="RESULTS:">
            <div class="emp-res-display">
                <h1 class="emp-res-text"><?php echo $data; ?></h1>
            </div>
            <div style="text-align: right;">
                <a href="?view=view_db" class="emp-res-back-btn">
                    <img src="assets/text/btn-back-small.png" class="emp-res-back-img" alt="BACK">
                </a>
            </div>
        </div>
    </div>
<?php elseif ($view === 'auth_titles_display'): ?>
    <style>
        .at-res-body { display: flex; flex-direction: column; height: 100vh; background-color: #dbdbdb; margin: 0; }
        .at-res-top {
            background-color: #20252d; height: 45%; position: relative;
            display: flex; justify-content: center; align-items: center; padding-top: 80px;
        }
        .at-res-logo { position: absolute; top: 30px; width: 220px; }
        .at-res-title-img { width: 520px; max-width: 85%; height: auto; }
        
        .at-res-bottom { flex: 1; background-color: #dbdbdb; padding: 20px 50px 30px; display: flex; flex-direction: column; }
        .at-res-label { width: 150px; margin-top: 20px; align-self: flex-start; }
        .at-res-display-box { flex: 1; display: flex; justify-content: center; align-items: center; text-align: center; }
        .at-res-data-text { font-family: 'Times New Roman', serif; font-size: 2.5rem; color: #3c4862; letter-spacing: 2px; font-weight: normal; }

        .at-res-back-btn {
            background-color: #3c4862; padding: 12px 45px; border-radius: 50px;
            cursor: pointer; border: none; box-shadow: 0 5px 12px rgba(0,0,0,0.2);
            transition: all 0.3s ease; display: inline-flex; align-items: center; text-decoration: none;
        }
        .at-res-back-btn:hover { transform: scale(1.05); filter: brightness(1.1); }
        .at-res-back-img { width: 60px; display: block; }
    </style>

    <div class="at-res-body">
        <div class="at-res-top">
            <img src="assets/text/logo.png" class="at-res-logo" alt="Logo">
            <img src="assets/text/title-authors-titles.png" class="at-res-title-img" alt="Authors & Titles">
        </div>

        <div class="at-res-bottom">
            <img src="assets/text/results-text.png" class="at-res-label" alt="RESULTS:">
            <div class="at-res-display-box">
                <h1 class="at-res-data-text"><?php echo $data; ?></h1>
            </div>
            <div style="text-align: right;">
                <a href="?view=edit_db" class="at-res-back-btn">
                    <img src="assets/text/btn-back-small.png" class="at-res-back-img" alt="BACK">
                </a>
            </div>
        </div>
    </div>
<?php elseif ($view === 'report'): ?>
    <style>
        .rep-body { display: flex; flex-direction: column; height: 100vh; background-color: #dbdbdb; margin: 0; font-family: 'Segoe UI', sans-serif; }
        .rep-top { background-color: #20252d; height: 45%; display: flex; flex-direction: column; justify-content: center; align-items: center; }
        .rep-header-group { display: flex; flex-direction: column; align-items: center; gap: 40px; }
        .rep-logo { width: 180px; height: auto; }
        .rep-title-img { width: 500px; max-width: 90%; height: auto; }

        .rep-bottom { flex: 1; padding: 50px 10% 20px; display: flex; flex-direction: column; align-items: center; position: relative; }
        .rep-search-container { width: 100%; max-width: 800px; position: relative; margin-bottom: 40px; }
        .rep-search-icon { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; opacity: 0.5; }
        .rep-search-input { width: 100%; padding: 15px 15px 15px 55px; border-radius: 50px; border: 1px solid #ccc; background-color: #f2f2f2; outline: none; font-size: 18px; letter-spacing: 2px; text-transform: uppercase; }

        .rep-placeholder { width: 100%; display: flex; flex-direction: column; align-items: center; }
        .rep-placeholder-img { width: 380px; max-width: 90%; opacity: 0.9; }

        .rep-footer { position: absolute; bottom: 30px; right: 5%; }
        .rep-btn-return { background-color: #3c4862; padding: 12px 30px; border-radius: 50px; display: flex; justify-content: center; align-items: center; box-shadow: 0 4px 12px rgba(0,0,0,0.3); transition: transform 0.2s ease; }
        .rep-btn-return:hover { transform: scale(1.05); }
        .rep-btn-img { width: 160px; height: auto; }

        @media (max-width: 768px) {
            .rep-title-img { width: 350px; }
            .rep-logo { width: 130px; }
            .rep-footer { position: static; margin-top: 30px; }
        }
    </style>

    <div class="rep-body">
        <div class="rep-top">
            <div class="rep-header-group">
                <img src="assets/text/logo.png" class="rep-logo" alt="Logo">
                <img src="assets/text/title-report.png" class="rep-title-img" alt="REPORT">
            </div>
        </div>

        <div class="rep-bottom">
            <div class="rep-search-container">
                <svg class="rep-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" class="rep-search-input" placeholder="SEARCH">
            </div>

            <div class="rep-placeholder">
                <img src="assets/text/placeholder-results.png" class="rep-placeholder-img" alt="Data Results">
            </div>

            <div class="rep-footer">
                <a href="?view=view_db" style="text-decoration:none;">
                    <div class="rep-btn-return">
                        <img src="assets/text/btn-return.png" class="rep-btn-img" alt="Return">
                    </div>
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>


</body>
</html>