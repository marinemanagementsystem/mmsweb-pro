<?php
/**
 * MMS - Marine Management System
 * Form Processing File
 */

// Initialize the application
require_once 'includes/init.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Demo request form
    if (isset($_POST['demo_request'])) {
        $success = handle_demo_request($_POST);
        
        if ($success) {
            // Redirect back to index with success message
            header('Location: index.php?success=demo');
            exit;
        }
    }
    
    // Contact form
    elseif (isset($_POST['contact_form'])) {
        $success = handle_contact_form($_POST);
        
        if ($success) {
            // Redirect back to index with success message
            header('Location: index.php?success=contact');
            exit;
        }
    }
}

// If we got here, something went wrong
header('Location: index.php?error=1');
exit; 