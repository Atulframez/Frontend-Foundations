<?php
/**
 * Experiment 20: Modular Header Component (Included via include)
 * Course: Advanced Web Technology (CSIT248) - Amity University Noida
 */
?>
<!-- Global Header Component -->
<header style="background: rgba(15, 23, 42, 0.95); border-bottom: 1px solid #334155; padding: 1.25rem 2rem; display: flex; justify-content: space-between; align-items: center;">
  <div style="display: flex; align-items: center; gap: 0.75rem;">
    <span style="background: #6366f1; color: #fff; font-weight: 800; padding: 0.3rem 0.6rem; border-radius: 6px; font-size: 0.9rem;">EP</span>
    <div>
      <h2 style="font-size: 1.15rem; color: #ffffff; margin: 0; font-weight: 700;"><?php echo defined('APP_NAME') ? APP_NAME : 'Default Portal'; ?></h2>
      <p style="font-size: 0.75rem; color: #94a3b8; margin: 0;"><?php echo defined('INSTITUTION') ? INSTITUTION : ''; ?> &bull; <?php echo defined('DEPARTMENT') ? DEPARTMENT : ''; ?></p>
    </div>
  </div>
  <nav style="display: flex; gap: 1rem; font-size: 0.85rem;">
    <a href="#home" style="color: #38bdf8; text-decoration: none; font-weight: 600;">Home</a>
    <a href="#about" style="color: #cbd5e1; text-decoration: none;">About</a>
    <a href="#experiments" style="color: #cbd5e1; text-decoration: none;">Lab Experiments</a>
    <a href="#contact" style="color: #cbd5e1; text-decoration: none;">Contact</a>
  </nav>
</header>
