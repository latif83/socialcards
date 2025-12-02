<?php
// PHP logic will go here to handle the form submission later
// For now, we focus on the modal structure and JavaScript interaction.
$login_message = ''; // For displaying success/error messages after submission
?>

<div id="authModal" class="fixed inset-0 z-50 hidden overflow-y-auto transition-opacity duration-300 ease-in-out backdrop-blur" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        
        <div class="w-full max-w-xl transform overflow-hidden rounded-xl bg-white p-6 text-left align-middle shadow-2xl transition-all">
            
            <button onclick="toggleModal(false)" type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 focus:outline-none">
                <i class="fas fa-times text-xl"></i>
            </button>
            
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
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
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
    let isRegisterMode = false;

    // 1. Show/Hide Modal
    function toggleModal(show) {
        if (show) {
            modal.classList.remove('hidden');
            // Optional: Re-enable scroll locking if desired
            // document.body.style.overflow = 'hidden'; 
        } else {
            modal.classList.add('hidden');
            // document.body.style.overflow = '';
            // Always revert to login mode on close
            toggleRegistration(false); 
        }
    }
    
    // 2. Toggle Login/Registration Mode
    function toggleRegistration(isRegister) {
        isRegisterMode = isRegister;
        const confirmPassInput = document.getElementById('confirm_password');

        if (isRegister) {
            // Switch to Registration mode
            confirmPasswordGroup.classList.remove('hidden');
            confirmPassInput.setAttribute('required', 'required');
            formTitle.textContent = 'Create Your Connect Account';
            submitButton.textContent = 'Sign Up';
            form.action = 'register_handler.php'; // Change action for clarity
            
            toggleText.innerHTML = `Already have an account? <a href="#" onclick="event.preventDefault(); toggleRegistration(false)" class="font-medium text-indigo-600 hover:text-indigo-500">Log In here.</a>`;
        } else {
            // Switch back to Login mode
            confirmPasswordGroup.classList.add('hidden');
            confirmPassInput.removeAttribute('required');
            formTitle.textContent = 'Log In to Connect';
            submitButton.textContent = 'Log In';
            form.action = 'login_handler.php'; // Change action back
            
            toggleText.innerHTML = `Don't have an account? <a href="#" onclick="event.preventDefault(); toggleRegistration(true)" class="font-medium text-indigo-600 hover:text-indigo-500">Create one now.</a>`;
        }
    }
    
    // 3. Simple Client-Side Check for Registration Password Match
    form.addEventListener('submit', function(e) {
        if (isRegisterMode) {
            const pass = document.getElementById('password').value;
            const confirmPass = document.getElementById('confirm_password').value;
            
            if (pass !== confirmPass) {
                e.preventDefault();
                alert('Error: Passwords do not match.');
            }
            // Add other required client-side checks here if needed
        }
    });

    // Optional: Hide modal when clicking outside (on the backdrop)
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            toggleModal(false);
        }
    });
</script>