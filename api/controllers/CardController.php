<?php

class CardController
{
    private $db;

    /**
     * Constructor receives PDO database instance from api.php
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Handle adding a new card via POST request.
     * 
     * Expected POST fields:
     * - title
     * - content
     * - visibility (public/private)
     * - profile_image (optional, URL to uploaded file)
     * 
     * Requires user to be logged in so it can attach "user_id".
     */
    public function handleAdd($data, $method)
    {
        if ($method !== 'POST') {
            return ['success' => false, 'message' => 'POST request required.'];
        }

        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            return ['success' => false, 'message' => 'You must be logged in.'];
        }

        $user_id = $_SESSION['user_id'];

        // Main fields
        $card_type = trim($data['card_type'] ?? '');
        $name = trim($data['name'] ?? '');
        $title_role = trim($data['title_role'] ?? '');
        $email = trim($data['email'] ?? '');
        $phone = trim($data['phone'] ?? '');
        $bio = trim($data['bio'] ?? '');

        // Social links: array from form input
        $social_links = $data['social_links'] ?? [];
        $social_links_json = json_encode($social_links);

        // Validate required fields
        if (empty($card_type))
            return ['success' => false, 'message' => "Card type is required."];
        if (empty($name))
            return ['success' => false, 'message' => "Name is required."];

        // --------------------------
        // HANDLE FILE UPLOAD
        // --------------------------
        $uploaded_url = null;

        if (!empty($_FILES['profile_image']['name'])) {
            $uploadDir = __DIR__ . "/../../uploads/";

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileTmp = $_FILES['profile_image']['tmp_name'];
            $fileName = uniqid() . "_" . basename($_FILES['profile_image']['name']);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($fileTmp, $filePath)) {
                // Public URL for Azure
                $uploaded_url = "/uploads/" . $fileName;
            } else {
                return ['success' => false, 'message' => "Failed to upload image."];
            }
        }

        // --------------------------
        // INSERT INTO DATABASE
        // --------------------------
        try {
            $stmt = $this->db->prepare("
            INSERT INTO cards 
                (user_id, card_type, name, title_role, email, phone, profile_image, social_links,bio)
            VALUES 
                (:user_id, :card_type, :name, :title_role, :email, :phone, :profile_image, :social_links, :bio)
        ");

            $stmt->execute([
                ':user_id' => $user_id,
                ':card_type' => $card_type,
                ':name' => $name,
                ':title_role' => $title_role,
                ':email' => $email,
                ':phone' => $phone,
                ':profile_image' => $uploaded_url,
                ':social_links' => $social_links_json,
                ':bio' => $bio
            ]);

            return [
                'success' => true,
                'message' => 'Card created successfully!'
            ];

        } catch (PDOException $e) {
            error_log("DB Error AddCard: " . $e->getMessage());
            return ['success' => false, 'message' => 'Database error creating card.'];
        }
    }

}
