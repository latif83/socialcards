<?php
// Path to SQLite database file
$db_path = __DIR__ . '/database/database.db';

try {
    // Create (or connect to) database
    $db = new PDO('sqlite:' . $db_path);

    // Enable foreign keys
    $db->exec("PRAGMA foreign_keys = ON;");

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
