<?php
// Start the session
session_start();

// Check if there are any session variables set
if (!empty($_SESSION)) {
    echo "<h3>Session Variables:</h3>";
    echo "<ul>";
    foreach ($_SESSION as $key => $value) {
        echo "<li><strong>$key</strong>: " . htmlspecialchars($value) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No session variables are set.</p>";
}
?>
