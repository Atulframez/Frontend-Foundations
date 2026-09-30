<?php
/**
 * Experiment 20: Comprehensive Implementation of include() and require()
 * Course: Advanced Web Technology (CSIT248) - Amity University Noida
 * 
 * Key Difference:
 * 1. require() / require_once():
 *    - Used for mission-critical files (DB configuration, authorization).
 *    - If the file is not found, PHP throws a FATAL ERROR (E_COMPILE_ERROR)
 *      and completely STOPS the execution of the script.
 * 
 * 2. include() / include_once():
 *    - Used for presentation or non-critical components (header, footer, banners).
 *    - If the file is not found, PHP raises a WARNING (E_WARNING)
 *      and CONTINUES executing the remaining script.
 */

// Step 1: Load Critical Configuration via require_once
// If config.php is missing, application must not boot!
require_once __DIR__ . '/config.php';

$testMode = $_GET['test'] ?? 'normal';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo get_formatted_title('Include vs Require Demonstration'); ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Fira+Code:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', system-ui, sans-serif;
      background-color: #0f172a;
      color: #f8fafc;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    main {
      max-width: 1000px;
      margin: 2rem auto;
      padding: 0 1.5rem;
      flex: 1;
      width: 100%;
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
    .card {
      background: #1e293b;
      border: 1px solid #334155;
      border-radius: 12px;
      padding: 1.75rem;
      margin-bottom: 1.5rem;
    }
    .grid-2 {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.5rem;
      margin: 1.5rem 0;
    }
    @media (max-width: 768px) { .grid-2 { grid-template-columns: 1fr; } }
    .box-include {
      border-left: 4px solid #f59e0b;
      background: #0f172a;
      padding: 1.25rem;
      border-radius: 0 8px 8px 0;
    }
    .box-require {
      border-left: 4px solid #ef4444;
      background: #0f172a;
      padding: 1.25rem;
      border-radius: 0 8px 8px 0;
    }
    .btn {
      display: inline-block;
      padding: 0.6rem 1.1rem;
      border-radius: 6px;
      font-size: 0.85rem;
      font-weight: 600;
      text-decoration: none;
      margin-right: 0.5rem;
      margin-top: 0.5rem;
      cursor: pointer;
    }
    .btn-neutral { background: #334155; color: #fff; }
    .btn-warn { background: #d97706; color: #fff; }
    .btn-danger { background: #dc2626; color: #fff; }
    .output-console {
      background: #000;
      border: 1px solid #334155;
      border-radius: 8px;
      padding: 1rem;
      font-family: 'Fira Code', monospace;
      font-size: 0.85rem;
      color: #38bdf8;
      margin-top: 1rem;
    }
  </style>
</head>
<body>

  <!-- Step 2: Include UI Header via include() -->
  <?php include __DIR__ . '/header.php'; ?>

  <main>
    <div style="text-align: center; margin-bottom: 2rem;">
      <span class="badge">Experiment 20 &bull; Modular PHP Architecture</span>
      <h1 style="font-size: 2rem; font-weight: 800; margin: 0 0 0.5rem 0;">Demonstration of include( ) and require( )</h1>
      <p style="color: #94a3b8; font-size: 0.95rem;">Understand the execution lifecycle, warning versus fatal error handling, and component reusability</p>
    </div>

    <!-- Interactive Mode Switcher -->
    <div class="card">
      <h3 style="color: #38bdf8; margin: 0 0 0.75rem 0;">🧪 Interactive Test Bench: Choose Execution Scenario</h3>
      <p style="color: #cbd5e1; font-size: 0.9rem; margin-bottom: 1rem;">
        Click a button below to trigger normal execution or test missing file behaviors:
      </p>
      <div>
        <a href="include_require_demo.php?test=normal" class="btn btn-neutral">Scenario 1: Standard Execution (All Files Exist)</a>
        <a href="include_require_demo.php?test=missing_include" class="btn btn-warn">Scenario 2: Missing include() File (Throws Warning &amp; Continues)</a>
        <a href="include_require_demo.php?test=missing_require" class="btn btn-danger">Scenario 3: Missing require() File (Fatal Error &amp; Halts)</a>
      </div>
    </div>

    <!-- Active Scenario Result Box -->
    <div class="card">
      <h3 style="color: #f8fafc; margin: 0 0 0.5rem 0;">Execution Console Output:</h3>

      <?php
      if ($testMode === 'normal') {
          echo "<div class='output-console'>";
          echo "<span style='color: #10b981;'>[OK]</span> require_once 'config.php' executed successfully.<br>";
          echo "<span style='color: #10b981;'>[OK]</span> include 'header.php' executed successfully.<br>";
          echo "<span style='color: #38bdf8;'>[INFO]</span> Application Name: " . APP_NAME . "<br>";
          echo "<span style='color: #38bdf8;'>[INFO]</span> Institution: " . INSTITUTION . "<br>";
          $sys = get_system_status();
          echo "<span style='color: #38bdf8;'>[INFO]</span> Server Timestamp: " . $sys['server_time'] . " | PHP Version: " . $sys['php_version'] . "<br>";
          echo "<span style='color: #10b981;'>[OK]</span> All files loaded without interruption.";
          echo "</div>";
      } elseif ($testMode === 'missing_include') {
          echo "<div class='output-console'>";
          echo "<span style='color: #f59e0b;'>[TEST TRIGGERED]</span> Calling: <code>include 'non_existent_optional_widget.php';</code><br><br>";
          
          // Execute include on missing file
          include 'non_existent_optional_widget.php';

          echo "<br><span style='color: #10b981;'>[KEY TAKEAWAY]</span> <strong>Script execution CONTINUES!</strong> Even though the file was missing and an E_WARNING was generated, the page body and footer continue to render successfully.";
          echo "</div>";
      } elseif ($testMode === 'missing_require') {
          echo "<div class='output-console'>";
          echo "<span style='color: #ef4444;'>[TEST TRIGGERED]</span> Calling: <code>require 'non_existent_critical_auth.php';</code><br>";
          echo "<span style='color: #f87171;'>[NOTICE]</span> In standard PHP, the line below generates a <strong>Fatal error: E_COMPILE_ERROR</strong> and the remaining script (including this page and the footer) will NOT execute!<br><br>";
          
          // Require missing critical file
          require 'non_existent_critical_auth.php';

          // The line below is intentionally unreachable due to fatal error
          echo "<span style='color: red;'>This line will never print because require halts execution!</span>";
          echo "</div>";
      }
      ?>
    </div>

    <!-- Comparative Theory Grid -->
    <div class="grid-2">
      <div class="box-include">
        <h4 style="color: #f59e0b; margin: 0 0 0.5rem 0;">1. include( ) &amp; include_once( )</h4>
        <ul style="color: #cbd5e1; font-size: 0.85rem; padding-left: 1.25rem; line-height: 1.7;">
          <li><strong>Severity:</strong> <code>E_WARNING</code> if file missing.</li>
          <li><strong>Behavior:</strong> Does <em>not</em> stop script execution.</li>
          <li><strong>Best For:</strong> Reusable view components, page footers, banners, optional sidebar panels.</li>
          <li><strong>Once variant:</strong> <code>include_once()</code> ensures the file is included exactly once per request.</li>
        </ul>
      </div>

      <div class="box-require">
        <h4 style="color: #ef4444; margin: 0 0 0.5rem 0;">2. require( ) &amp; require_once( )</h4>
        <ul style="color: #cbd5e1; font-size: 0.85rem; padding-left: 1.25rem; line-height: 1.7;">
          <li><strong>Severity:</strong> <code>E_COMPILE_ERROR</code> (Fatal Error).</li>
          <li><strong>Behavior:</strong> <em>Immediately halts</em> script execution.</li>
          <li><strong>Best For:</strong> Mission-critical files like database connection, authentication, encryption keys, core libraries.</li>
          <li><strong>Once variant:</strong> <code>require_once()</code> prevents function and class re-declaration collisions.</li>
        </ul>
      </div>
    </div>

  </main>

  <!-- Step 3: Include UI Footer via include() -->
  <?php include __DIR__ . '/footer.php'; ?>

</body>
</html>
