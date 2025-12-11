<div id="deleteCardModal" class="fixed top-0 left-0 w-full h-svh bg-black/30 backdrop-blur-[2px] pt-12 z-50 hidden">

    <div class="max-w-md bg-white w-full mx-auto rounded-lg sm:p-6 p-4 overflow-y-auto shadow-2xl transform transition-all duration-300">

        <div class="flex items-center justify-between mb-4 pb-2 border-b">
            <span class="text-xl font-bold text-red-600 flex items-center gap-2">
                <i class="fas fa-trash-alt"></i> Confirm Deletion
            </span>
            <button id="closeDeleteModalBtn" type="button"
                class="w-8 h-8 text-gray-500 hover:text-white hover:bg-red-600 rounded-full flex items-center justify-center transition-colors">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <div class="text-gray-700">
            <p class="mb-6">
                Are you absolutely sure you want to delete this digital card? 
                <span class="font-bold text-red-600">This action cannot be undone.</span>
            </p>
            <p class="mb-6 text-sm text-gray-500">
                Deleting the card will permanently remove the record and the associated profile image from the server.
            </p>

            <input type="hidden" id="cardIdToDelete" value="">
        </div>

        <div id="deleteStatusMessage" class="hidden p-3 mb-4 rounded text-center font-medium"></div>

        <div class="flex justify-end space-x-3 mt-6">
            <button id="cancelDeleteBtn" type="button"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-150">
                Cancel
            </button>
            <button id="confirmDeleteBtn" type="button"
                class="px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition duration-150 flex items-center gap-2">
                <span id="deleteBtnText">Delete Card Permanently</span>
                <svg id="deleteSpinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
            </button>
        </div>

    </div>
</div>


<script>
    const deleteModal = document.getElementById('deleteCardModal');
    const cardIdToDelete = document.getElementById('cardIdToDelete');
    const closeDeleteModalBtn = document.getElementById('closeDeleteModalBtn');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const deleteBtnText = document.getElementById('deleteBtnText');
    const deleteSpinner = document.getElementById('deleteSpinner');
    const deleteStatusMessage = document.getElementById('deleteStatusMessage');

    // --- Modal Control Functions ---
    
 

    // Function to close the modal
    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
        cardIdToDelete.value = ''; // Clear the stored ID
        
        // Reset button state
        confirmDeleteBtn.disabled = false;
        confirmDeleteBtn.classList.remove("opacity-70", "cursor-not-allowed");
        deleteSpinner.classList.add('hidden');
        deleteBtnText.textContent = "Delete Card Permanently";
    }

    // Attach click listeners to close buttons
    closeDeleteModalBtn.addEventListener('click', closeDeleteModal);
    cancelDeleteBtn.addEventListener('click', closeDeleteModal);
    
    // Allow clicking outside the modal to close it (optional, but good UX)
    deleteModal.addEventListener('click', (e) => {
        if (e.target === deleteModal) {
            closeDeleteModal();
        }
    });


    // --- API Request Function ---
    async function executeDelete(cardId) {
        
        // Set loading state
        confirmDeleteBtn.disabled = true;
        confirmDeleteBtn.classList.add("opacity-70", "cursor-not-allowed");
        deleteSpinner.classList.remove('hidden');
        deleteBtnText.textContent = "Deleting...";

        const formData = new FormData();
        formData.append('card_id', cardId);

        try {
            const response = await fetch(`api/api.php?route=deleteCard`, {
                method: 'POST', // Use POST as defined in the controller
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                // Show success message in modal briefly
                deleteStatusMessage.className = 'p-3 mb-4 rounded bg-green-100 text-green-700 text-center font-medium';
                deleteStatusMessage.innerHTML = `<i class="fas fa-check-circle mr-2"></i> ${result.message}`;
                deleteStatusMessage.classList.remove('hidden');

                // After a delay, close modal and refresh the card list
                setTimeout(() => {
                    closeDeleteModal();
                    // Assumes fetchAndRenderCards is the function on your page that loads the list
                    if (typeof fetchAndRenderCards === 'function') {
                        fetchAndRenderCards(); 
                    } else {
                        // Fallback refresh if list function is not globally available
                        location.reload(); 
                    }
                }, 1500); 

            } else {
                // Show error message
                deleteStatusMessage.className = 'p-3 mb-4 rounded bg-red-100 text-red-700 text-center font-medium';
                deleteStatusMessage.innerHTML = `<i class="fas fa-exclamation-triangle mr-2"></i> ${result.message}`;
                deleteStatusMessage.classList.remove('hidden');
            }

        } catch (error) {
            console.error('Delete API Error:', error);
            deleteStatusMessage.className = 'p-3 mb-4 rounded bg-red-100 text-red-700 text-center font-medium';
            deleteStatusMessage.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i> Network error during deletion.';
            deleteStatusMessage.classList.remove('hidden');

        } finally {
            // Re-enable button on error, but keep the success flow separate
            if (!result || !result.success) {
                confirmDeleteBtn.disabled = false;
                confirmDeleteBtn.classList.remove("opacity-70", "cursor-not-allowed");
                deleteSpinner.classList.add('hidden');
                deleteBtnText.textContent = "Delete Card Permanently";
            }
        }
    }
    
    // --- Attach Delete Handler to Button ---
    confirmDeleteBtn.addEventListener('click', () => {
        const cardId = cardIdToDelete.value;
        if (cardId) {
            executeDelete(cardId);
        } else {
            closeDeleteModal();
        }
    });


</script>