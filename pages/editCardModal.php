<?php
// Initialize variables to hold form data and errors
$errors = [];
$loading = false;

// CRITICAL: Get the card ID from the URL
$card_id = $_GET['id'] ?? null; 
// We will use this ID to fetch the data and to send back in the update payload.
?>

<div id="editCardModal" class="fixed top-0 left-0 w-full h-svh bg-black/30 backdrop-blur-[2px] pt-12 hidden">

    <div class="max-w-6xl bg-white h-full w-full mx-auto rounded-t-lg sm:p-6 p-3 overflow-y-auto">

        <div class="flex items-center justify-between">
            <span class="text-lg font-medium">Edit Card</span>
            <button onClick="closeEditModal()" type="button"
                class="w-6 h-6 hover:bg-red-600 hover:text-white text-red-600 rounded-full p-4 flex items-center justify-center block">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>


<div>

    <div id="statusMessage" class="alert fixed top-5 right-5 hidden"></div>

    <form id="editCardForm" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg mt-8">
        
        <input type="hidden" id="card_id" name="card_id">
        <input type="hidden" id="existing_image_path" name="existing_image_path">
        
        <div id="initialLoader" class="text-center py-20">
            <svg class="animate-spin h-8 w-8 text-indigo-500 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <p class="mt-4 text-gray-600">Loading card data...</p>
        </div>

        <div id="formContent" class="hidden">
            <h2 class="text-xl font-semibold text-indigo-600 mb-4 border-b pb-2">Card Type & Link Identification</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Card Type</label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio text-indigo-600" name="card_type" value="personal"
                                id="type_personal" required>
                            <span class="ml-2">Personal</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio text-indigo-600" name="card_type" value="business"
                                id="type_business" required>
                            <span class="ml-2">Business</span>
                        </label>
                    </div>
                </div>

            </div>

            <h2 class="text-xl font-semibold text-indigo-600 mb-4 border-b pb-2 mt-8">Primary Contact & Identity</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                <div>
                    <label for="full_name" class="block text-gray-700 font-medium mb-2">Full Name / Company Name <span
                                class="text-red-500">*</span></label>
                    <input type="text" id="full_name" name="name"
                        class="w-full border border-gray-300 p-2 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        required placeholder="John Doe">
                    <?php if (isset($errors['full_name'])): ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $errors['full_name'] ?></p><?php endif; ?>
                </div>
                
                <div>
                    <label for="title_role" class="block text-gray-700 font-medium mb-2">Title or Role</label>
                    <input type="text" id="title_role" name="title_role"
                        class="w-full border border-gray-300 p-2 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Web Developer / CEO">
                </div>

                <div>
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                    <input type="email" id="email" name="email"
                        class="w-full border border-gray-300 p-2 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        required placeholder="contact@example.com">
                </div>

                <div>
                    <label for="phone" class="block text-gray-700 font-medium mb-2">Phone Number</label>
                    <input type="tel" id="phone" name="phone"
                        class="w-full border border-gray-300 p-2 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        required placeholder="+1 (555) 123-4567">
                </div>
                
                <div>
                    <label for="address" class="block text-gray-700 font-medium mb-2">Address / location</label>
                    <input type="text" id="address" name="address"
                        class="w-full border border-gray-300 p-2 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Enter Address">
                </div>

                <div>
                    <label for="bio" class="block text-gray-700 font-medium mb-2">Bio:</label>
                    <input type="text" id="bio" name="bio"
                        class="w-full border border-gray-300 p-2 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="A little info about what you do...">
                </div>
            </div>

            <h2 class="text-xl font-semibold text-indigo-600 mb-4 border-b pb-2 mt-8">Image Upload</h2>
            <div class="mb-6 flex items-center gap-4">
                <div id="currentImagePreview" class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center overflow-hidden border border-gray-300">
                    <i class="fas fa-user-circle text-4xl text-gray-400"></i>
                </div>
                <div>
                    <label for="profile_image" class="block text-gray-700 font-medium mb-2">New Profile Picture / Logo (Optional)</label>
                    <input type="file" id="profile_image" name="profile_image"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                        /> <p class="mt-2 text-xs text-gray-500">Leave blank to keep existing image. JPG or PNG only (Max 2MB).</p>
                </div>
            </div>

            <h2 class="text-xl font-semibold text-indigo-600 mb-4 border-b pb-2 mt-8">Social Media & Links (Optional)</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <?php
                $socials = ['website' => 'Website URL', 'linkedin' => 'LinkedIn Profile URL', 'twitter' => 'Twitter/X Handle', 'instagram' => 'Instagram Handle'];
                foreach ($socials as $key => $label):
                    ?>
                    <div>
                        <label for="<?= $key ?>" class="block text-gray-700 font-medium mb-2"><?= $label ?></label>
                        <input type="text" id="<?= $key ?>" name="social_links[<?= $key ?>]"
                            class="w-full border border-gray-300 p-2 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="https://">
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="pt-4 border-t mt-4">
                <button type="submit" id="submitBtn"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-200 flex items-center justify-center gap-2">
                    <svg id="spinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span class="btn-text">Update Card</span>
                </button>
            </div>
        </div>
    </form>
</div>

</div>
</div>

