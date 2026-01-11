<?php
// ==========================================================
// DATABASE CONNECTION
// ==========================================================
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ink_and_solace";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ==========================================================
// 1. HANDLE AJAX REQUESTS (UPDATE & DELETE)
// ==========================================================
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    
    // UPDATE LOGIC 
    if ($_POST['action'] == 'update') {
        $id = $_POST['id'];
        $publisher = $_POST['publisher']; 
        $author = $_POST['author'];
        $count = $_POST['count'];
        $books = $_POST['books'];

        $stmt = $conn->prepare("UPDATE book_reports SET publisher=?, author=?, count=?, books=? WHERE id=?");
        $stmt->bind_param("ssisi", $publisher, $author, $count, $books, $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => $conn->error]);
        }
        $stmt->close();
        exit; 
    }

    // DELETE LOGIC 
    if ($_POST['action'] == 'delete') {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM book_reports WHERE id=?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => $conn->error]);
        }
        $stmt->close();
        exit;
    }
}

// ==========================================================
// 2. SEARCH & GROUPING LOGIC
// ==========================================================
$search_query = "";
$grouped_results = []; 
$has_searched = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['action'])) {
    $search_query = trim($_POST['search_query'] ?? "");
    $has_searched = true;

    $sql = "SELECT * FROM book_reports";
    $params = [];
    $types = "";

    if (!empty($search_query)) {
        $sql .= " WHERE publisher LIKE ? OR author LIKE ?";
        $search_term = "%" . $search_query . "%";
        $params[] = $search_term;
        $params[] = $search_term;
        $types = "ss";
    }

    $sql .= " ORDER BY publisher ASC";

    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $pubName = $row['publisher'];
            if (!isset($grouped_results[$pubName])) {
                $grouped_results[$pubName] = [];
            }
            $grouped_results[$pubName][] = $row;
        }
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<!-- Website design for Admin Report -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books | Ink & Solace</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --light-bg: #dbdbdb; 
            --dark-bg: #20252d;
            --input-bg: #f2f2f2;
            --btn-return: #3c4862;
            --pill-color: #918a86; 
            --pill-hover: #a39c98;
            --btn-edit: #888888; 
            --btn-delete: #8b0000;
            --modal-bg: #2e343e;
        }
        * { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; min-height: 100vh; font-family: 'Montserrat', sans-serif; background-color: var(--light-bg); }
        body { display: flex; flex-direction: column; }

        /* TOP SECTION */
        .top-section { background-color: var(--dark-bg); height: 45vh; min-height: 300px; display: flex; flex-direction: column; justify-content: center; align-items: center; }
        .header-content-group { display: flex; flex-direction: column; align-items: center; gap: 15px; }
        .logo-top { width: 180px; height: auto; }
        .page-title-text { font-family: 'Cinzel', serif; font-size: 80px; color: white; text-transform: uppercase; font-weight: 400; letter-spacing: 5px; margin: 0; line-height: 1; margin-bottom: 10px; }
        .header-subtitle { font-family: 'Montserrat', sans-serif; color: white; text-transform: uppercase; font-size: 14px; letter-spacing: 1px; margin: 0; font-weight: 300; opacity: 0.8; }

        /* BOTTOM SECTION */
        .bottom-section { flex: 1; padding: 50px 10% 80px; display: flex; flex-direction: column; align-items: center; position: relative; }
        .search-form { width: 100%; display: flex; justify-content: center; align-items: center; gap: 15px; margin-bottom: 40px; }
        .search-container { width: 100%; max-width: 600px; position: relative; }
        .search-input { width: 100%; padding: 15px 25px; border-radius: 50px; border: 1px solid #ccc; background-color: var(--input-bg); outline: none; font-family: 'Montserrat', sans-serif; font-size: 18px; letter-spacing: 2px; text-transform: uppercase; color: #333; }
        .btn-search-submit { background-color: var(--btn-return); color: white; border: none; padding: 15px 30px; border-radius: 50px; font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 14px; cursor: pointer; letter-spacing: 1px; text-transform: uppercase; box-shadow: 0 4px 8px rgba(0,0,0,0.2); transition: transform 0.2s, background-color 0.2s; height: 54px; }
        .btn-search-submit:hover { transform: translateY(-2px); opacity: 0.9; }

        /* RESULTS LIST */
        .results-list { width: 100%; display: flex; flex-direction: column; align-items: center; gap: 20px; width: 100%; max-width: 700px; }
        .report-pill { background-color: var(--pill-color); color: white; width: 100%; padding: 25px 40px; border-radius: 60px; display: flex; flex-direction: row; align-items: center; justify-content: space-between; text-align: left; box-shadow: 0 5px 15px rgba(0,0,0,0.2); transition: all 0.2s ease; cursor: pointer; border: none; }
        .report-pill:hover { transform: translateY(-3px); background-color: var(--pill-hover); box-shadow: 0 8px 20px rgba(0,0,0,0.3); }
        
        .pill-left { display: flex; flex-direction: column; }
        .rep-title { font-family: 'Cinzel', serif; font-size: 24px; text-transform: uppercase; margin-bottom: 5px; line-height: 1.2; font-weight: 700; }
        .rep-details { font-family: 'Montserrat', sans-serif; font-size: 14px; font-weight: 400; opacity: 0.9; letter-spacing: 1px; }
        
        .pill-arrow { font-size: 24px; opacity: 0.7; }

        .no-results { font-family: 'Cinzel', serif; font-size: 20px; color: #555; margin-top: 20px; }

        /* MODALS */
        .modal-overlay, .confirm-overlay, .success-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.85); backdrop-filter: blur(8px); display: flex; justify-content: center; align-items: center; z-index: 2000; animation: fadeIn 0.3s ease-out; display: none; }
        
        .detail-card { background-color: var(--modal-bg); color: white; width: 800px; max-width: 90vw; padding: 50px; border-radius: 15px; position: relative; text-align: center; box-shadow: 0 25px 60px rgba(0,0,0,0.7); display: flex; flex-direction: column; align-items: center; max-height: 90vh; overflow-y: auto; border: 1px solid rgba(255,255,255,0.1); }
        
        .close-card-x { position: absolute; top: 20px; right: 20px; width: 40px; height: 40px; background-color: transparent; color: white; border-radius: 50%; border: 2px solid white; font-size: 20px; font-weight: bold; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: 0.2s; }
        .close-card-x:hover { background-color: white; color: var(--modal-bg); transform: rotate(90deg); }
        
        .dt-header { font-family: 'Cinzel', serif; font-size: 36px; text-transform: uppercase; margin-bottom: 10px; width: 100%; letter-spacing: 2px; }
        .dt-subheader { font-family: 'Montserrat', sans-serif; font-size: 16px; opacity: 0.8; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.2); width: 100%; padding-bottom: 15px; font-weight: 600; color: #d4d4d4; }
        .entries-container { width: 100%; display: flex; flex-direction: column; gap: 15px; margin-bottom: 20px; text-align: left; }
        
        .entry-item-styled { 
            background-color: rgba(255,255,255,0.05); 
            padding: 20px; 
            border-radius: 8px; 
            display: flex; 
            align-items: flex-start;
            cursor: pointer; 
            transition: all 0.2s; 
            border-bottom: 2px solid rgba(255,255,255,0.05);
        }
        
        .entry-item-styled:hover { 
            background-color: rgba(255,255,255,0.1); 
            transform: translateX(5px);
        }

        .entry-number {
            font-family: 'Cinzel', serif;
            font-size: 24px;
            font-weight: 700;
            margin-right: 20px;
            color: var(--pill-color);
            min-width: 30px;
        }

        .entry-text-group { display: flex; flex-direction: column; width: 100%; }

        .entry-author-name { 
            font-family: 'Montserrat', sans-serif; 
            font-weight: 700; 
            font-size: 18px; 
            color: #fff; 
            margin-bottom: 8px; 
            text-transform: uppercase;
        }

        .entry-book-list { 
            font-size: 14px; 
            opacity: 0.7; 
            line-height: 1.5; 
            font-style: italic;
            color: #e0e0e0;
        }

        /* EDIT FORM AREA */
        #edit-form-area { width: 100%; display: none; background-color: rgba(0,0,0,0.2); padding: 30px; border-radius: 15px; margin-top: 10px; border: 1px solid rgba(255,255,255,0.05); }

        .edit-input-field { width: 100%; padding: 15px; margin-bottom: 20px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); font-family: 'Montserrat', sans-serif; font-size: 16px; background-color: rgba(0,0,0,0.3); color: white; transition: 0.3s; }
        .edit-input-field:focus { outline: none; border-color: var(--pill-color); background-color: rgba(0,0,0,0.5); }
        .edit-input-field::placeholder { color: rgba(255,255,255,0.3); }
        textarea.edit-input-field { min-height: 150px; resize: vertical; line-height: 1.6; }
        
        .warning-text { color: #ff6b6b; background-color: rgba(80, 20, 20, 0.4); padding: 15px; border-radius: 5px; font-family: 'Montserrat', sans-serif; font-size: 13px; margin-bottom: 25px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; width: 100%; border: 1px solid #8b0000; }
        
        .modal-actions { display: flex; justify-content: center; gap: 20px; width: 100%; margin-top: 10px; }
        .btn-action { border: none; padding: 15px 0; width: 160px; border-radius: 50px; font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 14px; cursor: pointer; text-transform: uppercase; transition: transform 0.2s, opacity 0.2s; color: white; box-shadow: 0 4px 8px rgba(0,0,0,0.2); }
        .btn-action:hover { transform: translateY(-2px); opacity: 0.9; }
        .btn-save { background-color: var(--pill-color); }
        .btn-delete { background-color: var(--btn-delete); }
        .btn-back-list { background-color: transparent; border: 1px solid rgba(255,255,255,0.3); width: auto; padding: 10px 20px; font-size: 12px; margin-bottom: 20px; align-self: flex-start; color: rgba(255,255,255,0.7); }
        .btn-back-list:hover { background-color: white; color: black; border-color: white; }

        /* CONFIRM & SUCCESS */
        .confirm-card, .success-card { background-color: var(--modal-bg); color: white; width: 500px; padding: 50px; border-radius: 20px; text-align: center; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 20px 60px rgba(0,0,0,0.6); display: flex; flex-direction: column; align-items: center; }
        .confirm-msg, .success-msg { font-family: 'Cinzel', serif; font-size: 24px; margin-bottom: 40px; font-weight: 400; line-height: 1.4; }
        .confirm-actions { display: flex; gap: 20px; }
        .btn-confirm-yes, .btn-confirm-no, .btn-done { padding: 12px 40px; border-radius: 30px; border: none; font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 14px; cursor: pointer; text-transform: uppercase; }
        .btn-confirm-yes { background-color: var(--pill-color); color: white; }
        .btn-confirm-no { background-color: var(--btn-delete); color: white; }
        .btn-done { background-color: white; color: #20252d; padding: 12px 60px; }
        .btn-done:hover { background-color: #ddd; }

        .return-footer { margin-top: 50px; display: flex; justify-content: center; }
        .btn-return-wrap { background-color: var(--btn-return); padding: 12px 30px; border-radius: 50px; display: flex; justify-content: center; align-items: center; box-shadow: 0 4px 12px rgba(0,0,0,0.3); transition: transform 0.2s ease; }
        .btn-return-wrap:hover { transform: translateY(-2px); }
        .btn-return-img { width: 160px; height: auto; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @media (max-width: 768px) { .page-title-text { font-size: 50px; } .logo-top { width: 130px; } .search-form { flex-direction: column; gap: 10px; } .search-container { width: 100%; } .btn-search-submit { width: 100%; } }
    </style>
</head>

<body>

    <div class="top-section">
        <div class="header-content-group">
            <img src="assets/text/logo.png" class="logo-top" alt="Logo">
            <h1 class="page-title-text">REPORT</h1>
            <p class="header-subtitle">add correct information to avoid data mismatch.</p>
        </div>
    </div>

    <div class="bottom-section">
        <form method="POST" class="search-form">
            <div class="search-container">
                <input type="text" name="search_query" class="search-input" placeholder="SEARCH ENTRIES" value="<?php echo htmlspecialchars($search_query); ?>">
            </div>
            <button type="submit" class="btn-search-submit">SEARCH</button>
        </form>

        <?php if ($has_searched): ?>
            <div class="results-list">
                <?php if (count($grouped_results) > 0): ?>
                    <?php foreach($grouped_results as $publisherName => $entries): ?>
                        
                        <button class="report-pill" onclick='openGroupModal(
                            <?php echo json_encode($publisherName); ?>,
                            <?php echo htmlspecialchars(json_encode($entries), ENT_QUOTES, 'UTF-8'); ?>
                        )'>
                            <div class="pill-left">
                                <span class="rep-title"><?php echo htmlspecialchars($publisherName); ?></span>
                                <span class="rep-details"><?php echo count($entries); ?> REGISTERED AUTHORS</span>
                            </div>
                            <div class="pill-arrow">➜</div>
                        </button>

                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-results">NO ENTRIES FOUND</div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="return-footer">
            <a href="admin_view_database.php" style="text-decoration:none;">
                <div class="btn-return-wrap">
                    <img src="assets/text/btn-return.png" class="btn-return-img" alt="Return to Main Menu">
                </div>
            </a>
        </div>
    </div>

    <div class="modal-overlay" id="detailModal">
        <div class="detail-card">
            <button class="close-card-x" onclick="closeReportDetail()">✕</button>
            
            <div class="dt-header" id="modal-pub-title">Publisher Name</div>
            <div class="dt-subheader" id="modal-pub-stats">Total Books: 0</div>

            <div id="list-view-area" style="width: 100%;">
                <div class="entries-container" id="entries-list">
                    </div>
            </div>

            <div id="edit-form-area">
                <button class="btn-action btn-back-list" onclick="showListBack()">← BACK TO ROSTER</button>
                
                <div class="warning-text">
                    NOTE: Please put the correct information to avoid data mismatch.
                </div>

                <input type="hidden" id="edit-id"> 
                
                <label style="display:block; text-align:left; font-size:12px; margin-bottom:5px; opacity:0.7;">PUBLISHER NAME</label>
                <input type="text" id="edit-publisher" class="edit-input-field" placeholder="Edit Publisher Name">
                
                <label style="display:block; text-align:left; font-size:12px; margin-bottom:5px; opacity:0.7;">AUTHOR NAME</label>
                <input type="text" id="edit-author" class="edit-input-field" placeholder="Edit Author Name">
                
                <label style="display:block; text-align:left; font-size:12px; margin-bottom:5px; opacity:0.7;">TOTAL BOOKS</label>
                <input type="number" id="edit-count" class="edit-input-field" placeholder="Edit Total Count">
                
                <label style="display:block; text-align:left; font-size:12px; margin-bottom:5px; opacity:0.7;">LIST OF BOOKS</label>
                <textarea id="edit-books" class="edit-input-field" placeholder="Edit List of Books"></textarea>

                <div class="modal-actions">
                    <button id="btn-save" class="btn-action btn-save" onclick="handleSave()">UPDATE</button>
                    <button id="btn-delete" class="btn-action btn-delete" onclick="handleDelete()">DELETE</button>
                </div>
            </div>

        </div>
    </div>

    <div class="confirm-overlay" id="deleteConfirmModal">
        <div class="confirm-card">
            <div class="confirm-msg">Are you sure you want to delete this author record?</div>
            <div class="confirm-actions">
                <button class="btn-confirm-yes" onclick="confirmDelete()">YES, DELETE</button>
                <button class="btn-confirm-no" onclick="closeDeleteConfirm()">CANCEL</button>
            </div>
        </div>
    </div>

    <div class="success-overlay" id="successModal">
        <div class="success-card">
            <div class="success-msg" id="success-msg-text">Entry successfully edited.</div>
            <button class="btn-done" onclick="closeSuccessModal()">DONE</button>
        </div>
    </div>

    <script>
        let currentEntryId = null;

        // 1. OPEN MODAL WITH NUMBERED LIST
        function openGroupModal(publisherName, entriesArray) {
            document.getElementById('modal-pub-title').innerText = publisherName;
            let totalBooks = 0;
            entriesArray.forEach(entry => {
                totalBooks += parseInt(entry.count || 0);
            });
            document.getElementById('modal-pub-stats').innerText = "Total Number of Books under this Publisher: " + totalBooks;
            const listContainer = document.getElementById('entries-list');
            listContainer.innerHTML = '';

            entriesArray.forEach((entry, index) => {
                const div = document.createElement('div');
                div.className = 'entry-item-styled';
                div.innerHTML = `
                    <div class="entry-number">${index + 1}.</div>
                    <div class="entry-text-group">
                        <div class="entry-author-name">${entry.author}</div>
                        <div class="entry-book-list">${entry.books}</div>
                    </div>
                `;
                
                div.onclick = function() {
                    openEditForm(entry);
                };
                listContainer.appendChild(div);
            });
            document.getElementById('list-view-area').style.display = 'block';
            document.getElementById('edit-form-area').style.display = 'none';
            document.getElementById('detailModal').style.display = 'flex';
        }

        // 2. SHOW EDIT FORM FOR SPECIFIC ENTRY
        function openEditForm(entry) {
            currentEntryId = entry.id; // Store ID for AJAX
            document.getElementById('edit-id').value = entry.id;
            document.getElementById('edit-publisher').value = entry.publisher;
            document.getElementById('edit-author').value = entry.author;
            document.getElementById('edit-count').value = entry.count;
            document.getElementById('edit-books').value = entry.books;
            document.getElementById('list-view-area').style.display = 'none';
            document.getElementById('edit-form-area').style.display = 'block';
        }

        // 3. BACK BUTTON LOGIC
        function showListBack() {
            document.getElementById('list-view-area').style.display = 'block';
            document.getElementById('edit-form-area').style.display = 'none';
        }

        function closeReportDetail() {
            document.getElementById('detailModal').style.display = 'none';
        }

        // ==========================
        // AJAX SAVE FUNCTION
        // ==========================
        function handleSave() {
            const formData = new FormData();
            formData.append('action', 'update');
            formData.append('id', currentEntryId);
            formData.append('publisher', document.getElementById('edit-publisher').value);
            formData.append('author', document.getElementById('edit-author').value);
            formData.append('count', document.getElementById('edit-count').value);
            formData.append('books', document.getElementById('edit-books').value);

            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('detailModal').style.display = 'none';
                    document.getElementById('success-msg-text').innerText = "Record successfully updated.";
                    document.getElementById('successModal').style.display = 'flex';
                } else {
                    alert('Error saving data: ' + data.message);
                }
            })
            .catch(error => { console.error('Error:', error); });
        }

        // ==========================
        // AJAX DELETE FUNCTION
        // ==========================
        function handleDelete() {
            if(currentEntryId) {
                document.getElementById('deleteConfirmModal').style.display = 'flex';
            }
        }

        function closeDeleteConfirm() {
            document.getElementById('deleteConfirmModal').style.display = 'none';
        }

        function confirmDelete() {
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', currentEntryId);

            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('deleteConfirmModal').style.display = 'none';
                    document.getElementById('detailModal').style.display = 'none';
                    document.getElementById('success-msg-text').innerText = "Record deleted.";
                    document.getElementById('successModal').style.display = 'flex';
                } else {
                    alert('Error deleting data: ' + data.message);
                }
            })
            .catch(error => { console.error('Error:', error); });
        }

        function closeSuccessModal() {
            window.location.reload(); 
        }
    </script>

</body>
</html>

