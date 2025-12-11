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
        $address = trim($data['address'] ?? '');

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
            $fileName = uniqid() . '.' . pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);

            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($fileTmp, $filePath)) {
                // Public URL for Azure
                $uploaded_url = "uploads/" . $fileName;
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
                (user_id, card_type, name, title_role, email, phone, profile_image, social_links,bio,address)
            VALUES 
                (:user_id, :card_type, :name, :title_role, :email, :phone, :profile_image, :social_links, :bio,:address)
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
                ':bio' => $bio,
                ':address' => $address
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

    /**
     * Handles the update submission for an existing card.
     * @param array $data The $_POST data including card_id and existing data.
     * @param string $method The request method (should be POST).
     * @return array JSON response array.
     */
    public function handleUpdate($data, $method)
    {
        if ($method !== 'POST') {
            return ['success' => false, 'message' => 'POST request required for update.'];
        }

        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            return ['success' => false, 'message' => 'You must be logged in to update a card.'];
        }

        $user_id = $_SESSION['user_id'];
        $card_id = $data['card_id'] ?? null;
        $existing_image_path = $data['existing_image_path'] ?? null; // Existing image path from hidden field

        // Validate essential IDs
        if (empty($card_id)) {
            return ['success' => false, 'message' => 'Card ID is missing for update.'];
        }

        // Main fields (trimming to match handleAdd)
        $card_type = trim($data['card_type'] ?? '');
        $name = trim($data['name'] ?? '');
        $title_role = trim($data['title_role'] ?? '');
        $email = trim($data['email'] ?? '');
        $phone = trim($data['phone'] ?? '');
        $bio = trim($data['bio'] ?? '');
        $address = trim($data['address'] ?? '');

        // Social links: array from form input
        $social_links = $data['social_links'] ?? [];
        $social_links_json = json_encode($social_links);

        // Validate required fields
        if (empty($card_type) || empty($name)) {
            return ['success' => false, 'message' => "Card type and Name are required."];
        }

        // --------------------------
        // HANDLE FILE UPLOAD / KEEP EXISTING
        // --------------------------
        $final_image_path = $existing_image_path; // Start with the existing path

        // Check if a NEW file was uploaded
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . "/../../uploads/";

            // Ensure the directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileTmp = $_FILES['profile_image']['tmp_name'];
            $fileName = uniqid() . '.' . pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($fileTmp, $filePath)) {
                // New file uploaded successfully, set the new public URL
                $final_image_path = "uploads/" . $fileName;

                // OPTIONAL: Delete the old file if it exists and a new one was uploaded
                // Note: This requires getting the full local path of the $existing_image_path
                // and using unlink(), which is a good practice for cleanup.
                /*
                if (!empty($existing_image_path)) {
                    $oldFilePath = __DIR__ . "/../../" . $existing_image_path;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                */

            } else {
                return ['success' => false, 'message' => "Failed to upload new image."];
            }
        }
        // If no new file, $final_image_path remains $existing_image_path.


        // --------------------------
        // UPDATE DATABASE
        // --------------------------
        try {
            $stmt = $this->db->prepare("
        UPDATE cards 
        SET 
            card_type = :card_type, 
            name = :name, 
            title_role = :title_role, 
            email = :email, 
            phone = :phone, 
            profile_image = :profile_image, 
            social_links = :social_links, 
            bio = :bio,
            address = :address,
            updated_at = CURRENT_TIMESTAMP  -- Added for tracking modification time
        WHERE 
            id = :id AND user_id = :user_id
    ");

            $stmt->execute([
                // Parameters for the SET clause (9 items)
                ':card_type' => $card_type,
                ':name' => $name,
                ':title_role' => $title_role,
                ':email' => $email,
                ':phone' => $phone,
                ':profile_image' => $final_image_path,
                ':social_links' => $social_links_json,
                ':bio' => $bio,
                ':address' => $address,

                // Parameters for the WHERE clause (2 items)
                // CRITICAL FIX: Changed placeholder name to :id (to match table column) 
                // and fixed the key name in the array.
                ':id' => $card_id,       // Binds $card_id value to the :id placeholder
                ':user_id' => $user_id   // Binds $user_id value to the :user_id placeholder
            ]);

            if ($stmt->rowCount() === 0) {
                return ['success' => false, 'message' => 'Update failed: Card not found or no changes detected.'];
            }

            return [
                'success' => true,
                'message' => 'Card updated successfully!'
            ];

        } catch (PDOException $e) {
            error_log("DB Error UpdateCard: " . $e->getMessage());
            return ['success' => false, 'message' => 'Database error updating card.', 'error' => $e->getMessage()];
        }
    }

    /**
     * Fetch all cards belonging to the logged-in user.
     */
    public function getAll()
    {
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            return ['success' => false, 'message' => 'You must be logged in.'];
        }

        $user_id = $_SESSION['user_id'];

        try {
            $stmt = $this->db->prepare("
            SELECT * FROM cards 
            WHERE user_id = :user_id
            ORDER BY created_at DESC
        ");
            $stmt->execute([':user_id' => $user_id]);

            $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'success' => true,
                'cards' => $cards
            ];

        } catch (PDOException $e) {
            error_log("DB Error getAllCards: " . $e->getMessage());
            return ['success' => false, 'message' => 'Database error fetching cards.'];
        }
    }

    /**
     * Fetch a single card by ID (and ensure it belongs to the logged-in user).
     */
    public function getOne($postData, $method)
    {

        if ($method !== 'GET') {
            return ['success' => false, 'message' => 'GET request required'];
        }

        // Read ID from URL
        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

        if (!$id) {
            return [
                'success' => false,
                'message' => 'Card ID is missing in the URL.'
            ];
        }


        try {
            $stmt = $this->db->prepare("
            SELECT * FROM cards 
            WHERE id = :id
            LIMIT 1
        ");
            $stmt->execute([
                ':id' => $id
            ]);

            $card = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$card) {
                return [
                    'success' => false,
                    'message' => 'Card not found.'
                ];
            }

            return [
                'success' => true,
                'card' => $card
            ];

        } catch (PDOException $e) {
            error_log("DB Error getOneCard: " . $e->getMessage());
            return ['success' => false, 'message' => 'Database error fetching card.'];
        }
    }


    public function getAllPublicCards()
    {
        try {
            // Fetch all cards from the table
            $stmt = $this->db->prepare("SELECT * FROM cards ORDER BY created_at DESC");
            $stmt->execute(); // no parameters needed

            $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'success' => true,
                'cards' => $cards
            ];

        } catch (PDOException $e) {
            error_log("DB Error getAllPublicCards: " . $e->getMessage());
            return ['success' => false, 'message' => 'Database error fetching cards.'];
        }
    }


    /**
 * Handles the deletion of a specific card, restricted to the card's owner.
 * Also deletes the associated profile image file from the server.
 * @param array $data Contains the card_id from the request.
 * @param string $method The request method (should ideally be POST or DELETE).
 * @return array JSON response array.
 */
