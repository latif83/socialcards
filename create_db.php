<?php
// Path to database file
$db_file = __DIR__ . '/database/database.db';

// Create database folder if it doesn't exist
if (!file_exists(__DIR__ . '/database')) {
    mkdir(__DIR__ . '/database', 0755, true);
}

try {
    // Create (or open) SQLite database
    $db = new PDO('sqlite:' . $db_file);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create tables
    $db->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
    ");

    $db->exec("
        CREATE TABLE IF NOT EXISTS cards (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            type TEXT NOT NULL,
            title TEXT,
            description TEXT,
            category TEXT,
            location TEXT,
            is_public INTEGER DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        );
    ");

    $db->exec("
        CREATE TABLE IF NOT EXISTS social_links (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            card_id INTEGER,
            platform TEXT,
            url TEXT,
            FOREIGN KEY (card_id) REFERENCES cards(id) ON DELETE CASCADE
        );
    ");

    echo "Database and tables created successfully!";

} catch (PDOException $e) {
    die("Error creating database: " . $e->getMessage());
}
