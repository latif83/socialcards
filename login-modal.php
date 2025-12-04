<?php
// PHP logic will go here to handle the form submission later
// For now, we focus on the modal structure and JavaScript interaction.
$login_message = ''; // For displaying success/error messages after submission
?>

<div id="authModal"
    class="fixed inset-0 z-50 hidden overflow-y-auto transition-opacity duration-300 ease-in-out backdrop-blur"
    aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 py-8">

        <div
            class="w-full max-w-xl transform overflow-hidden rounded-xl bg-white p-6 text-left align-middle shadow-2xl transition-all">

            <button onclick="toggleModal(false)" type="button"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 focus:outline-none">
                <i class="fas fa-times text-xl"></i>
            </button>

            <div id="messageContainer" class="hidden p-3 rounded-lg text-center font-medium mb-4"></div>

            <div id="loadingSpinner" class="hidden text-center mb-4">
                <i class="fas fa-spinner fa-spin text-3xl text-indigo-600"></i>
                <p class="text-sm text-gray-500 mt-2">Processing...</p>
            </div>

            <h3 id="modal-title" class="text-2xl font-bold leading-6 text-gray-900 mb-6 text-center">
                <span id="formTitle">Log In to Connect</span>
            </h3>

            <form method="POST" action="login_handler.php" id="authForm" class="space-y-5">

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" id="email" name="email" required autocomplete="email"
                        class="mt-1 w-full rounded-md border border-gray-300 p-3 focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="you@example.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password"
                        class="mt-1 w-full rounded-md border border-gray-300 p-3 focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="••••••••">
                </div>

                <div id="confirmPasswordGroup" class="hidden">
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm
                        Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" autocomplete="new-password"
                        class="mt-1 w-full rounded-md border border-gray-300 p-3 focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="••••••••">
                </div>

                <button type="submit" id="submitButton"
                    class="w-full rounded-md bg-indigo-600 py-3 text-white font-semibold hover:bg-indigo-700 transition duration-150 shadow-md">
                    Log In
                </button>
            </form>

            <div class="mt-6 text-center text-sm">
                <p id="toggleText">
                    Don't have an account?
                    <a href="#" onclick="event.preventDefault(); toggleRegistration(true)"
                        class="font-medium text-indigo-600 hover:text-indigo-500">
                        Create one now.
                    </a>
                </p>
            </div>

        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
    const modal = document.getElementById('authModal');
    const form = document.getElementById('authForm');
    const submitButton = document.getElementById('submitButton');
    const confirmPasswordGroup = document.getElementById('confirmPasswordGroup');
    const formTitle = document.getElementById('formTitle');
    const toggleText = document.getElementById('toggleText');
    const messageContainer = document.getElementById('messageContainer'); // New
    const loadingSpinner = document.getElementById('loadingSpinner');     // New
    let isRegisterMode = false;

    // Helper function to display messages
    function displayMessage(message, isError = false) {
        messageContainer.classList.remove('hidden', 'bg-red-100', 'bg-green-100', 'text-red-700', 'text-green-700');
        messageContainer.textContent = message;

        if (isError) {
            messageContainer.classList.add('bg-red-100', 'text-red-700');
        } else {
            messageContainer.classList.add('bg-green-100', 'text-green-700');
        }
        // Auto-hide message after a few seconds
        setTimeout(() => messageContainer.classList.add('hidden'), 5000);
    }

    // Helper function to toggle loading state
    function setLoading(isLoading) {
        if (isLoading) {
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            loadingSpinner.classList.remove('hidden');
            messageContainer.classList.add('hidden'); // Hide any previous message
        } else {
            submitButton.disabled = false;
            submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
            loadingSpinner.classList.add('hidden');
        }
    }

    // 1. Show/Hide Modal (Same as before)
    function toggleModal(show) {
        if (show) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
            toggleRegistration(false);
        }
        // Reset state when modal is opened/closed
        setLoading(false);
        messageContainer.classList.add('hidden');
    }

    // 2. Toggle Login/Registration Mode (Same as before)
    function toggleRegistration(isRegister) {
        isRegisterMode = isRegister;
        const confirmPassInput = document.getElementById('confirm_password');

        // Reset message container when switching modes
        messageContainer.classList.add('hidden');

        if (isRegister) {
            confirmPasswordGroup.classList.remove('hidden');
            confirmPassInput.setAttribute('required', 'required');
            formTitle.textContent = 'Create Your Connect Account';
            submitButton.textContent = 'Sign Up';

            toggleText.innerHTML = `Already have an account? <a href="#" onclick="event.preventDefault(); toggleRegistration(false)" class="font-medium text-indigo-600 hover:text-indigo-500">Log In here.</a>`;
        } else {
            confirmPasswordGroup.classList.add('hidden');
            confirmPassInput.removeAttribute('required');
            formTitle.textContent = 'Log In to Connect';
            submitButton.textContent = 'Log In';

            toggleText.innerHTML = `Don't have an account? <a href="#" onclick="event.preventDefault(); toggleRegistration(true)" class="font-medium text-indigo-600 hover:text-indigo-500">Create one now.</a>`;
        }
    }

    // --- 3. Asynchronous Form Submission (NEW LOGIC) ---
    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        // Client-Side Password Match Check for Registration
        if (isRegisterMode) {
            const pass = document.getElementById('password').value;
            const confirmPass = document.getElementById('confirm_password').value;
            if (pass !== confirmPass) {
                displayMessage('Error: Passwords do not match.', true);
                return;
            }
        }

        setLoading(true); // Show spinner and disable button

        const formData = new FormData(form);
        // Use your API router file and the correct route
        const route = isRegisterMode ? 'register' : 'login';
        const url = `api/api.php?route=${route}`;

        try {
            const response = await fetch(url, {
                method: 'POST',
                // For a standard POST API, using URLSearchParams is often cleaner than FormData
                body: new URLSearchParams(formData)
            });

            if (!response.ok) {
                throw new Error('Server returned an error status.');
            }

            const data = await response.json();

            if (data.success) {
                // SUCCESS: Redirect the user to their dashboard
                displayMessage(data.message + " Redirecting...", false);
                setTimeout(() => {
                    window.location.href = 'dashboard.php';
                }, 1000);

            } else {
                // FAILURE: Handle error messages from the API
                displayMessage(data.message, true);

                // --- Custom Combined Flow Handling ---
                if (route === 'login' && data.registration_required) {
                    // If login failed because the account doesn't exist, prompt registration
                    displayMessage("No account found. Please confirm your password to register.", false);
                    toggleRegistration(true);
                }
            }

        } catch (error) {
            displayMessage('A network error occurred: Could not reach the server.', true);
            console.error('Fetch error:', error);
        } finally {
            setLoading(false); // Hide spinner and re-enable button
        }
    });

    // 4. Modal Backdrop Close (Same as before)
    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            toggleModal(false);
        }
    });

    // Handle initial potential errors passed from a PHP redirect (optional: for non-JS fallbacks)
    <?php if (isset($login_message) && !empty($login_message)): ?>
        toggleModal(true);
        displayMessage("<?= addslashes($login_message) ?>", true);
    <?php endif; ?>

</script>