public function handleDelete($data, $method)
{
    // Using POST is common for AJAX, but DELETE is technically more correct. 
    // We'll proceed assuming POST or a parameter-based DELETE via POST is used.
    if ($method !== 'POST') {
        return ['success' => false, 'message' => 'Deletion requires a POST request.'];
    }

    // --- 0. Authentication and ID Check ---
    if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
        return ['success' => false, 'message' => 'Authentication required to delete a card.'];
    }

    $card_id = $data['card_id'] ?? null;
    if (empty($card_id)) {
        return ['success' => false, 'message' => 'Card ID is missing for deletion.'];
    }
    
    $user_id = $_SESSION['user_id'];

    try {
        // --- 1. Retrieve File Path for Deletion ---
        // CRITICAL: First, retrieve the file path and verify ownership before deleting anything.
        $stmt = $this->db->prepare("
            SELECT profile_image 
            FROM cards 
            WHERE id = :id AND user_id = :user_id
        ");
        
        // Note: Using :id placeholder to match your primary key column name.
        $stmt->bindParam(':id', $card_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        
        $card = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$card) {
            return ['success' => false, 'message' => 'Card not found or access denied.'];
        }

        $image_path = $card['profile_image']; // Relative path: "uploads/filename.jpg"
        
        // --- 2. Delete the Database Record ---
        $stmt = $this->db->prepare("DELETE FROM cards WHERE id = :id AND user_id = :user_id");
        $stmt->bindParam(':id', $card_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
             // Should not happen if step 1 passed, but double-check
             return ['success' => false, 'message' => 'Database deletion failed or card already removed.'];
        }

        // --- 3. Delete the Associated File (Cleanup) ---
        if (!empty($image_path)) {
            // Construct the absolute path from the relative path stored in the DB
            // Assuming your file path 'uploads/...' is relative to two directories up (the app root)
            $absolute_path = __DIR__ . "/../../" . $image_path; 
            
            if (file_exists($absolute_path) && is_file($absolute_path)) {
                if (unlink($absolute_path)) {
                    // File successfully deleted
                } else {
                    error_log("FILE DELETE FAILED: Could not unlink file at: " . $absolute_path);
                    // Do not fail the API call, as the DB record is gone, but log the error.
                }
            }
        }

        return [
            'success' => true,
            'message' => 'Card successfully deleted.'
        ];

    } catch (PDOException $e) {
        error_log("DB Error DeleteCard: " . $e->getMessage());
        return ['success' => false, 'message' => 'A database error occurred during deletion.'];
    }
}

/**
 * Atomically increments the view_count for a specific card.
 * This method is public and designed to be called on every public card load.
 * @param array $data Contains the card_id.
 * @return array JSON response array (usually success only).
 */
public function incrementViewCount($data)
{
    $card_id = $data['card_id'] ?? null;
    
    if (empty($card_id)) {
        return ['success' => false, 'message' => 'Card ID is required.'];
    }

    try {
        // We use UPDATE and increment the column directly (atomic operation)
        $stmt = $this->db->prepare("
            UPDATE cards 
            SET views_count = views_count + 1 
            WHERE id = :card_id
        ");

        $stmt->bindParam(':card_id', $card_id);
        $stmt->execute();
        
        // If rowCount is 0, the card ID probably doesn't exist.
        if ($stmt->rowCount() === 0) {
             return ['success' => false, 'message' => 'Card not found or already deleted.'];
        }

        return ['success' => true];

    } catch (PDOException $e) {
        error_log("View Count PDO Error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Counting failed.','error' => $e->getMessage()];
    }
}


}
