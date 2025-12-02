<?php
// Initialize variables to hold form data and errors
$errors = [];
$cardData = [
    'card_type' => 'personal',
    'full_name' => '',
    'title_role' => '',
    'email' => '',
    'phone' => '',
    'share_slug' => ''
    // ... add more fields
];

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // --- 1. Sanitize and Validate Input ---
    $cardData['card_type'] = $_POST['card_type'] ?? 'personal';
    $cardData['full_name'] = trim($_POST['full_name'] ?? '');
    $cardData['title_role'] = trim($_POST['title_role'] ?? '');
    $cardData['email'] = trim($_POST['email'] ?? '');
    $cardData['phone'] = trim($_POST['phone'] ?? '');
    $cardData['share_slug'] = trim($_POST['share_slug'] ?? '');
    // Sanitize the slug (e.g., lowercase, replace spaces with hyphens)
    $cardData['share_slug'] = strtolower(preg_replace('/[^a-z0-9\-]/', '', str_replace(' ', '-', $cardData['share_slug'])));
    
    if (empty($cardData['full_name'])) {
        $errors['full_name'] = "Full Name is required.";
    }
    if (empty($cardData['share_slug'])) {
        $errors['share_slug'] = "A unique share link slug is required.";
    }

    // --- 2. Handle File Upload (Placeholder) ---
    // if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    //     // Actual file processing code would go here (validation, moving file, saving path to DB)
    // }

    // --- 3. Process if no errors ---
    if (empty($errors)) {
        // --- THIS IS WHERE YOU WILL INSERT INTO SQLITE DB ---
        // For now, just a success message placeholder
        $success_message = "Card details submitted successfully! Database insertion logic goes here.";
        // Optionally redirect to the dashboard or cards list after success
        // header("Location: ?page=cards"); exit;
    }
}
?>

<div class="container mx-auto p-4 md:p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Create New Digital Card</h1>

    <?php if (!empty($success_message)): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?= htmlspecialchars($success_message) ?></span>
        </div>
    <?php elseif (!empty($errors)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="font-bold">Error!</span>
            <span class="block sm:inline">Please correct the errors below and try again.</span>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-xl">
        
        <h2 class="text-xl font-semibold text-indigo-600 mb-4 border-b pb-2">Card Type & Link Identification</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            
            <div>
                <label class="block text-gray-700 font-medium mb-2">Card Type</label>
                <div class="flex space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" class="form-radio text-indigo-600" name="card_type" value="personal" 
                            <?= $cardData['card_type'] === 'personal' ? 'checked' : '' ?>>
                        <span class="ml-2">Personal</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" class="form-radio text-indigo-600" name="card_type" value="business"
                            <?= $cardData['card_type'] === 'business' ? 'checked' : '' ?>>
                        <span class="ml-2">Business</span>
                    </label>
                </div>
            </div>

            <div>
                <label for="share_slug" class="block text-gray-700 font-medium mb-2">Unique Share Link Slug (e.g., your-name)</label>
                <div class="flex rounded-lg shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        [Your Site]/
                    </span>
                    <input type="text" id="share_slug" name="share_slug" value="<?= htmlspecialchars($cardData['share_slug']) ?>"
                        class="flex-1 block w-full rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 p-2" 
                        placeholder="my-connect-profile">
                </div>
                <?php if (isset($errors['share_slug'])): ?><p class="text-red-500 text-xs italic mt-1"><?= $errors['share_slug'] ?></p><?php endif; ?>
            </div>
            
        </div>

        <h2 class="text-xl font-semibold text-indigo-600 mb-4 border-b pb-2 mt-8">Primary Contact & Identity</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            
            <div>
                <label for="full_name" class="block text-gray-700 font-medium mb-2">Full Name / Company Name <span class="text-red-500">*</span></label>
                <input type="text" id="full_name" name="full_name" value="<?= htmlspecialchars($cardData['full_name']) ?>"
                    class="w-full border border-gray-300 p-2 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" 
                    placeholder="John Doe">
                <?php if (isset($errors['full_name'])): ?><p class="text-red-500 text-xs italic mt-1"><?= $errors['full_name'] ?></p><?php endif; ?>
            </div>

            <div>
                <label for="title_role" class="block text-gray-700 font-medium mb-2">Title or Role</label>
                <input type="text" id="title_role" name="title_role" value="<?= htmlspecialchars($cardData['title_role']) ?>"
                    class="w-full border border-gray-300 p-2 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" 
                    placeholder="Web Developer / CEO">
            </div>

            <div>
                <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($cardData['email']) ?>"
                    class="w-full border border-gray-300 p-2 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" 
                    placeholder="contact@example.com">
            </div>

            <div>
                <label for="phone" class="block text-gray-700 font-medium mb-2">Phone Number</label>
                <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($cardData['phone']) ?>"
                    class="w-full border border-gray-300 p-2 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" 
                    placeholder="+1 (555) 123-4567">
            </div>
        </div>

        <h2 class="text-xl font-semibold text-indigo-600 mb-4 border-b pb-2 mt-8">Image Upload</h2>
        <div class="mb-6">
            <label for="profile_image" class="block text-gray-700 font-medium mb-2">Profile Picture / Logo</label>
            <input type="file" id="profile_image" name="profile_image"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            <p class="mt-2 text-xs text-gray-500">JPG or PNG only (Max 2MB).</p>
        </div>

        <h2 class="text-xl font-semibold text-indigo-600 mb-4 border-b pb-2 mt-8">Social Media & Links (Optional)</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
             <?php 
                $socials = ['website' => 'Website URL', 'linkedin' => 'LinkedIn Profile URL', 'twitter' => 'Twitter/X Handle', 'instagram' => 'Instagram Handle'];
                foreach ($socials as $key => $label): 
             ?>
                <div>
                    <label for="<?= $key ?>" class="block text-gray-700 font-medium mb-2"><?= $label ?></label>
                    <input type="url" id="<?= $key ?>" name="social_links[<?= $key ?>]" 
                        class="w-full border border-gray-300 p-2 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" 
                        placeholder="https://">
                </div>
             <?php endforeach; ?>
        </div>

        <div class="pt-4 border-t mt-4">
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-200 flex items-center justify-center">
                <i class="fas fa-save mr-2"></i> Save and Publish Card
            </button>
        </div>
    </form>
</div>