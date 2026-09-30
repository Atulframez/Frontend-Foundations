<?php
/**
 * Experiment 20: Site Configuration File (Included via require_once)
 * Course: Advanced Web Technology (CSIT248) - Amity University Noida
 */

// Define application-wide configuration constants
define('APP_NAME', 'EduPortal Portal System');
define('APP_VERSION', '3.4.1');
define('INSTITUTION', 'Amity University Noida');
define('DEPARTMENT', 'Department of Computer Applications');
define('ACADEMIC_YEAR', '2025-2026');

// Helper function to format page titles
function get_formatted_title($pageName) {
    return $pageName . ' | ' . APP_NAME;
}

// Helper function for user role validation
function get_system_status() {
    return [
        'status' => 'ONLINE',
        'server_time' => date('Y-m-d H:i:s'),
        'php_version' => PHP_VERSION
    ];
}
?>
