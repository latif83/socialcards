<?php
// --- SIMPLIFIED PLACEHOLDER DATA (Focus on Layout) ---
// In the final version, this data will come from your SQLite DB.
$username = "Connect User"; 

?>

<div class="container mx-auto p-4 md:p-8">
    <h1 class="sm:text-2xl md:text-3xl text-xl font-bold text-gray-800 mb-6">Welcome back, <?= htmlspecialchars($username) ?>!</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-indigo-500">
            <p class="text-sm font-medium text-gray-500">Total Cards Created</p>
            <p id="totalCardsCount" class="sm:text-4xl text-2xl font-extrabold text-indigo-600 mt-1"></p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-teal-500">
            <p class="text-sm font-medium text-gray-500">Total Cards Views</p>
            <p id="totalViewsCount" class="sm:text-4xl text-xl font-extrabold text-teal-600 mt-1"></p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-purple-500 flex flex-col justify-center items-center">
            <p class="text-sm font-medium text-gray-500 mb-2">Need a new card?</p>
            <a href="?page=create-card" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-md text-center transition duration-200 text-sm">
                 <i class="fas fa-magic mr-1"></i> Generate Card Link
            </a>
        </div>
    </div>

    <h2 class="sm:text-2xl text-xl font-semibold text-gray-800 mb-4">Quick Actions</h2>
    <div class="flex flex-col sm:flex-row gap-4 mb-10">
        <a href="?page=create-card" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg text-center text-md transition duration-200">
            <i class="fas fa-plus mr-2"></i> Create New Digital Card
        </a>
        <a href="?page=cards" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg shadow-lg text-center transition duration-200">
            <i class="fas fa-list-alt mr-2"></i> View All My Cards
        </a>
    </div>

    <h2 class="sm:text-2xl text-xl font-semibold text-gray-800 mb-4">Recent Cards</h2>

        <div id="recentCardsList" class="bg-white rounded-lg shadow-md p-4 mb-10">
         
        </div>

        <div id="emptyCards" class="text-center p-8 bg-gray-100 rounded-lg mb-10 hidden">
            <p class="text-gray-600">You haven't created any cards yet.</p>
            <a href="?page=create-card" class="mt-4 inline-block text-indigo-600 hover:text-indigo-800 font-medium">Start creating your first card now!</a>
        </div>
    
</div>

<footer class="w-full bg-gray-50 py-4 mt-auto border-t border-gray-200 md:absolute bottom-0">
    <div class="container mx-auto text-center text-sm text-gray-500">
        &copy; <?= date('Y') ?> <b>Connect</b> - Your Digital Identity Hub. All rights reserved. | <a href="#" class="text-indigo-500 hover:text-indigo-700">Terms</a> | <a href="#" class="text-indigo-500 hover:text-indigo-700">Privacy</a>
    </div>
</footer>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
    async function fetchDashboardSummary() {
        const response = await fetch("api/api.php?route=summary");
        const result = await response.json();

        if (result.success && result.summary) {
            const summary = result.summary;

            // Display Total Cards
            document.getElementById('totalCardsCount').textContent = summary.total_cards;

            // Display Total Views
            document.getElementById('totalViewsCount').textContent = summary.total_views.toLocaleString(); 
            
            // Display Recent Cards (Example)
            const recentCardsList = document.getElementById('recentCardsList');
            recentCardsList.innerHTML = ''; // Clear previous data

            summary.recent_cards.forEach(card => {
                const listItem = document.createElement('li');
                listItem.className = 'p-3 m-3 border-b';
                listItem.innerHTML = `
                    <div class="font-semibold">${card.name} (${card.card_type})</div>
                    <div class="text-sm text-gray-500">Created: ${new Date(card.created_at).toLocaleDateString()} | Views: ${card.view_count}</div>
                `;
                recentCardsList.appendChild(listItem);
            });

            summary.recent_cards.length < 1 && document.getElementById("emptyCards").classList.remove('hidden')
            summary.recent_cards.length < 1 && recentCardsList.classList.add('hidden')
            
        } else {
            console.error('Failed to load summary:', result.message);
        }
    }

    document.addEventListener("DOMContentLoaded", fetchDashboardSummary);
</script>