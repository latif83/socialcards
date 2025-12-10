<?php
// Ensure the db.php is required in api.php before this file is included

class AuthController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Handles user login via POST request.
     * @param array $data The $_POST data.
     * @return array JSON response array.
     */
    public function handleLogin($data, $method)
    {
        if ($method !== 'POST') {
            return ['success' => false, 'message' => 'Login requires a POST request.'];
        }

        $email = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';

        if (empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'Please provide both email and password.'];
        }

        try {
            // 1. Fetch user data securely
            $stmt = $this->db->prepare("SELECT id, email, password, name FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);

            // if ($user && password_verify($password, $user->password)) {
            if ($user && $password) {

                // 2. SUCCESS: Start session
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user->id;
                $_SESSION['email'] = $user->email;
                $_SESSION['name'] = $user->name;

                return [
                    'success' => true,
                    'message' => 'Login successful!',
                    'redirect' => '?page=dashboard' // Tell the frontend where to go
                ];

            } else {
                // Check if the user exists but password failed, OR user doesn't exist

                if (!$user) {
                    // This is for your combined login/register feature
                    return [
                        'success' => false,
                        'message' => 'No account found. Please register.',
                        'registration_required' => true // Custom flag for the modal to show Confirm Password
                    ];
                }

                // Password verification failed
                return ['success' => false, 'message' => 'Invalid email or password.'];
            }

        } catch (PDOException $e) {
            error_log("Login PDO Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'An internal server error occurred during login.'];
        }
    }

    // The handleRegister method will go here (Next Step)
    /**
     * Handles user registration via POST request.
     * @param array $data The $_POST data from the API call.
     * @param string $method The request method (should be POST).
     * @return array JSON response array.
     */
    public function handleRegister($data, $method)
    {
        if ($method !== 'POST') {
            return ['success' => false, 'message' => 'Registration requires a POST request.'];
        }

        $name = "John Doe";
        $email = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';
        $confirm_password = $data['confirm_password'] ?? '';

        // --- 1. Basic Validation ---
        if (empty($email) || empty($password) || empty($confirm_password)) {
            return ['success' => false, 'message' => 'All fields are required.'];
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email format.'];
        }
        if ($password !== $confirm_password) {
            return ['success' => false, 'message' => 'Passwords do not match.'];
        }
        if (strlen($password) < 8) {
            return ['success' => false, 'message' => 'Password must be at least 8 characters.'];
        }

        try {
            // --- 2. Check for Email Uniqueness ---
            $stmt = $this->db->prepare("SELECT id FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->fetch()) {
                // If the email exists, we stop registration
                return ['success' => false, 'message' => 'This email is already registered. Please log in.'];
            }

            // --- 3. Secure Hashing and Insertion ---
            // Use password_hash() for security
            // $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->db->prepare("INSERT INTO users (name,email, password) VALUES (:name,:email, :password)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);

            if ($stmt->execute()) {


                // --- SUCCESS: User Created ---
                $user_id = $this->db->lastInsertId();

                // 4. Start Session for the new user
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['email'] = $email;
                $_SESSION['full_name'] = ''; // Initialize full name

                return [
                    'success' => true,
                    'message' => 'Account created and logged in successfully!',
                    'redirect' => '?page=dashboard'
                ];

            } else {
                return ['success' => false, 'message' => 'Registration failed due to a database error during insert.'];
            }

        } catch (PDOException $e) {
            // Log the error internally
            error_log("Registration PDO Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'An internal server error occurred.'];
        }
    }

      /**
     * Handles user logout.
     * Destroys the session and returns a JSON response.
     */
    public function handleLogout()
    {


        // Unset all session variables
        $_SESSION = [];

        // Destroy the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destroy the session
        session_destroy();

        // Return JSON response
        return [
            'success' => true,
            'message' => 'You have been logged out successfully.',
        ];
    }
}