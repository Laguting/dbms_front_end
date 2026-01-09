<?php
// ==========================================================
// 1. DATABASE CONNECTION
// ==========================================================
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ink_and_solace"; 
$port = 3307; 

// Check if MySQLi extension is loaded to prevent fatal errors
if (!extension_loaded('mysqli')) {
    die("The MySQLi extension is not enabled. Please check your php.ini and restart Apache.");
}

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
}

$show_modal = false;
$success_message = "";

// ==========================================================
// 2. HANDLE STEP 2: ADD EMPLOYEE (FORM POST)
// ==========================================================
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add_employee') {
    
    // Generate Emp ID (E + 8 random digits)
    $gen_emp_id = "E" . rand(10000000, 99999999);
    
    // Prepare statement with error handling to prevent "bind_param on bool" error
    $sql = "INSERT INTO employees (emp_id, fname, minit, lname, job_id, job_lvl, pub_id, hire_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        // This will trigger if your table name or column names are wrong
        die("SQL Error: " . $conn->error . " | Please check if table 'employees' and its columns match exactly.");
    }
    
    $job_id = 1; // Default job_id
    $job_lvl = $_POST['job_lvl'];   
    $hire_date = $_POST['hire_date']; 

    $stmt->bind_param("ssssiiss", 
        $gen_emp_id, 
        $_POST['fname'], 
        $_POST['minit'], 
        $_POST['lname'], 
        $job_id, 
        $job_lvl, 
        $_POST['pub_id'], 
        $hire_date
    );

    if ($stmt->execute()) {
        $show_modal = true;
        $success_message = "Employee Successfully Added to Publisher!";
    } else {
        echo "<script>alert('Execution Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

// ==========================================================
// 3. AJAX HELPER: STEP 1 - ADD OR FIND PUBLISHER
// ==========================================================
if(isset($_GET['ajax_add_publisher'])) {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);
    
    if(!$data) { exit; }

    $pub_name = $data['pub_name'];

    $check_stmt = $conn->prepare("SELECT pub_id FROM publishers WHERE pub_name = ?");
    $check_stmt->bind_param("s", $pub_name);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(["status" => "success", "pub_id" => $row['pub_id']]);
        $check_stmt->close();
        exit;
    }
    $check_stmt->close();

    // Insert New Publisher
    $gen_pub_id = (string)rand(9900, 9999);
    $stmt = $conn->prepare("INSERT INTO publishers (pub_id, pub_name, city, state, country) VALUES (?, ?, ?, ?, ?)");
    
    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => $conn->error]);
        exit;
    }

    $stmt->bind_param("sssss", $gen_pub_id, $pub_name, $data['city'], $data['state'], $data['country']);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "pub_id" => $gen_pub_id]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }
    $stmt->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publisher & Employee | Ink & Solace</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --light-bg: #dbdbdb; 
            --dark-bg: #20252d;
            --input-bg: #f2f2f2;
            --btn-add-color: #8f8989;    
            --btn-return-color: #3c4862; 
            --success-bg: #20252d;
        }
        * { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; min-height: 100vh; font-family: 'Montserrat', sans-serif; background-color: var(--light-bg); display: flex; flex-direction: column; }

        .top-section { background-color: var(--dark-bg); height: 250px; display: flex; flex-direction: column; justify-content: center; align-items: center; position: relative; }
        .logo-top { position: absolute; top: 20px; left: 30px; width: 150px; }
        .page-title-img { width: 520px; max-width: 85%; height: auto; margin-top: 30px; }
        .instruction-text { color: white; font-size: 14px; margin-top: 15px; opacity: 0.9; }

        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); backdrop-filter: blur(5px); display: none; justify-content: center; align-items: center; z-index: 1000; }
        .form-card { background-color: white; width: 800px; max-width: 95vw; padding: 40px; border-radius: 20px; position: relative; max-height: 90vh; overflow-y: auto; box-shadow: 0 10px 40px rgba(0,0,0,0.5); }
        .close-icon { position: absolute; top: 20px; right: 20px; font-size: 24px; cursor: pointer; color: #555; }
        .form-title { font-family: 'Cinzel', serif; font-size: 24px; color: var(--dark-bg); text-align: center; margin-bottom: 30px; border-bottom: 1px solid #ccc; padding-bottom: 10px; }
        
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; text-align: left; }
        .full-width { grid-column: 1 / -1; }
        .input-group { display: flex; flex-direction: column; }
        .text-label { font-family: 'Cinzel', serif; font-size: 14px; font-weight: 700; color: #444; margin-bottom: 5px; margin-left: 10px; text-transform: uppercase; }
        .table-input { width: 100%; padding: 12px 20px; border-radius: 50px; border: 1px solid #ccc; background-color: var(--input-bg); font-family: 'Montserrat', sans-serif; font-size: 14px; }

        .selection-container { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 25px; padding: 50px; }
        .big-btn { padding: 20px 0; width: 320px; border-radius: 50px; border: none; font-family: 'Cinzel', serif; font-weight: 700; font-size: 18px; color: white; cursor: pointer; text-transform: uppercase; box-shadow: 0 6px 15px rgba(0,0,0,0.25); transition: transform 0.2s; text-decoration: none; display: flex; justify-content: center; align-items: center; }
        .btn-add { background-color: var(--btn-add-color); }
        .btn-return { background-color: var(--btn-return-color); }
        .submit-btn { color: white; border: none; background-color: var(--btn-add-color); padding: 15px 50px; border-radius: 30px; font-weight: 700; cursor: pointer; text-transform: uppercase; }
        
        .success-box { background-color: var(--success-bg); width: 450px; padding: 40px; border-radius: 15px; text-align: center; color: white; display: flex; flex-direction: column; align-items: center; gap: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        .btn-done { background-color: #f0f0f0; color: #20252d; border: none; padding: 10px 40px; border-radius: 30px; font-weight: 700; cursor: pointer; }
        .hidden { display: none !important; }
    </style>
</head>
<body>

<div class="modal-overlay <?php echo $show_modal ? '' : 'hidden'; ?>" id="successModal" style="<?php echo $show_modal ? 'display:flex;' : ''; ?>">
    <div class="success-box">
        <h2 style="font-family: 'Cinzel'; margin:0; line-height:1.4;"><?php echo $success_message; ?></h2>
        <button class="btn-done" onclick="window.location.href='admin_view_database.php'">DONE</button>
    </div>
</div>

<div class="top-section">
    <img src="assets/text/logo.png" class="logo-top" alt="Logo">
    <img src="assets/text/title-publishers-employees.png" class="page-title-img" alt="Publishers & Employees">
    <p class="instruction-text">Complete the two-step process to add a new Publisher and their first Employee.</p>
</div>

<div class="selection-container">
    <button class="big-btn btn-add" onclick="openModal('pubModal')">ADD NEW INPUT</button>
    <a href="admin_view_database.php" class="big-btn btn-return">Return to Main Menu</a>
</div>

<div class="modal-overlay hidden" id="pubModal">
    <div class="form-card">
        <span class="close-icon" onclick="closeModal('pubModal')">&times;</span>
        <div class="form-title">STEP 1: ADD NEW PUBLISHER</div>
        <form id="pubForm" onsubmit="handlePubSubmit(event)">
            <div class="form-grid">
                <div class="input-group full-width">
                    <label class="text-label">Publisher Name</label>
                    <input type="text" id="pub_name" class="table-input" required>
                </div>
                <div class="input-group">
                    <label class="text-label">City</label>
                    <input type="text" id="city" class="table-input" required>
                </div>
                <div class="input-group">
                    <label class="text-label">State (2 chars)</label>
                    <input type="text" id="state" class="table-input" maxlength="2">
                </div>
                <div class="input-group full-width">
                    <label class="text-label">Country</label>
                    <input type="text" id="country" class="table-input" required>
                </div>
            </div>
            <div style="margin-top:30px; text-align:center;">
                <button type="submit" class="submit-btn">CONFIRM & PROCEED TO EMPLOYEE</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay hidden" id="empModal">
    <div class="form-card">
        <span class="close-icon" onclick="closeModal('empModal')">&times;</span>
        <div class="form-title">STEP 2: ADD NEW EMPLOYEE</div>
        <form method="POST">
            <input type="hidden" name="action" value="add_employee">
            <input type="hidden" name="pub_id" id="hidden_pub_id">

            <div class="form-grid">
                <div class="input-group">
                    <label class="text-label">First Name</label>
                    <input type="text" name="fname" class="table-input" required>
                </div>
                <div class="input-group">
                    <label class="text-label">Last Name</label>
                    <input type="text" name="lname" class="table-input" required>
                </div>
                <div class="input-group">
                    <label class="text-label">Middle Initial</label>
                    <input type="text" name="minit" class="table-input" maxlength="1">
                </div>
                <div class="input-group">
                    <label class="text-label">Job Level (10 - 250)</label>
                    <input type="number" name="job_lvl" class="table-input" min="10" max="250" required>
                </div>
                <div class="input-group full-width">
                    <label class="text-label">Hire Date</label>
                    <input type="date" name="hire_date" class="table-input" required>
                </div>
            </div>
            <div style="margin-top:30px; text-align:center;">
                <button type="submit" class="submit-btn" style="background-color: var(--btn-return-color);">FINISH & SAVE ALL</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
        document.getElementById(id).classList.add('hidden');
    }

    function handlePubSubmit(e) {
        e.preventDefault();
        const data = {
            pub_name: document.getElementById('pub_name').value,
            city: document.getElementById('city').value,
            state: document.getElementById('state').value,
            country: document.getElementById('country').value
        };

        fetch('?ajax_add_publisher=1', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.status === 'success') {
                closeModal('pubModal');
                document.getElementById('hidden_pub_id').value = result.pub_id;
                openModal('empModal');
            } else {
                alert('Error processing publisher: ' + result.message);
            }
        })
        .catch(err => {
            console.error(err);
            alert('Server error. Ensure extension=mysqli is enabled and Apache is restarted.');
        });
    }
</script>

</body>
</html>

