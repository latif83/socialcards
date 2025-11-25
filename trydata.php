<?php
require 'config.php';

// ------------------ Insert sample data ------------------
$name = "John Doe";
$email = "john" . rand(1,1000) . "@example.com";
$password = password_hash("12345", PASSWORD_DEFAULT);

$stmt = $db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->execute([$name, $email, $password]);

// ------------------ Fetch all users ------------------
$stmt2 = $db->query("SELECT * FROM users");
$users = $stmt2->fetchAll(PDO::FETCH_ASSOC);

// Display results
echo "<h2>Users in Database:</h2><ul>";
foreach ($users as $user) {
    echo "<li>ID: {$user['id']}, Name: {$user['name']}, Email: {$user['email']}</li>";
}
echo "</ul>";
