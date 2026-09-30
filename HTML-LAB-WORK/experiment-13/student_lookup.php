<?php
/**
 * Experiment 13: Student Information Lookup from Server-side XML Document
 * Course: Advanced Web Technology (CSIT248) - Sem VI IT
 * Amity University Noida
 * 
 * Aim:
 *   Create an XML document of 10 students of SEM VI IT containing Enrollment No.,
 *   marks obtained in 5 subjects, total marks, and percentage saved at the server.
 *   Write a program that accepts student Enrollment No. as an input and returns
 *   marks, total, and percentage by querying the server XML document.
 */

// Define path to the XML document saved at the server
$xmlFilePath = __DIR__ . '/students.xml';

$searchedEnrollment = '';
$studentData = null;
$errorMessage = '';
$hasSearched = false;

// Process lookup upon Form Submission (POST or GET)
if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['enrollment_no'])) {
    $searchedEnrollment = trim($_POST['enrollment_no'] ?? $_GET['enrollment_no'] ?? '');
    $hasSearched = true;

    if (empty($searchedEnrollment)) {
        $errorMessage = "Please enter a valid Enrollment Number (e.g., IT2023001).";
    } else {
        if (!file_exists($xmlFilePath)) {
            $errorMessage = "Server Error: XML database file ('students.xml') not found on server.";
        } else {
            // Load and parse XML document using PHP SimpleXML
            $xml = simplexml_load_file($xmlFilePath);

            if ($xml === false) {
                $errorMessage = "Failed to parse the server XML document.";
            } else {
                // Search for matching student record by enrollment number (case-insensitive)
                foreach ($xml->student as $student) {
                    if (strcasecmp((string)$student->enrollment_no, $searchedEnrollment) === 0) {
                        $studentData = [
                            'enrollment_no' => (string)$student->enrollment_no,
                            'name'          => (string)$student->name,
                            'semester'      => (string)$student->semester,
                            'academic_batch'=> (string)$student->academic_batch,
                            'total_marks'   => (int)$student->total_marks,
                            'percentage'    => (float)$student->percentage,
                            'grade'         => (string)$student->grade,
                            'result'        => (string)$student->result,
                            'subjects'      => []
                        ];

                        foreach ($student->marks->subject as $sub) {
                            $studentData['subjects'][] = [
                                'code'  => (string)$sub['code'],
                                'name'  => (string)$sub['name'],
                                'max'   => (int)$sub['max'],
                                'score' => (int)$sub
                            ];
                        }
                        break;
                    }
                }

                if (!$studentData) {
                    $errorMessage = "No record found for Enrollment Number: '" . htmlspecialchars($searchedEnrollment) . "'.";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Experiment 13 - Student XML Lookup System (CSIT248)</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Fira+Code:wght@400;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #6366f1;
      --primary-hover: #4f46e5;
      --secondary: #06b6d4;
      --success: #10b981;
      --warning: #f59e0b;
      --danger: #ef4444;
      --bg-dark: #0f172a;
      --card-bg: #1e293b;
      --border-color: #334155;
      --text-main: #f8fafc;
      --text-muted: #94a3b8;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Inter', system-ui, -apple-system, sans-serif;
      background-color: var(--bg-dark);
      color: var(--text-main);
      line-height: 1.6;
      min-height: 100vh;
      padding-bottom: 3rem;
    }
    nav {
      background: rgba(15, 23, 42, 0.95);
      border-bottom: 1px solid var(--border-color);
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 50;
      backdrop-filter: blur(10px);
    }
    .nav-brand {
      color: #818cf8;
      font-weight: 800;
      text-decoration: none;
      font-size: 1.15rem;
    }
    .container {
      max-width: 950px;
      margin: 2rem auto;
      padding: 0 1.5rem;
    }
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
    h1 {
      font-size: 2rem;
      font-weight: 800;
      margin-bottom: 0.5rem;
    }
    p.subtitle {
      color: var(--text-muted);
      margin-bottom: 2rem;
      font-size: 0.95rem;
    }
    .card {
      background: var(--card-bg);
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 2rem;
      margin-bottom: 2rem;
      box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    }
    .form-group {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
    }
    input[type="text"] {
      flex: 1;
      min-width: 260px;
      background: #0f172a;
      border: 1px solid var(--border-color);
      color: #fff;
      padding: 0.85rem 1rem;
      border-radius: 8px;
      font-size: 1rem;
      outline: none;
      transition: border-color 0.2s;
    }
    input[type="text"]:focus {
      border-color: var(--primary);
    }
    button {
      background: var(--primary);
      color: white;
      border: none;
      padding: 0.85rem 1.75rem;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.2s;
    }
    button:hover {
      background: var(--primary-hover);
    }
    .sample-chips {
      margin-top: 1rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      flex-wrap: wrap;
      font-size: 0.85rem;
      color: var(--text-muted);
    }
    .chip {
      background: #0f172a;
      border: 1px solid var(--border-color);
      color: #38bdf8;
      padding: 0.25rem 0.6rem;
      border-radius: 6px;
      cursor: pointer;
      text-decoration: none;
      font-family: 'Fira Code', monospace;
      font-size: 0.8rem;
    }
    .chip:hover {
      background: #334155;
    }
    .alert-error {
      background: rgba(239, 68, 68, 0.15);
      border: 1px solid var(--danger);
      color: #fca5a5;
      padding: 1rem 1.25rem;
      border-radius: 8px;
      margin-top: 1.5rem;
    }
    .scorecard {
      margin-top: 2rem;
      border-top: 1px solid var(--border-color);
      padding-top: 2rem;
    }
    .scorecard-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 1.5rem;
      flex-wrap: wrap;
      gap: 1rem;
    }
    .badge-grade {
      background: rgba(16, 185, 129, 0.2);
      border: 1px solid var(--success);
      color: #34d399;
      font-size: 1.25rem;
      font-weight: 800;
      padding: 0.5rem 1.25rem;
      border-radius: 8px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 1.5rem 0;
      font-size: 0.95rem;
    }
    th, td {
      padding: 0.85rem 1rem;
      text-align: left;
      border-bottom: 1px solid var(--border-color);
    }
    th {
      background: #0f172a;
      color: #38bdf8;
      font-weight: 600;
    }
    tr:hover td {
      background: rgba(255, 255, 255, 0.02);
    }
    .summary-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1rem;
      margin-top: 1.5rem;
    }
    .summary-box {
      background: #0f172a;
      border: 1px solid var(--border-color);
      border-radius: 8px;
      padding: 1rem 1.25rem;
    }
    .summary-box .label {
      font-size: 0.8rem;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }
    .summary-box .val {
      font-size: 1.6rem;
      font-weight: 800;
      color: #ffffff;
      margin-top: 0.25rem;
    }
  </style>
</head>
<body>

  <nav>
    <a href="index.html" class="nav-brand">&larr; CSIT248 Lab Experiments</a>
    <div style="display: flex; align-items: center; gap: 0.75rem;">
      <a href="https://atulanand-web-tech-labwork.netlify.app/" target="_blank" rel="noopener noreferrer"
        style="font-size: 0.85rem; color: #00c7b7; text-decoration: none; background: rgba(0, 199, 183, 0.15); border: 1px solid rgba(0, 199, 183, 0.35); padding: 0.3rem 0.75rem; border-radius: 9999px; font-weight: 600; display: inline-flex; align-items: center; gap: 0.35rem;">
        🌐 Live Portfolio
      </a>
      <span style="font-size: 0.85rem; color: var(--text-muted);">Experiment 13: XML Server Processing</span>
    </div>
  </nav>

  <div class="container">
    <div style="text-align: center; margin-bottom: 2rem;">
      <span class="badge">Experiment 13 &bull; Module XML &amp; Server-Side Processing</span>
      <h1>Student Information Lookup (XML Document)</h1>
      <p class="subtitle">Search and retrieve Semester VI IT student academic records from server-side XML</p>
    </div>

    <div class="card">
      <form method="POST" action="student_lookup.php">
        <div class="form-group">
          <input type="text" name="enrollment_no" placeholder="Enter Enrollment No. (e.g., IT2023001)" value="<?php echo htmlspecialchars($searchedEnrollment); ?>" required autofocus>
          <button type="submit">🔍 Fetch Marks</button>
        </div>
      </form>

      <div class="sample-chips">
        <span>Quick Samples:</span>
        <a class="chip" href="student_lookup.php?enrollment_no=IT2023001">IT2023001</a>
        <a class="chip" href="student_lookup.php?enrollment_no=IT2023002">IT2023002</a>
        <a class="chip" href="student_lookup.php?enrollment_no=IT2023004">IT2023004</a>
        <a class="chip" href="student_lookup.php?enrollment_no=IT2023008">IT2023008</a>
        <a class="chip" href="student_lookup.php?enrollment_no=IT2023010">IT2023010</a>
      </div>

      <?php if (!empty($errorMessage)): ?>
        <div class="alert-error">
          ⚠️ <?php echo htmlspecialchars($errorMessage); ?>
        </div>
      <?php endif; ?>

      <?php if ($studentData): ?>
        <div class="scorecard">
          <div class="scorecard-header">
            <div>
              <h2 style="color: #ffffff; font-size: 1.5rem;"><?php echo htmlspecialchars($studentData['name']); ?></h2>
              <p style="color: var(--text-muted); font-size: 0.9rem;">
                Enrollment No: <strong style="color: #38bdf8; font-family: 'Fira Code', monospace;"><?php echo htmlspecialchars($studentData['enrollment_no']); ?></strong> &bull; 
                Semester: <strong><?php echo htmlspecialchars($studentData['semester']); ?></strong> &bull;
                Batch: <strong><?php echo htmlspecialchars($studentData['academic_batch']); ?></strong>
              </p>
            </div>
            <div class="badge-grade">
              Grade <?php echo htmlspecialchars($studentData['grade']); ?> (<?php echo htmlspecialchars($studentData['result']); ?>)
            </div>
          </div>

          <table>
            <thead>
              <tr>
                <th>Code</th>
                <th>Subject Name</th>
                <th>Max Marks</th>
                <th>Marks Obtained</th>
                <th>Performance</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($studentData['subjects'] as $sub): ?>
                <tr>
                  <td style="font-family: 'Fira Code', monospace; color: #a5b4fc;"><?php echo htmlspecialchars($sub['code']); ?></td>
                  <td><strong><?php echo htmlspecialchars($sub['name']); ?></strong></td>
                  <td><?php echo $sub['max']; ?></td>
                  <td style="font-weight: 700; color: #38bdf8;"><?php echo $sub['score']; ?></td>
                  <td style="width: 25%;">
                    <div style="background: #0f172a; border-radius: 9999px; height: 10px; width: 100%; overflow: hidden; border: 1px solid #334155;">
                      <div style="background: <?php echo $sub['score'] >= 80 ? '#10b981' : ($sub['score'] >= 60 ? '#f59e0b' : '#ef4444'); ?>; height: 100%; width: <?php echo ($sub['score'] / $sub['max']) * 100; ?>%;"></div>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

          <div class="summary-grid">
            <div class="summary-box">
              <div class="label">Total Marks (Out of 500)</div>
              <div class="val" style="color: #818cf8;"><?php echo $studentData['total_marks']; ?> <span style="font-size: 0.9rem; color: var(--text-muted);">/ 500</span></div>
            </div>
            <div class="summary-box">
              <div class="label">Aggregate Percentage</div>
              <div class="val" style="color: #10b981;"><?php echo number_format($studentData['percentage'], 2); ?>%</div>
            </div>
            <div class="summary-box">
              <div class="label">Academic Result</div>
              <div class="val" style="color: #38bdf8;"><?php echo htmlspecialchars($studentData['result']); ?></div>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <footer style="text-align: center; margin-top: 3rem; padding: 1.5rem; border-top: 1px solid var(--border-color); color: var(--text-muted); font-size: 0.85rem;">
    <p style="margin-bottom: 0.35rem;">Designed &amp; Developed by <strong style="color: #818cf8;">Atul Anand</strong> &bull; Amity University Noida &bull; CSIT248</p>
    <p style="margin: 0;">
      Live Portfolio: <a href="https://atulanand-web-tech-labwork.netlify.app/" target="_blank" rel="noopener noreferrer" style="color: #00c7b7; text-decoration: none; font-weight: 600;">atulanand-web-tech-labwork.netlify.app</a>
    </p>
  </footer>

</body>
</html>
