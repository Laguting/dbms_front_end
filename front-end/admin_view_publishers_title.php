<?php
// ==========================================================
// 1. DATABASE CONNECTION
// ==========================================================
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pubs_test"; 
$port = 3307; 

$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$pub_search = "";
$title_search = "";
$has_results = false;
$no_results = false;
$results_list = [];

// ==========================================================
// 2. HANDLE ACTIONS
// ==========================================================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // UPDATE ACTION
    if (isset($_POST['action']) && $_POST['action'] == 'update') {
        $sql_pub = "UPDATE publishers SET pub_name=?, city=?, state=?, country=? WHERE pub_id=?";
        $stmt1 = $conn->prepare($sql_pub);
        $stmt1->bind_param("sssss", $_POST['pub_name'], $_POST['city'], $_POST['state'], $_POST['country'], $_POST['pub_id']);
        $p_upd = $stmt1->execute();
        $stmt1->close();

        $sql_title = "UPDATE titles SET title=?, type=?, price=?, advance=?, royalty=?, ytd_sales=?, notes=?, pubdate=? WHERE title_id=?";
        $stmt2 = $conn->prepare($sql_title);
        $stmt2->bind_param("ssddiiiss", $_POST['title'], $_POST['type'], $_POST['price'], $_POST['advance'], $_POST['royalty'], $_POST['ytd_sales'], $_POST['notes'], $_POST['pubdate'], $_POST['title_id']);
        $t_upd = $stmt2->execute();
        $stmt2->close();

        echo json_encode(["status" => ($p_upd && $t_upd) ? "success" : "error", "message" => "ENTRY SUCCESSFULLY EDITED."]);
        exit;
    }

    // DELETE ACTION 
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $stmt = $conn->prepare("DELETE FROM titles WHERE title_id = ?");
        $stmt->bind_param("s", $_POST['title_id']);
        $success = $stmt->execute();
        $stmt->close();
        
        echo json_encode(["status" => $success ? "success" : "error", "message" => "ENTRY SUCCESSFULLY\nDELETED."]);
        exit;
    }

    // SEARCH LOGIC 
    if (isset($_POST['pub_search']) || isset($_POST['title_search'])) {
        $pub_search = trim($_POST['pub_search'] ?? "");
        $title_search = trim($_POST['title_search'] ?? "");

        $conditions = [];
        $params = [];
        $types = "";

        $query = "SELECT t.*, p.pub_name, p.city, p.state, p.country 
                  FROM titles t 
                  LEFT JOIN publishers p ON t.pub_id = p.pub_id";

        if (!empty($pub_search)) {
            $conditions[] = "p.pub_name LIKE ?";
            $params[] = "%$pub_search%";
            $types .= "s";
        }
        if (!empty($title_search)) {
            $conditions[] = "t.title LIKE ?";
            $params[] = "%$title_search%";
            $types .= "s";
        }

        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(" AND ", $conditions);
            $stmt = $conn->prepare($query);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $res = $stmt->get_result();
            
            if ($res->num_rows > 0) {
                $has_results = true;
                while($row = $res->fetch_assoc()) { $results_list[] = $row; }
            } else {
                $no_results = true;
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<!-- Website design for Admin Publishers & Titles -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Publisher & Titles</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Montserrat:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root { 
            --dark-header: #20252d; 
            --body-bg: #dcdcdc; 
            --input-bg: #f9f9f9; 
            --text-slate: #667085; 
            --btn-grey: #8b8682; 
            --btn-blue: #3c4862; 
            --modal-bg: #3c4456; 
            --btn-red: #800000;
        }

        /* MAIN SELECTION */
        body { margin: 0; font-family: 'Montserrat', sans-serif; background-color: var(--body-bg); }
        
        .header { background-color: var(--dark-header); height: 250px; display: flex; flex-direction: column; justify-content: center; align-items: center; position: relative; }
        .logo-top { position: absolute; top: 30px; left: 40px; width: 150px; }
        .page-title { width: 500px; max-width: 80%; }
        
        .main-content { display: flex; flex-direction: column; align-items: center; padding: 40px 20px; }
        .search-box { width: 100%; max-width: 800px; }
        .label { 
            font-family: 'Cinzel', serif; 
            color: var(--text-slate); 
            font-size: 18px; 
            margin: 25px 0 10px 10px; 
            display: block; 
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: 400; 
        }

        .input-field { 
            width: 100%; 
            padding: 16px 20px 16px 50px; 
            border-radius: 50px; 
            border: 1px solid transparent; 
            background-color: white; 
            font-size: 16px; 
            font-family: 'Montserrat', sans-serif;
            font-weight: 300; 
            color: #333;
            margin-bottom: 15px; 
            outline: none; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.05); 
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23666' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z' /%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: 18px center; 
            background-size: 20px;
            transition: box-shadow 0.2s;
        }
        .input-field:focus { box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        ::placeholder { color: #9aa0a6; opacity: 1; font-weight: 300; }

        /* --- PRIMARY BUTTONS --- */
        .btn { 
            padding: 15px; 
            width: 310px; 
            border-radius: 50px; 
            border: none; 
            color: white; 
            font-weight: 700; 
            cursor: pointer; 
            font-family: 'Montserrat'; 
            margin-bottom: 15px; 
            margin-top: 10px; 
        }

        .modal-overlay { 
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
            display: none; justify-content: center; align-items: center; 
            backdrop-filter: blur(8px); background: rgba(0,0,0,0.5); 
            z-index: 1000; 
        }
        #statusModal, #deleteModal, #editModal { z-index: 2000 !important; }

        .results-container { display: flex; flex-direction: column; align-items: center; width: 550px; }
        .results-list { max-height: 450px; overflow-y: auto; padding: 10px; width: 100%; display: flex; flex-direction: column; align-items: center; }
        
        .result-btn { 
            background: #918a86; 
            color: white; 
            width: 100%; 
            padding: 18px; 
            border-radius: 50px; 
            border: none; 
            margin-bottom: 15px; 
            cursor: pointer; 
            text-align: center; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); 
        }
        .result-btn:hover { transform: scale(1.02); background-color: #a39c98; }
        .result-btn div { font-weight: 400; }

        .status-card { background: #1e2229; padding: 50px 30px; border-radius: 15px; text-align: center; color: white; position: relative; width: 450px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        
        .status-card h2 { 
            font-family: 'Cinzel'; 
            font-size: 24px; 
            margin-bottom: 30px; 
            line-height: 1.4; 
            text-transform: uppercase; 
            font-weight: 400; 
        }
        
        .done-btn { 
            background: #eeeeee; 
            color: black; 
            border: none; 
            padding: 12px 60px; 
            border-radius: 30px; 
            font-weight: 700; 
            cursor: pointer; 
            font-family: 'Montserrat'; 
            text-transform: uppercase; 
            font-size: 14px; 
        }

        .confirm-btn-group { display: flex; justify-content: center; gap: 20px; }
        
        .confirm-yes { 
            background: var(--btn-grey); 
            color: white; 
            border: none; 
            padding: 12px 40px; 
            border-radius: 30px; 
            font-family:'Montserrat'; 
            cursor: pointer; 
            text-transform: uppercase; 
            font-weight: 700; 
        }
        
        .confirm-cancel { 
            background: var(--btn-red); 
            color: white; 
            border: none; 
            padding: 12px 40px; 
            border-radius: 30px; 
            font-family:'Montserrat'; 
            cursor: pointer; 
            text-transform: uppercase; 
            font-weight: 700; 
        }

        .detail-card { background: var(--modal-bg); width: 1350px; max-width: 95vw; padding: 40px; border-radius: 20px; color: white; position: relative; }
        
        .section-title { font-family: 'Cinzel'; font-size: 18px; margin: 25px 0 10px; text-transform: uppercase; font-weight: 400; }
        
        .table-wrap { background: white; border-radius: 5px; overflow: hidden; margin-bottom: 25px; overflow-x: auto; }
        table { width: 100%; border-collapse: separate; border-spacing: 0; min-width: 800px; }
        th { background: #f8f9fa; color: #555; font-size: 11px; padding: 12px; border-bottom: 1px solid #ddd; text-transform: uppercase; font-weight: 500; }
        td { border: 1px solid #ddd; padding: 6px; background: #fdfdfd; } 

        .grid-input { 
            width: 100%; box-sizing: border-box; border: 1px solid transparent; 
            padding: 8px 10px; text-align: center; font-family: inherit; font-size: 13px; 
            color: #333; background: transparent; outline: none; border-radius: 4px; transition: all 0.2s ease;
        }
        .grid-input.edit-active { background-color: #ffffff; border: 1px solid #ccc; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        
        /* DROPDOWN FEATURE */
        select.grid-input { text-align: left; height: 32px; }

        .close-circle { width: 35px; height: 35px; border: 2px solid white; border-radius: 50%; color: white; background: transparent; cursor: pointer; font-weight: bold; font-size: 16px; display: flex; align-items: center; justify-content: center; margin-top: 10px; transition: 0.2s; }
        .close-circle:hover { background: rgba(255,255,255,0.2); }
        .close-corner { position: absolute; top: 15px; right: 15px; }
        .hidden { display: none !important; }
    </style>
</head>
<body>

<div class="header">
    <img src="assets/text/logo.png" class="logo-top" alt="Logo">
    <img src="assets/text/title-publishers-titles.png" class="page-title" alt="Publishers & Titles">
</div>

<div class="main-content">
    <form class="search-box" method="POST">
        <label class="label">Publisher</label>
        <input type="text" name="pub_search" class="input-field" placeholder="Search by Publisher Name" value="<?= htmlspecialchars($pub_search) ?>">
        <label class="label">Title</label>
        <input type="text" name="title_search" class="input-field" placeholder="Search by Book Title" value="<?= htmlspecialchars($title_search) ?>">
        <div style="display:flex; flex-direction:column; align-items:center; margin-top:30px;">
            <button type="submit" class="btn" style="background: var(--btn-grey);">Search</button>
            <a href="admin_view_database.php" class="btn" style="background: var(--btn-blue); text-decoration:none; text-align:center; display:flex; align-items:center; justify-content:center;">Return to Main Menu</a>
        </div>
    </form>
</div>

<?php if($has_results): ?>
<div class="modal-overlay" id="resultsModal" style="display:flex;">
    <div class="results-container">
        <h2 style="color:white; font-family:'Cinzel'; font-size:38px; margin-bottom:25px; font-weight: 400;">RESULTS</h2>
        <div class="results-list">
            <?php foreach($results_list as $row): 
                $jsonData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
            ?>
            <button class="result-btn" onclick='showDetails(<?= $jsonData ?>)'>
                <div style="font-family:'Cinzel'; font-size:17px; text-transform:uppercase; margin-bottom: 5px;">
                    <?= htmlspecialchars($row['pub_name'] ?? 'Unknown Publisher') ?>
                </div>
                <div style="font-size:12px; opacity:0.8; text-transform:uppercase;">
                    TITLE: <?= htmlspecialchars($row['title']) ?>
                </div>
            </button>
            <?php endforeach; ?>
        </div>
        <button class="close-circle" onclick="window.location.href=window.location.pathname">✕</button>
    </div>
</div>
<?php endif; ?>

<div class="modal-overlay" id="statusModal">
    <div class="status-card">
        <button class="close-circle close-corner" onclick="window.location.href=window.location.pathname">✕</button>
        <h2 id="statusText">NO RECORDS FOUND<br>MATCHING YOUR SEARCH.</h2>
        <button class="done-btn" id="statusBtn" onclick="window.location.href=window.location.pathname">OK</button>
    </div>
</div>

<div class="modal-overlay" id="deleteModal">
    <div class="status-card">
        <button class="close-circle close-corner" onclick="closeDeleteModal()">✕</button>
        <h2>ARE YOU SURE YOU WANT<br>TO DELETE THIS?</h2>
        <div class="confirm-btn-group">
            <button class="confirm-yes" onclick="confirmDelete()">YES</button>
            <button class="confirm-cancel" onclick="closeDeleteModal()">CANCEL</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="detailModal">
    <div class="detail-card">
        <div class="close-corner">
            <button class="close-circle" onclick="goBackToResults()">✕</button>
        </div>
        
        <div class="section-title">PUBLISHER INFORMATION</div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>PUB_ID</th><th>Publisher Name</th><th>City</th><th>State</th><th>Country</th></tr></thead>
                <tbody><tr>
                    <td><input id="p_id" class="grid-input" readonly style="background:#f0f0f0;"></td>
                    <td><input id="p_name" class="grid-input" readonly></td>
                    <td><input id="p_city" class="grid-input" readonly></td>
                    <td><input id="p_state" class="grid-input" readonly></td>
                    <td><input id="p_country" class="grid-input" readonly></td>
                </tr></tbody>
            </table>
        </div>

        <div class="section-title">TITLE INFORMATION</div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Title ID</th><th>Title</th><th>Type</th><th>Price</th><th>Advance</th><th>Royalty</th><th>YTD Sales</th><th>Pub Date</th></tr></thead>
                <tbody><tr>
                    <td><input id="t_id" class="grid-input" readonly style="background:#f0f0f0;"></td>
                    <td><input id="t_title" class="grid-input" readonly></td>
                    <td><input id="t_type" class="grid-input" readonly></td>
                    <td><input id="t_price" class="grid-input" readonly></td>
                    <td><input id="t_advance" class="grid-input" readonly></td>
                    <td><input id="t_royalty" class="grid-input" readonly></td>
                    <td><input id="t_ytd" class="grid-input" readonly></td>
                    <td><input id="t_date" class="grid-input" readonly></td>
                </tr></tbody>
            </table>
        </div>

        <div style="display:flex; justify-content:center; gap:20px; margin-top:30px;">
            <button class="btn" style="background:#8b8682; width:180px;" onclick="openEditModal()">EDIT</button>
            <button class="btn" style="background:#800000; width:180px;" onclick="deleteRecord()">DELETE</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="editModal">
    <div class="detail-card">
        <div class="close-corner">
            <button class="close-circle" onclick="closeEditModal()">✕</button>
        </div>
        
        <div class="section-title">PUBLISHER INFORMATION</div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>PUB_ID</th><th>Publisher Name</th><th>City</th><th>State</th><th>Country</th></tr></thead>
                <tbody><tr>
                    <td><input id="edit_p_id" class="grid-input" readonly style="background:#f0f0f0;"></td>
                    <td><input id="edit_p_name" class="grid-input edit-active"></td>
                    <td><input id="edit_p_city" class="grid-input edit-active"></td>
                    <td><input id="edit_p_state" class="grid-input edit-active"></td>
                    <td><input id="edit_p_country" class="grid-input edit-active"></td>
                </tr></tbody>
            </table>
        </div>

        <div class="section-title">TITLE INFORMATION</div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Title ID</th><th>Title</th><th>Type</th><th>Price</th><th>Advance</th><th>Royalty</th><th>YTD Sales</th><th>Pub Date</th></tr></thead>
                <tbody><tr>
                    <td><input id="edit_t_id" class="grid-input" readonly style="background:#f0f0f0;"></td>
                    <td><input id="edit_t_title" class="grid-input edit-active"></td>
                    
                    <td>
                        <select id="edit_t_type" class="grid-input edit-active">
                            <option value="" disabled selected>Select Type</option>
                            <optgroup label="1. General Non-Fiction">
                                <option value="Arts & Recreation">Arts & Recreation</option>
                                <option value="Biographies & Memoirs">Biographies & Memoirs</option>
                                <option value="Business & Economics">Business & Economics</option>
                                <option value="History & Geography">History & Geography</option>
                                <option value="Philosophy & Psychology">Philosophy & Psychology</option>
                                <option value="Religion & Spirituality">Religion & Spirituality</option>
                                <option value="Science & Nature">Science & Nature</option>
                                <option value="Social Sciences">Social Sciences</option>
                                <option value="Technology & Applied Science">Technology & Applied Science</option>
                                <option value="True Crime">True Crime</option>
                            </optgroup>
                            <optgroup label="2. Fiction">
                                <option value="Action & Adventure">Action & Adventure</option>
                                <option value="Classics">Classics</option>
                                <option value="Contemporary Fiction">Contemporary Fiction</option>
                                <option value="Fantasy">Fantasy</option>
                                <option value="Historical Fiction">Historical Fiction</option>
                                <option value="Horror">Horror</option>
                                <option value="Literary Fiction">Literary Fiction</option>
                                <option value="Mystery & Thriller">Mystery & Thriller</option>
                                <option value="Romance">Romance</option>
                                <option value="Science Fiction">Science Fiction</option>
                            </optgroup>
                            <optgroup label="3. Visual & Alternative Formats">
                                <option value="Graphic Novels">Graphic Novels</option>
                                <option value="Manga">Manga</option>
                                <option value="Comic Books">Comic Books</option>
                                <option value="Large Print">Large Print</option>
                                <option value="Audiobooks">Audiobooks</option>
                            </optgroup>
                            <optgroup label="4. Specialized Collections">
                                <option value="Reference">Reference</option>
                                <option value="Periodicals">Periodicals</option>
                                <option value="Government Documents">Government Documents</option>
                                <option value="Special Collections/Archives">Special Collections/Archives</option>
                            </optgroup>
                            <optgroup label="5. Age-Specific Categories">
                                <option value="Children’s">Children’s</option>
                                <option value="Young Adult (YA)">Young Adult (YA)</option>
                                <option value="Adult">Adult</option>
                            </optgroup>
                        </select>
                    </td>

                    <td><input id="edit_t_price" class="grid-input edit-active"></td>
                    <td><input id="edit_t_advance" class="grid-input edit-active"></td>
                    <td><input id="edit_t_royalty" class="grid-input edit-active"></td>
                    <td><input id="edit_t_ytd" class="grid-input edit-active"></td>
                    <td><input id="edit_t_date" class="grid-input edit-active"></td>
                </tr></tbody>
            </table>
        </div>

        <div style="display:flex; justify-content:center; gap:20px; margin-top:30px;">
            <button class="btn" style="background:#8b8682; width:180px;" onclick="saveChanges()">SAVE</button>
            <button class="btn" style="background:#800000; width:180px;" onclick="closeEditModal()">CANCEL</button>
        </div>
    </div>
</div>

<script>
    // STATUS/MESSAGE MODAL
    function showStatus(message, btnText = 'DONE') {
        document.getElementById('detailModal').style.display = 'none';
        document.getElementById('editModal').style.display = 'none';
        document.getElementById('deleteModal').style.display = 'none';
        
        if (document.getElementById('resultsModal')) {
             document.getElementById('resultsModal').style.display = 'none';
        }
        document.getElementById('statusText').innerText = message;
        document.getElementById('statusBtn').innerText = btnText;
        document.getElementById('statusModal').style.display = 'flex';
    }

    //  VIEW DETAILS
    function showDetails(data) {
        document.getElementById('resultsModal').style.display = 'none';
        document.getElementById('detailModal').style.display = 'flex';
        document.getElementById('p_id').value = data.pub_id || '';
        document.getElementById('p_name').value = data.pub_name || '';
        document.getElementById('p_city').value = data.city || '';
        document.getElementById('p_state').value = data.state || '';
        document.getElementById('p_country').value = data.country || '';
        document.getElementById('t_id').value = data.title_id || '';
        document.getElementById('t_title').value = data.title || '';
        document.getElementById('t_type').value = data.type || ''; 
        document.getElementById('t_price').value = data.price || '0.00';
        document.getElementById('t_advance').value = data.advance || '0.00';
        document.getElementById('t_royalty').value = data.royalty || '0';
        document.getElementById('t_ytd').value = data.ytd_sales || '0';
        document.getElementById('t_date').value = data.pubdate || '';
    }

    function goBackToResults() {
        document.getElementById('detailModal').style.display = 'none';
        if (document.getElementById('resultsModal')) {
            document.getElementById('resultsModal').style.display = 'flex';
        }
    }

    // OPEN EDIT MODAL 
    function openEditModal() {
        document.getElementById('edit_p_id').value = document.getElementById('p_id').value;
        document.getElementById('edit_p_name').value = document.getElementById('p_name').value;
        document.getElementById('edit_p_city').value = document.getElementById('p_city').value;
        document.getElementById('edit_p_state').value = document.getElementById('p_state').value;
        document.getElementById('edit_p_country').value = document.getElementById('p_country').value;
        document.getElementById('edit_t_id').value = document.getElementById('t_id').value;
        document.getElementById('edit_t_title').value = document.getElementById('t_title').value;
        document.getElementById('edit_t_type').value = document.getElementById('t_type').value;
        document.getElementById('edit_t_price').value = document.getElementById('t_price').value;
        document.getElementById('edit_t_advance').value = document.getElementById('t_advance').value;
        document.getElementById('edit_t_royalty').value = document.getElementById('t_royalty').value;
        document.getElementById('edit_t_ytd').value = document.getElementById('t_ytd').value;
        document.getElementById('edit_t_date').value = document.getElementById('t_date').value;
        document.getElementById('detailModal').style.display = 'none';
        document.getElementById('editModal').style.display = 'flex';
    }

    // CLOSE EDIT MODAL 
    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
        document.getElementById('detailModal').style.display = 'flex';
    }

    // SAVE CHANGES 
    function saveChanges() {
        const formData = new FormData();
        formData.append('action', 'update');
        formData.append('pub_id', document.getElementById('edit_p_id').value);
        formData.append('pub_name', document.getElementById('edit_p_name').value);
        formData.append('city', document.getElementById('edit_p_city').value);
        formData.append('state', document.getElementById('edit_p_state').value);
        formData.append('country', document.getElementById('edit_p_country').value);
        formData.append('title_id', document.getElementById('edit_t_id').value);
        formData.append('title', document.getElementById('edit_t_title').value);
        formData.append('type', document.getElementById('edit_t_type').value);
        formData.append('price', document.getElementById('edit_t_price').value);
        formData.append('advance', document.getElementById('edit_t_advance').value);
        formData.append('royalty', document.getElementById('edit_t_royalty').value);
        formData.append('ytd_sales', document.getElementById('edit_t_ytd').value);
        formData.append('notes', '');
        formData.append('pubdate', document.getElementById('edit_t_date').value);

        fetch(window.location.href, { method: 'POST', body: formData })
        .then(res => res.json()).then(data => { 
            if(data.status === 'success') showStatus(data.message); 
            else alert("Error saving data");
        });
    }

    // DELETE LOGIC
    function deleteRecord() {
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    function confirmDelete() {
        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('title_id', document.getElementById('t_id').value);

        fetch(window.location.href, { method: 'POST', body: formData })
        .then(res => res.json()).then(data => { 
            if(data.status === 'success') {
                showStatus(data.message, 'DONE');
            } else {
                alert("Error deleting data");
            }
        });
    }
</script>

<?php if($no_results): ?>
<script>
    document.getElementById('statusModal').style.display = 'flex';
    document.getElementById('statusBtn').innerText = 'OK';
</script>
<?php endif; ?>
</body>
</html>