<script>

      function closeEditModal() {
        const editCardModal = document.getElementById('editCardModal')
        editCardModal.classList.add("hidden")
    }

    const form = document.getElementById("editCardForm");
    const cardIdInput = document.getElementById('card_id');
    const existingImagePathInput = document.getElementById('existing_image_path');
    const initialLoader = document.getElementById('initialLoader');
    const formContent = document.getElementById('formContent');
    const statusMessage = document.getElementById('statusMessage');

    const BASE_API_PATH = "api.php"; // Adjust if your api.php is in a different location relative to this page

    // --- Loading and Message Helpers (Adjusted for Edit Page) ---
    function displayStatus(message, isSuccess = false) {
        statusMessage.classList.remove("hidden", "bg-red-100", "bg-green-100", "border-red-400", "border-green-400", "text-red-700", "text-green-700");
        statusMessage.className = `alert fixed top-5 right-5 px-4 py-3 rounded mb-4 ${isSuccess ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700'}`;
        statusMessage.innerHTML = `<span>${message}</span>`;
        statusMessage.classList.remove("hidden");
        setTimeout(() => statusMessage.classList.add("hidden"), 5000);
    }

    function startLoading(isInitial = false) {
        if (isInitial) {
            initialLoader.classList.remove('hidden');
            formContent.classList.add('hidden');
        } else {
            const btn = document.getElementById("submitBtn");
            const textSpan = btn.querySelector(".btn-text");
            const spinner = document.getElementById("spinner");

            btn.disabled = true;
            btn.classList.add("opacity-70", "cursor-not-allowed");
            spinner.classList.remove("hidden");
            textSpan.textContent = "Updating...";
        }
    }

    function stopLoading(isInitial = false) {
         if (isInitial) {
            initialLoader.classList.add('hidden');
            formContent.classList.remove('hidden');
        } else {
            const btn = document.getElementById("submitBtn");
            const textSpan = btn.querySelector(".btn-text");
            const spinner = document.getElementById("spinner");
            
            setTimeout(() => {
                btn.disabled = false;
                btn.classList.remove("opacity-70", "cursor-not-allowed");
                spinner.classList.add("hidden");
                textSpan.textContent = "Update Card";
            }, 500); // Shorter timeout for update completion
        }
    }
    
    // --- Data Population Function ---
    function populateForm(card) {
        // Primary Fields
        document.getElementById('full_name').value = card.name || '';
        document.getElementById('title_role').value = card.title_role || '';
        document.getElementById('email').value = card.email || '';
        document.getElementById('phone').value = card.phone || '';
        document.getElementById('address').value = card.address || ''; // Assuming 'address' is in your DB
        document.getElementById('bio').value = card.bio || ''; // Assuming 'bio' is in your DB
        document.getElementById('card_id').value = card.id

        // Card Type Radio Buttons
        if (card.card_type) {
            const cardTypeRadio = document.querySelector(`input[name="card_type"][value="${card.card_type}"]`);
            if (cardTypeRadio) {
                cardTypeRadio.checked = true;
            }
        }
        
        // Existing Image Preview
        if (card.profile_image) {
            const previewContainer = document.getElementById('currentImagePreview');
            previewContainer.innerHTML = `<img src="${card.profile_image}" alt="Current Profile Image" class="w-full h-full object-cover">`;
            // Store existing path in hidden field for API to handle update logic
            existingImagePathInput.value = card.profile_image; 
        }

        // Social Links
        if (card.social_links) {
            const socialLinks = JSON.parse(card.social_links)
            for (const key in socialLinks) {
                const input = document.getElementById(key);
                if (input && socialLinks[key]) {
                    input.value = socialLinks[key];
                }
            }
        }
    }
    
    // --- Fetch Card Data on Page Load ---
    async function fetchCardData(cardId) {
        
        if (!cardId) {
            displayStatus("Error: No Card ID specified in the URL.", false);
            return;
        }

        startLoading(true);

        try {
            const response = await fetch(`api/api.php?route=getCard&id=${cardId}`);
            const result = await response.json();

            if (result.success) {
                populateForm(result.card);
            } else {
                displayStatus(result.message, false);
            }

        } catch (err) {
            console.error("Error fetching card details:", err);
            displayStatus("Failed to load card details due to a network error.", false);
        } finally {
            stopLoading(true);
        }
    }

    // --- Form Submission Handler (Update) ---
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        
        // Ensure the existing image path is included even if no new file is uploaded
        if (!formData.has('profile_image') && existingImagePathInput.value) {
             formData.append('existing_image_path', existingImagePathInput.value);
        }

        startLoading(false);

        try {
            // CRITICAL: Call the UPDATE endpoint
            const response = await fetch(`api/api.php?route=updateCard`, {
                method: "POST",
                body: formData // Sends both form data and file
            });

            const result = await response.json();
            
            if (result.success) {
                displayStatus(result.message, true);
                // Redirect user back to the card list after a short delay
                setTimeout(() => {
                   location.replace('dashboard.php?page=cards');
                }, 1500); 
            } else {
                displayStatus(result.message, false);
            }

        } catch (err) {
            console.error("Error submitting update form:", err);
            displayStatus("Unexpected error occurred during update.", false);
        } finally {
            stopLoading(false);
        }
    });
</script>