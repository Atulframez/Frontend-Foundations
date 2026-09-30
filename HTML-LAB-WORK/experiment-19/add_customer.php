<?php
/**
 * Experiment 19: PHP Script to Add New Record in CUSTOMER Database
 * Course: Advanced Web Technology (CSIT248)
 * Amity University Noida
 * 
 * Objective:
 *   Establish a secure MySQL database connection using PDO/Prepared Statements,
 *   collect customer details via an HTML form, validate inputs, execute an INSERT query,
 *   handle exceptions (such as duplicate entries), and display existing records.
 */

// Database Configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = ''; // Default XAMPP/WAMP password is empty
$db_name = 'customer_db';

$success_msg = '';
$error_msg = '';
$customers_list = [];

try {
    // 1. Establish PDO Connection
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // 2. Handle Form Submission for Adding Customer
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_customer') {
        $name    = trim($_POST['customer_name'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $phone   = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $city    = trim($_POST['city'] ?? '');

        // Server-side validation
        if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($city)) {
            $error_msg = "All fields marked with an asterisk (*) are mandatory.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_msg = "Invalid email address format.";
        } else {
            // Prepared statement to prevent SQL Injection
            $sql = "INSERT INTO customers (customer_name, email, phone, address, city) VALUES (:name, :email, :phone, :address, :city)";
            $stmt = $pdo->prepare($sql);
            
            $stmt->execute([
                ':name'    => htmlspecialchars($name),
                ':email'   => htmlspecialchars($email),
                ':phone'   => htmlspecialchars($phone),
                ':address' => htmlspecialchars($address),
                ':city'    => htmlspecialchars($city)
            ]);

            $new_id = $pdo->lastInsertId();
            $success_msg = "Customer record successfully created! Assigned Customer ID: #$new_id";
        }
    }

    // 3. Fetch all customer records to display in the table
    $stmt_all = $pdo->query("SELECT * FROM customers ORDER BY customer_id DESC");
    $customers_list = $stmt_all->fetchAll();

} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        $error_msg = "A customer with email '$email' already exists in the database.";
    } else {
        $error_msg = "Database Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Experiment 19 - Add Customer Record (PHP &amp; MySQL)</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Fira+Code:wght@400;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #6366f1;
      --primary-hover: #4f46e5;
      --success: #10b981;
      --danger: #ef4444;
      --bg: #0f172a;
      --card-bg: #1e293b;
      --border: #334155;
      --text: #f8fafc;
      --muted: #94a3b8;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Inter', system-ui, sans-serif;
      background: var(--bg);
      color: var(--text);
      line-height: 1.6;
      padding-bottom: 3rem;
    }
    nav {
      background: rgba(15, 23, 42, 0.95);
      border-bottom: 1px solid var(--border);
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 50;
    }
    .nav-brand { color: #818cf8; text-decoration: none; font-weight: 800; font-size: 1.15rem; }
    .container { max-width: 1100px; margin: 2rem auto; padding: 0 1.5rem; }
    .header { text-align: center; margin-bottom: 2rem; }
    .badge {
      display: inline-block;
      background: rgba(99, 102, 241, 0.15);
      color: #a5b4fc;
      border: 1px solid rgba(99, 102, 241, 0.3);
      padding: 0.25rem 0.75rem;
      border-radius: 9999px;
      font-size: 0.8rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }
    h1 { font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem; }
    .grid { display: grid; grid-template-columns: 380px 1fr; gap: 2rem; }
    @media (max-width: 860px) { .grid { grid-template-columns: 1fr; } }
    .card {
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 1.75rem;
      box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    }
    .card h2 {
      font-size: 1.25rem;
      color: #38bdf8;
      margin-bottom: 1.25rem;
      border-bottom: 1px solid var(--border);
      padding-bottom: 0.5rem;
    }
    .form-group { margin-bottom: 1rem; }
    label { display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.35rem; }
    input[type="text"], input[type="email"], textarea {
      width: 100%;
      background: #0f172a;
      border: 1px solid var(--border);
      color: #fff;
      padding: 0.65rem 0.85rem;
      border-radius: 6px;
      font-size: 0.9rem;
      outline: none;
    }
    input:focus, textarea:focus { border-color: var(--primary); }
    button {
      width: 100%;
      background: var(--primary);
      color: white;
      border: none;
      padding: 0.85rem;
      border-radius: 6px;
      font-size: 0.95rem;
      font-weight: 700;
      cursor: pointer;
      transition: background 0.2s;
    }
    button:hover { background: var(--primary-hover); }
    .alert-success { background: rgba(16, 185, 129, 0.15); border: 1px solid var(--success); color: #6ee7b7; padding: 0.85rem 1rem; border-radius: 6px; margin-bottom: 1.25rem; font-size: 0.9rem; }
    .alert-error { background: rgba(239, 68, 68, 0.15); border: 1px solid var(--danger); color: #fca5a5; padding: 0.85rem 1rem; border-radius: 6px; margin-bottom: 1.25rem; font-size: 0.9rem; }
    table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
    th, td { padding: 0.75rem 0.85rem; text-align: left; border-bottom: 1px solid var(--border); }
    th { background: #0f172a; color: #38bdf8; font-weight: 600; }
  </style>
</head>
<body>

  <nav>
    <a href="index.html" class="nav-brand">&larr; CSIT248 Lab Experiments</a>
    <span style="font-size: 0.85rem; color: var(--muted);">Experiment 19: Database Operations</span>
  </nav>

  <div class="container">
    <div class="header">
      <span class="badge">Experiment 19 &bull; Module PHP &amp; MySQL Connectivity</span>
      <h1>Customer Database Record Management</h1>
      <p style="color: var(--muted); font-size: 0.95rem;">Insert new customer entries and view real-time database records</p>
    </div>

    <?php if ($success_msg): ?>
      <div class="alert-success">✅ <?php echo htmlspecialchars($success_msg); ?></div>
    <?php endif; ?>

    <?php if ($error_msg): ?>
      <div class="alert-error">⚠️ <?php echo htmlspecialchars($error_msg); ?></div>
    <?php endif; ?>

    <div class="grid">
      <!-- Form Panel -->
      <div class="card">
        <h2>➕ Add New Customer</h2>
        <form method="POST" action="add_customer.php">
          <input type="hidden" name="action" value="add_customer">

          <div class="form-group">
            <label for="customer_name">Customer Full Name *</label>
            <input type="text" id="customer_name" name="customer_name" required placeholder="e.g. Atul Anand">
          </div>

          <div class="form-group">
            <label for="email">Email Address *</label>
            <input type="email" id="email" name="email" required placeholder="e.g. atul@example.com">
          </div>

          <div class="form-group">
            <label for="phone">Phone Number *</label>
            <input type="text" id="phone" name="phone" required placeholder="e.g. +91 98765 43210">
          </div>

          <div class="form-group">
            <label for="city">City *</label>
            <input type="text" id="city" name="city" required placeholder="e.g. Noida / New Delhi">
          </div>

          <div class="form-group">
            <label for="address">Street Address *</label>
            <textarea id="address" name="address" rows="3" required placeholder="e.g. Sector 125, Amity Campus"></textarea>
          </div>

          <button type="submit">Insert Record into Database</button>
        </form>
      </div>

      <!-- Customer Records List -->
      <div class="card" style="overflow-x: auto;">
        <h2>📋 Customer Database Records (Table: customers)</h2>
        <?php if (!empty($customers_list)): ?>
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>City</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($customers_list as $cust): ?>
                <tr>
                  <td style="font-family: 'Fira Code', monospace; color: #a5b4fc;">#<?php echo $cust['customer_id']; ?></td>
                  <td><strong><?php echo htmlspecialchars($cust['customer_name']); ?></strong></td>
                  <td><?php echo htmlspecialchars($cust['email']); ?></td>
                  <td style="font-family: 'Fira Code', monospace;"><?php echo htmlspecialchars($cust['phone']); ?></td>
                  <td><span style="background: rgba(56, 189, 248, 0.1); color: #38bdf8; padding: 0.2rem 0.5rem; border-radius: 4px;"><?php echo htmlspecialchars($cust['city']); ?></span></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p style="color: var(--muted); text-align: center; padding: 2rem;">No customer records found or database connection pending.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

</body>
</html>
