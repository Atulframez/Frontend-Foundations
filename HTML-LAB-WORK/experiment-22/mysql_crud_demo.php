<?php
/**
 * Experiment 22: PHP Script to Implement MySQL Commands:
 * a) DELETE
 * b) ORDER BY
 * c) UPDATE
 * 
 * Course: Advanced Web Technology (CSIT248) - Amity University Noida
 */

// Database Connection Settings
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'company_db';

$message = '';
$message_type = 'success';
$last_query = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // ==========================================
    // 1. IMPLEMENTATION: a) DELETE COMMAND
    // ==========================================
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        $delete_id = (int)$_GET['id'];
        
        $delete_sql = "DELETE FROM employees WHERE emp_id = :id";
        $last_query = "DELETE FROM employees WHERE emp_id = $delete_id;";
        
        $stmt = $pdo->prepare($delete_sql);
        $stmt->execute([':id' => $delete_id]);

        if ($stmt->rowCount() > 0) {
            $message = "Record with Employee ID #$delete_id was successfully deleted.";
            $message_type = "success";
        } else {
            $message = "Record not found or already deleted.";
            $message_type = "error";
        }
    }

    // ==========================================
    // 2. IMPLEMENTATION: c) UPDATE COMMAND
    // ==========================================
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
        $emp_id      = (int)$_POST['emp_id'];
        $designation = trim($_POST['designation'] ?? '');
        $salary      = (float)$_POST['salary'];
        $department  = trim($_POST['department'] ?? '');

        if ($emp_id > 0 && !empty($designation) && $salary > 0) {
            $update_sql = "UPDATE employees SET designation = :desig, salary = :sal, department = :dept WHERE emp_id = :id";
            $last_query = "UPDATE employees SET designation = '$designation', salary = $salary, department = '$department' WHERE emp_id = $emp_id;";
            
            $stmt = $pdo->prepare($update_sql);
            $stmt->execute([
                ':desig' => $designation,
                ':sal'   => $salary,
                ':dept'  => $department,
                ':id'    => $emp_id
            ]);

            $message = "Employee #$emp_id successfully updated.";
            $message_type = "success";
        } else {
            $message = "Invalid input values for record update.";
            $message_type = "error";
        }
    }

    // ==========================================
    // 3. IMPLEMENTATION: b) ORDER BY COMMAND
    // ==========================================
    // Whitelist columns to prevent SQL Injection in ORDER BY clause
    $allowed_sorts = ['emp_id', 'emp_name', 'department', 'designation', 'salary', 'joined_date'];
    $allowed_orders = ['ASC', 'DESC'];

    $sort_by = in_array($_GET['sort'] ?? '', $allowed_sorts) ? $_GET['sort'] : 'emp_id';
    $order   = in_array(strtoupper($_GET['order'] ?? ''), $allowed_orders) ? strtoupper($_GET['order']) : 'ASC';

    $next_order = ($order === 'ASC') ? 'DESC' : 'ASC';

    $select_sql = "SELECT * FROM employees ORDER BY $sort_by $order";
    if (empty($last_query)) {
        $last_query = $select_sql . ";";
    }

    $stmt_list = $pdo->query($select_sql);
    $employees = $stmt_list->fetchAll();

} catch (PDOException $e) {
    $message = "Database Exception: " . $e->getMessage();
    $message_type = "error";
    $employees = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Experiment 22 - DELETE, ORDER BY &amp; UPDATE in MySQL</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Fira+Code:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', system-ui, sans-serif; background: #0f172a; color: #f8fafc; margin: 0; padding: 2rem; }
    .container { max-width: 1100px; margin: 0 auto; }
    .card { background: #1e293b; border: 1px solid #334155; border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem; }
    h1 { color: #fff; font-size: 1.85rem; margin-bottom: 0.5rem; }
    .alert { padding: 0.75rem 1rem; border-radius: 6px; margin-bottom: 1rem; font-size: 0.9rem; }
    .alert.success { background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #6ee7b7; }
    .alert.error { background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #fca5a5; }
    table { width: 100%; border-collapse: collapse; font-size: 0.9rem; margin-top: 1rem; }
    th, td { padding: 0.75rem 1rem; border-bottom: 1px solid #334155; text-align: left; }
    th { background: #0f172a; color: #38bdf8; }
    th a { color: #38bdf8; text-decoration: none; display: flex; align-items: center; gap: 0.25rem; }
    th a:hover { text-decoration: underline; }
    .btn { padding: 0.35rem 0.65rem; border-radius: 4px; font-size: 0.8rem; text-decoration: none; cursor: pointer; border: none; font-weight: 600; }
    .btn-edit { background: #6366f1; color: #fff; }
    .btn-delete { background: #ef4444; color: #fff; }
    .sql-box { background: #000; border: 1px solid #334155; border-radius: 8px; padding: 1rem; font-family: 'Fira Code', monospace; font-size: 0.85rem; color: #38bdf8; margin-top: 1rem; }
  </style>
</head>
<body>

<div class="container">
  <h1>Experiment 22: MySQL DELETE, ORDER BY &amp; UPDATE</h1>
  <p style="color: #94a3b8; margin-bottom: 1.5rem;">CSIT248 Advanced Web Technology &bull; Amity University Noida</p>

  <?php if (!empty($message)): ?>
    <div class="alert <?php echo $message_type; ?>">
      <?php echo htmlspecialchars($message); ?>
    </div>
  <?php endif; ?>

  <div class="card">
    <h3 style="color: #38bdf8; margin: 0 0 0.5rem 0;">1. Command b) ORDER BY &bull; Click column header to toggle ASC/DESC</h3>
    
    <table>
      <thead>
        <tr>
          <th><a href="?sort=emp_id&order=<?php echo $next_order; ?>">ID <?php echo ($sort_by === 'emp_id') ? ($order === 'ASC' ? '▲' : '▼') : ''; ?></a></th>
          <th><a href="?sort=emp_name&order=<?php echo $next_order; ?>">Employee Name <?php echo ($sort_by === 'emp_name') ? ($order === 'ASC' ? '▲' : '▼') : ''; ?></a></th>
          <th><a href="?sort=department&order=<?php echo $next_order; ?>">Department <?php echo ($sort_by === 'department') ? ($order === 'ASC' ? '▲' : '▼') : ''; ?></a></th>
          <th><a href="?sort=designation&order=<?php echo $next_order; ?>">Designation <?php echo ($sort_by === 'designation') ? ($order === 'ASC' ? '▲' : '▼') : ''; ?></a></th>
          <th><a href="?sort=salary&order=<?php echo $next_order; ?>">Salary (₹) <?php echo ($sort_by === 'salary') ? ($order === 'ASC' ? '▲' : '▼') : ''; ?></a></th>
          <th>Actions (UPDATE &amp; DELETE)</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($employees)): ?>
          <?php foreach ($employees as $row): ?>
            <tr>
              <td style="font-family: 'Fira Code', monospace;">#<?php echo $row['emp_id']; ?></td>
              <td><strong><?php echo htmlspecialchars($row['emp_name']); ?></strong></td>
              <td><?php echo htmlspecialchars($row['department']); ?></td>
              <td><?php echo htmlspecialchars($row['designation']); ?></td>
              <td style="font-family: 'Fira Code', monospace; color: #34d399;">₹<?php echo number_format($row['salary'], 2); ?></td>
              <td>
                <button type="button" class="btn btn-edit" onclick="populateEditForm(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit (UPDATE)</button>
                <a href="?action=delete&id=<?php echo $row['emp_id']; ?>&sort=<?php echo $sort_by; ?>&order=<?php echo $order; ?>" 
                   class="btn btn-delete" 
                   onclick="return confirm('Execute DELETE for Employee #<?php echo $row['emp_id']; ?>?')">DELETE</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="6" style="text-align: center; color: #94a3b8; padding: 2rem;">No records found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Form for UPDATE -->
  <div class="card" id="edit-card" style="display: none;">
    <h3 style="color: #818cf8; margin: 0 0 1rem 0;">2. Command c) UPDATE Employee Record</h3>
    <form method="POST" action="mysql_crud_demo.php">
      <input type="hidden" name="action" value="update">
      <input type="hidden" name="emp_id" id="edit_emp_id">

      <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 1rem;">
        <div>
          <label style="display: block; font-size: 0.8rem; margin-bottom: 0.3rem;">Department</label>
          <input type="text" name="department" id="edit_department" required style="width: 100%; background: #0f172a; border: 1px solid #334155; color: #fff; padding: 0.5rem; border-radius: 4px;">
        </div>
        <div>
          <label style="display: block; font-size: 0.8rem; margin-bottom: 0.3rem;">Designation</label>
          <input type="text" name="designation" id="edit_designation" required style="width: 100%; background: #0f172a; border: 1px solid #334155; color: #fff; padding: 0.5rem; border-radius: 4px;">
        </div>
        <div>
          <label style="display: block; font-size: 0.8rem; margin-bottom: 0.3rem;">Salary (₹)</label>
          <input type="number" step="1000" name="salary" id="edit_salary" required style="width: 100%; background: #0f172a; border: 1px solid #334155; color: #fff; padding: 0.5rem; border-radius: 4px;">
        </div>
      </div>
      <button type="submit" class="btn btn-edit" style="padding: 0.6rem 1.25rem;">Execute UPDATE Query</button>
    </form>
  </div>

  <div class="sql-box">
    <strong>Last Executed MySQL Command:</strong><br>
    <code><?php echo htmlspecialchars($last_query); ?></code>
  </div>
</div>

<script>
  function populateEditForm(emp) {
    document.getElementById('edit-card').style.display = 'block';
    document.getElementById('edit_emp_id').value = emp.emp_id;
    document.getElementById('edit_department').value = emp.department;
    document.getElementById('edit_designation').value = emp.designation;
    document.getElementById('edit_salary').value = emp.salary;
    document.getElementById('edit-card').scrollIntoView({ behavior: 'smooth' });
  }
</script>

</body>
</html>
