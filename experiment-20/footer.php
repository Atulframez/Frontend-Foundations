<?php
/**
 * Experiment 20: Modular Footer Component (Included via include)
 * Course: Advanced Web Technology (CSIT248) - Amity University Noida
 */
?>
<!-- Global Footer Component -->
<footer style="background: #0b1120; border-top: 1px solid #334155; padding: 1.5rem 2rem; text-align: center; font-size: 0.85rem; color: #94a3b8; margin-top: 3rem;">
  <p style="margin: 0 0 0.5rem 0; color: #cbd5e1; font-weight: 600;">
    &copy; <?php echo date('Y'); ?> <?php echo defined('APP_NAME') ? APP_NAME : 'EduPortal'; ?> &bull; Version <?php echo defined('APP_VERSION') ? APP_VERSION : '1.0'; ?>
  </p>
  <p style="margin: 0; color: #64748b; font-size: 0.8rem;">
    Designed &amp; Developed for CSIT248 Advanced Web Technology Lab &bull; <?php echo defined('INSTITUTION') ? INSTITUTION : ''; ?>
  </p>
</footer>
