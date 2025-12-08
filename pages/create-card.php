<?php
// Initialize variables to hold form data and errors
$errors = [];


?>

<div class="container mx-auto p-4 md:p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Create New Digital Card</h1>

    <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-xl">
        
        <h2 class="text-xl font-semibold text-indigo-600 mb-4 border-b pb-2">Card Type & Link Identification</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            
            <div>
                <label class="block text-gray-700 font-medium mb-2">Card Type</label>
                <div class="flex space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" class="form-radio text-indigo-600" name="card_type" value="personal">
                        <span class="ml-2">Personal</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" class="form-radio text-indigo-600" name="card_type" value="business">
                        <span class="ml-2">Business</span>
                    </label>
                </div>
            </div>

            
        </div>

        <h2 class="text-xl font-semibold text-indigo-600 mb-4 border-b pb-2 mt-8">Primary Contact & Identity</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            
            <div>
                <label for="full_name" class="block text-gray-700 font-medium mb-2">Full Name / Company Name <span class="text-red-500">*</span></label>
                <input type="text" id="full_name" name="name" class="w-full border border-gray-300 p-2 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" 
                    placeholder="John Doe">
                <?php if (isset($errors['full_name'])): ?><p class="text-red-500 text-xs italic mt-1"><?= $errors['full_name'] ?></p><?php endif; ?>
            </div>

            <div>
                <label for="title_role" class="block text-gray-700 font-medium mb-2">Title or Role</label>
                <input type="text" id="title_role" name="title_role" class="w-full border border-gray-300 p-2 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" 
                    placeholder="Web Developer / CEO">
            </div>

            <div>
                <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                <input type="email" id="email" name="email" class="w-full border border-gray-300 p-2 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" 
                    placeholder="contact@example.com">
            </div>

            <div>
                <label for="phone" class="block text-gray-700 font-medium mb-2">Phone Number</label>
                <input type="tel" id="phone" name="phone" class="w-full border border-gray-300 p-2 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" 
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

<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");
    
    form.addEventListener("submit", async (e) => {
        e.preventDefault(); // Prevent page reload

        const formData = new FormData(form); // Automatically includes file uploads

        try {
            const response = await fetch("api/api.php?route=addCard", {
                method: "POST",
                body: formData
            });

            const result = await response.json();

            // Clear any previous messages
            document.querySelectorAll(".alert").forEach(el => el.remove());

            if (result.success) {
                // Show success message
                const msgDiv = document.createElement("div");
                msgDiv.className = "alert bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4";
                msgDiv.innerHTML = `<span>${result.message}</span>`;
                form.prepend(msgDiv);

                // Optionally reset the form
                form.reset();

            } else {
                // Show error message
                const msgDiv = document.createElement("div");
                msgDiv.className = "alert bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4";
                msgDiv.innerHTML = `<span>${result.message}</span>`;
                form.prepend(msgDiv);
            }

        } catch (err) {
            console.error("Error submitting form:", err);
            const msgDiv = document.createElement("div");
            msgDiv.className = "alert bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4";
            msgDiv.innerHTML = `<span>Unexpected error occurred.</span>`;
            form.prepend(msgDiv);
        }
    });
});
</script>
