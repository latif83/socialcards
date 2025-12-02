<?php
// Include the database connection (assuming db.php defines $db PDO object)
// require_once __DIR__ . '/../db.php'; 

// --- Placeholder for User Context ---
// In a real app, get this from the session.
$user_id = 1; 

// --- Placeholder for Fetched Data ---
// In the final version, this data would be fetched from the 'users' table.
$userData = [
    'username' => 'john_doe_connect',
    'full_name' => 'John Doe', // Assuming you store this in 'users' or 'cards'
    'email' => 'john@connect.com',
    'phone' => '+1 (555) 123-4567' 
];

$message = '';
$error = '';

// --- PHP Processing Logic (Simplified) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'update_profile') {
        // --- 1. Update Profile Logic ---
        $new_name = trim($_POST['full_name'] ?? '');
        $new_phone = trim($_POST['phone'] ?? '');

        if (empty($new_name)) {
            $error = "Full Name cannot be empty.";
        } else {
            // --- SQLITE UPDATE LOGIC HERE ---
            /*
            $stmt = $db->prepare("UPDATE users SET full_name = ?, phone = ? WHERE user_id = ?");
            if ($stmt->execute([$new_name, $new_phone, $user_id])) {
                $message = "Profile details updated successfully!";
                // Update local array to reflect changes
                $userData['full_name'] = $new_name;
                $userData['phone'] = $new_phone;
            } else {
                $error = "Failed to update profile.";
            }
            */
            $message = "Profile update simulated successfully!"; // Placeholder
            $userData['full_name'] = $new_name;
            $userData['phone'] = $new_phone;
        }
    } 
    
    elseif ($action === 'change_password') {
        // --- 2. Change Password Logic ---
        $current_pass = $_POST['current_password'] ?? '';
        $new_pass = $_POST['new_password'] ?? '';
        $confirm_pass = $_POST['confirm_password'] ?? '';

        if (empty($current_pass) || empty($new_pass) || empty($confirm_pass)) {
            $error = "All password fields are required.";
        } elseif ($new_pass !== $confirm_pass) {
            $error = "New password and confirmation do not match.";
        } else {
            // --- SECURITY CHECK ---
            // 1. Fetch stored hashed password from DB using $user_id
            // 2. Use password_verify($current_pass, $hashed_password) to check authenticity

            // --- SQLITE UPDATE LOGIC HERE ---
            /*
            $hashed_new_pass = password_hash($new_pass, PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE users SET password_hash = ? WHERE user_id = ?");
            if ($stmt->execute([$hashed_new_pass, $user_id])) {
                $message = "Password updated successfully!";
            } else {
                $error = "Failed to update password.";
            }
            */
            $message = "Password change simulated successfully!"; // Placeholder
        }
    }

    // Note: Logout and Delete Account are usually handled by separate scripts/pages
}

// Logic for Logout (usually needs redirection)
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    // session_start();
    // session_unset();
    // session_destroy();
    // header("Location: login.php"); exit;
}
?>

<div class="container mx-auto p-4 md:p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">⚙️ Account Settings</h1>

    <?php if ($message): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            
            <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-indigo-500">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Personal Details</h2>
                <form method="POST" action="?page=account" class="space-y-4">
                    <input type="hidden" name="action" value="update_profile">

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Username (Login ID)</label>
                        <input type="text" value="<?= htmlspecialchars($userData['username']) ?>" readonly
                            class="w-full border border-gray-200 p-2 rounded-lg bg-gray-100 cursor-not-allowed">
                        <p class="text-xs text-gray-500 mt-1">This cannot be changed.</p>
                    </div>

                    <div>
                        <label for="full_name" class="block text-gray-700 font-medium mb-1">Full Name</label>
                        <input type="text" id="full_name" name="full_name" value="<?= htmlspecialchars($userData['full_name']) ?>"
                            class="w-full border border-gray-300 p-2 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-gray-700 font-medium mb-1">Phone Number</label>
                        <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($userData['phone']) ?>"
                            class="w-full border border-gray-300 p-2 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-teal-500">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Change Password</h2>
                <form method="POST" action="?page=account" class="space-y-4">
                    <input type="hidden" name="action" value="change_password">
                    
                    <div>
                        <label for="current_password" class="block text-gray-700 font-medium mb-1">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required
                            class="w-full border border-gray-300 p-2 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                    </div>

                    <div>
                        <label for="new_password" class="block text-gray-700 font-medium mb-1">New Password</label>
                        <input type="password" id="new_password" name="new_password" required
                            class="w-full border border-gray-300 p-2 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                    </div>
                    
                    <div>
                        <label for="confirm_password" class="block text-gray-700 font-medium mb-1">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required
                            class="w-full border border-gray-300 p-2 rounded-lg focus:ring-teal-500 focus:border-teal-500">
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-gray-500">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Account Actions</h2>
                
                <div class="mb-4">
                    <p class="text-gray-600 mb-2">Ready to take a break?</p>
                    <a href="?page=account&action=logout" 
                       class="w-full flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-sign-out-alt mr-2"></i> Log Out
                    </a>
                </div>

                <div class="pt-4 border-t border-red-200">
                    <h3 class="text-lg font-semibold text-red-600 mb-2">Danger Zone</h3>
                    <p class="text-sm text-gray-600 mb-3">Permanently delete your Connect account and all associated cards.</p>
                    
                    <button onclick="confirmAccountDeletion()" 
                            class="w-full flex items-center justify-center bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmAccountDeletion() {
        if (confirm("WARNING: Are you absolutely sure you want to delete your entire account? This action is irreversible and all your digital cards will be permanently lost.")) {
            // In the final version, you should submit a form or redirect to a secure handler script
            // Example: window.location.href = 'delete_handler.php';
            alert("Account Deletion simulated. You would need to implement the secure PHP/SQLite logic for this.");
        }
    }
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">