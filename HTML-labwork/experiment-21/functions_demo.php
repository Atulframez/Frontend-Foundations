<?php
/**
 * Experiment 21: Demonstration of Array, String, and Numeric Functions in PHP
 * Course: Advanced Web Technology (CSIT248) - Amity University Noida
 * 
 * Objectives:
 *   Demonstrate core built-in PHP functions across three primary primitive/data structures:
 *   1. Array Functions (manipulation, searching, sorting, mapping, reduction)
 *   2. String Functions (length, casing, pattern matching, tokenizing, slicing)
 *   3. Numeric / Mathematical Functions (arithmetic, rounding, random generation, formatting)
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Experiment 21 - PHP Built-in Functions Masterclass</title>
  <style>
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #0f172a; color: #f8fafc; padding: 2rem; }
    h1, h2, h3 { color: #38bdf8; }
    .section { background: #1e293b; border: 1px solid #334155; border-radius: 10px; padding: 1.5rem; margin-bottom: 2rem; }
    table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
    th, td { padding: 0.65rem 0.85rem; border: 1px solid #334155; text-align: left; font-size: 0.9rem; }
    th { background: #0f172a; color: #a5b4fc; }
    code { font-family: Consolas, monospace; color: #38bdf8; background: #0b1120; padding: 0.15rem 0.4rem; border-radius: 4px; }
    .result { font-weight: bold; color: #34d399; font-family: Consolas, monospace; }
  </style>
</head>
<body>

  <h1>Experiment 21: Array, String &amp; Numeric Functions in PHP</h1>
  <p style="color: #94a3b8;">CSIT248 Advanced Web Technology &bull; Amity University Noida</p>

  <!-- ==========================================
       SECTION 1: ARRAY FUNCTIONS
       ========================================== -->
  <div class="section">
    <h2>1. Array Functions in PHP</h2>
    <?php
      $fruits = ["Apple", "Banana", "Cherry", "Mango", "Banana"];
      $numbers = [45, 12, 89, 34, 67, 23];
      $student = ["name" => "Atul Anand", "roll" => "IT2023001", "branch" => "IT", "sem" => "VI"];
    ?>
    <table>
      <thead>
        <tr><th>Function</th><th>Input / Context</th><th>PHP Expression</th><th>Output Result</th></tr>
      </thead>
      <tbody>
        <tr>
          <td><code>count()</code></td>
          <td>["Apple", "Banana", "Cherry", "Mango", "Banana"]</td>
          <td><code>count($fruits)</code></td>
          <td class="result"><?php echo count($fruits); ?> elements</td>
        </tr>
        <tr>
          <td><code>array_unique()</code></td>
          <td>Remove duplicates from $fruits</td>
          <td><code>array_unique($fruits)</code></td>
          <td class="result"><?php echo implode(", ", array_unique($fruits)); ?></td>
        </tr>
        <tr>
          <td><code>in_array()</code></td>
          <td>Search for "Cherry" in $fruits</td>
          <td><code>in_array("Cherry", $fruits)</code></td>
          <td class="result"><?php echo in_array("Cherry", $fruits) ? 'TRUE (Found)' : 'FALSE'; ?></td>
        </tr>
        <tr>
          <td><code>array_reverse()</code></td>
          <td>Reverse list $numbers</td>
          <td><code>array_reverse($numbers)</code></td>
          <td class="result"><?php echo implode(", ", array_reverse($numbers)); ?></td>
        </tr>
        <tr>
          <td><code>sort()</code></td>
          <td>Sort ascending $numbers</td>
          <td><code>sort($numbers)</code></td>
          <td class="result"><?php 
            $tempNums = $numbers; 
            sort($tempNums); 
            echo implode(", ", $tempNums); 
          ?></td>
        </tr>
        <tr>
          <td><code>rsort()</code></td>
          <td>Sort descending $numbers</td>
          <td><code>rsort($numbers)</code></td>
          <td class="result"><?php 
            $tempNums = $numbers; 
            rsort($tempNums); 
            echo implode(", ", $tempNums); 
          ?></td>
        </tr>
        <tr>
          <td><code>array_keys()</code></td>
          <td>Associative student keys</td>
          <td><code>array_keys($student)</code></td>
          <td class="result"><?php echo implode(", ", array_keys($student)); ?></td>
        </tr>
        <tr>
          <td><code>array_merge()</code></td>
          <td>Merge two arrays</td>
          <td><code>array_merge(["A","B"], ["C","D"])</code></td>
          <td class="result"><?php echo implode(", ", array_merge(["A","B"], ["C","D"])); ?></td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- ==========================================
       SECTION 2: STRING FUNCTIONS
       ========================================== -->
  <div class="section">
    <h2>2. String Functions in PHP</h2>
    <?php
      $sampleStr = "Advanced Web Technology in PHP";
      $paddedStr = "   Amity University Noida   ";
    ?>
    <table>
      <thead>
        <tr><th>Function</th><th>Input String</th><th>PHP Expression</th><th>Output Result</th></tr>
      </thead>
      <tbody>
        <tr>
          <td><code>strlen()</code></td>
          <td>"<?php echo $sampleStr; ?>"</td>
          <td><code>strlen($sampleStr)</code></td>
          <td class="result"><?php echo strlen($sampleStr); ?> characters</td>
        </tr>
        <tr>
          <td><code>str_word_count()</code></td>
          <td>"<?php echo $sampleStr; ?>"</td>
          <td><code>str_word_count($sampleStr)</code></td>
          <td class="result"><?php echo str_word_count($sampleStr); ?> words</td>
        </tr>
        <tr>
          <td><code>strtoupper()</code></td>
          <td>Convert to uppercase</td>
          <td><code>strtoupper($sampleStr)</code></td>
          <td class="result"><?php echo strtoupper($sampleStr); ?></td>
        </tr>
        <tr>
          <td><code>strtolower()</code></td>
          <td>Convert to lowercase</td>
          <td><code>strtolower($sampleStr)</code></td>
          <td class="result"><?php echo strtolower($sampleStr); ?></td>
        </tr>
        <tr>
          <td><code>strpos()</code></td>
          <td>Find index of "PHP"</td>
          <td><code>strpos($sampleStr, "PHP")</code></td>
          <td class="result"><?php echo strpos($sampleStr, "PHP"); ?> (0-indexed position)</td>
        </tr>
        <tr>
          <td><code>str_replace()</code></td>
          <td>Replace "PHP" with "Modern Web"</td>
          <td><code>str_replace("PHP", "Modern Web", ...)</code></td>
          <td class="result"><?php echo str_replace("PHP", "Modern Web", $sampleStr); ?></td>
        </tr>
        <tr>
          <td><code>substr()</code></td>
          <td>Substring characters 0 to 8</td>
          <td><code>substr($sampleStr, 0, 8)</code></td>
          <td class="result">"<?php echo substr($sampleStr, 0, 8); ?>"</td>
        </tr>
        <tr>
          <td><code>strrev()</code></td>
          <td>Reverse string</td>
          <td><code>strrev("Amity")</code></td>
          <td class="result"><?php echo strrev("Amity"); ?></td>
        </tr>
        <tr>
          <td><code>trim()</code></td>
          <td>Strip surrounding whitespaces</td>
          <td><code>trim($paddedStr)</code></td>
          <td class="result">"<?php echo trim($paddedStr); ?>"</td>
        </tr>
        <tr>
          <td><code>explode()</code></td>
          <td>Split string into array by space</td>
          <td><code>explode(" ", $sampleStr)</code></td>
          <td class="result">[<?php echo implode(" | ", explode(" ", $sampleStr)); ?>]</td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- ==========================================
       SECTION 3: NUMERIC / MATH FUNCTIONS
       ========================================== -->
  <div class="section">
    <h2>3. Numeric &amp; Mathematical Functions in PHP</h2>
    <table>
      <thead>
        <tr><th>Function</th><th>Input Values</th><th>PHP Expression</th><th>Output Result</th></tr>
      </thead>
      <tbody>
        <tr>
          <td><code>abs()</code></td>
          <td>-42.85</td>
          <td><code>abs(-42.85)</code></td>
          <td class="result"><?php echo abs(-42.85); ?></td>
        </tr>
        <tr>
          <td><code>round()</code></td>
          <td>3.14159265 to 3 decimals</td>
          <td><code>round(3.14159265, 3)</code></td>
          <td class="result"><?php echo round(3.14159265, 3); ?></td>
        </tr>
        <tr>
          <td><code>ceil()</code></td>
          <td>7.12 (ceiling integer)</td>
          <td><code>ceil(7.12)</code></td>
          <td class="result"><?php echo ceil(7.12); ?></td>
        </tr>
        <tr>
          <td><code>floor()</code></td>
          <td>7.89 (floor integer)</td>
          <td><code>floor(7.89)</code></td>
          <td class="result"><?php echo floor(7.89); ?></td>
        </tr>
        <tr>
          <td><code>sqrt()</code></td>
          <td>144</td>
          <td><code>sqrt(144)</code></td>
          <td class="result"><?php echo sqrt(144); ?></td>
        </tr>
        <tr>
          <td><code>pow()</code></td>
          <td>Base 2, Exponent 8</td>
          <td><code>pow(2, 8)</code></td>
          <td class="result"><?php echo pow(2, 8); ?></td>
        </tr>
        <tr>
          <td><code>max()</code> &amp; <code>min()</code></td>
          <td>Values: 15, 82, 4, 99, 36</td>
          <td><code>max(...)</code> / <code>min(...)</code></td>
          <td class="result">Max = <?php echo max(15, 82, 4, 99, 36); ?> | Min = <?php echo min(15, 82, 4, 99, 36); ?></td>
        </tr>
        <tr>
          <td><code>rand()</code></td>
          <td>Random integer between 100 and 999</td>
          <td><code>rand(100, 999)</code></td>
          <td class="result"><?php echo rand(100, 999); ?></td>
        </tr>
        <tr>
          <td><code>number_format()</code></td>
          <td>1250000.758 to 2 decimals with commas</td>
          <td><code>number_format(1250000.758, 2)</code></td>
          <td class="result"><?php echo number_format(1250000.758, 2); ?></td>
        </tr>
        <tr>
          <td><code>is_numeric()</code></td>
          <td>Validate numeric string "542.10"</td>
          <td><code>is_numeric("542.10")</code></td>
          <td class="result"><?php echo is_numeric("542.10") ? 'TRUE (Valid Number)' : 'FALSE'; ?></td>
        </tr>
      </tbody>
    </table>
  </div>

</body>
</html>
