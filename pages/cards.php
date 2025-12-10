<div class="container mx-auto p-4 md:p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Your Digital Cards </h1>
        <a href="?page=create-card"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg shadow-md transition duration-200 flex items-center">
            <i class="fas fa-plus mr-2 text-sm"></i> Create New Card
        </a>
    </div>

 <div id="loadingCards" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php for ($i = 0; $i < 3; $i++): ?>
        <div class="animate-pulse bg-white rounded-xl shadow-xl p-6 border-t-4 border-gray-300">
            <div class="h-4 w-20 bg-gray-300 rounded"></div>
            <div class="h-6 w-32 bg-gray-300 rounded mt-3"></div>
            <div class="h-4 w-24 bg-gray-300 rounded mt-2"></div>
            <div class="h-4 w-full bg-gray-300 rounded mt-4"></div>
            <div class="h-4 w-3/4 bg-gray-300 rounded mt-2"></div>
            <div class="flex gap-2 mt-6">
                <div class="flex-1 h-10 bg-gray-300 rounded"></div>
                <div class="flex-1 h-10 bg-gray-300 rounded"></div>
                <div class="flex-1 h-10 bg-gray-300 rounded"></div>
            </div>
        </div>
    <?php endfor; ?>
</div>


    <div id="noCardsBox"
        class="hidden text-center p-12 bg-white rounded-lg shadow-lg border-2 border-dashed border-gray-300">
        <i class="fas fa-id-card-alt text-6xl text-gray-400 mb-4"></i>
        <p class="text-xl text-gray-600 font-semibold mb-3">No Cards Found</p>
        <p class="text-gray-500 mb-6">It looks like you haven't created any digital cards yet.</p>
        <a href="?page=create-card"
            class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-lg shadow-lg">
            Start Your First Card
        </a>
    </div>

    <div id="cardsContainer" class="hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"></div>


</div>

<script>
    function confirmDelete(cardId, cardName) {
        if (confirm("Are you sure you want to permanently delete the card: \"" + cardName + "\"? This action cannot be undone.")) {
            // In the final version, you would submit a form or make an AJAX request here
            // Example: window.location.href = '?page=delete-card&id=' + cardId;
            console.log('Attempting to delete card ID:', cardId);
            alert("Delete initiated for " + cardName + ". (Functionality to be added)");
        }
    }

    const body = document.querySelector('body')

    async function getCards() {
        try {
            const response = await fetch("api/api.php?route=getCards");

            const data = await response.json();

            if (!data.success) {
                console.error("Error fetching cards:", data.message);

                const msgDiv = document.createElement("div");
                msgDiv.className = "alert bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 fixed top-5 right-5";
                msgDiv.innerHTML = `<span>Error fetching cards: ${data.message}</span>`;
                body.append(msgDiv);

                return [];
            }

            // Show success message
            const msgDiv = document.createElement("div");
            msgDiv.className = "alert bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 fixed top-5 right-5";
            msgDiv.innerHTML = `<span>Card retrieved successfully!</span>`;
            body.append(msgDiv);

            console.log(data.cards)

            return data.cards;

        } catch (error) {
            console.error("Network error fetching cards:", error);
            return [];
        }
    }



    function renderCard(card) {
        const typeColor = card.card_type === "business"
            ? "border-blue-500"
            : "border-green-500";

        const tagColor = card.card_type === "business"
            ? "bg-blue-100 text-blue-800"
            : "bg-green-100 text-green-800";

        return `
        <div class="bg-white rounded-xl shadow-xl overflow-hidden transform hover:scale-[1.02] transition duration-300 border-t-4 ${typeColor}">
            <div class="p-6">
                <span class="text-xs font-semibold uppercase px-2 py-0.5 rounded-full ${tagColor}">
                    ${card.card_type}
                </span>

                <h3 class="text-2xl font-bold text-gray-800 mt-2 truncate">
                    ${card.name}
                </h3>

                <p class="text-sm text-gray-500 truncate mb-4">${card.title_role || ""}</p>

                <div class="flex justify-between text-sm text-gray-600 mb-4 border-t pt-3">
                    <p>
                        <i class="fas fa-eye text-teal-500 mr-1"></i> Views:
                        <span class="font-bold">${card.views_count || 0}</span>
                    </p>
                    <p>
                        <i class="fas fa-clock text-gray-500 mr-1"></i> Updated:
                        ${card.updated_at ?? ""}
                    </p>
                </div>

                <div class="mb-4 bg-gray-100 p-3 rounded-md border border-gray-200">
                    <p class="text-xs font-medium text-gray-500 mb-1">Share Link:</p>
                    <p class="text-sm font-semibold text-indigo-600 truncate">
                        ${location.origin}/${card.id}
                    </p>
                </div>

                <div class="flex gap-2 mt-4 border-t pt-4">
                    <a href="/${card.id}" target="_blank"
                        class="flex-1 text-center bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg text-sm font-medium">
                        <i class="fas fa-external-link-alt mr-1"></i> View
                    </a>

                    <a href="?page=edit-card&id=${card.card_id}"
                        class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg text-sm font-medium">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>

                    <button onclick="confirmDelete(${card.card_id}, '${card.name}')"
                        class="flex-1 text-center bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg text-sm font-medium">
                        <i class="fas fa-trash-alt mr-1"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    `;
    }

    async function loadCards() {
        const loadingBox = document.getElementById("loadingCards");
        const noCardsBox = document.getElementById("noCardsBox");
        const cardsContainer = document.getElementById("cardsContainer");

        // Show skeletons first
        loadingBox.classList.remove("hidden");

        const cards = await getCards();

        setTimeout(() => {


            loadingBox.classList.add("hidden");

            if (cards.length === 0) {
                noCardsBox.classList.remove("hidden");
                return;
            }

            cardsContainer.classList.remove("hidden");

            cards.forEach(card => {
                cardsContainer.innerHTML += renderCard(card);
            });

        }, 2000);
    }

    loadCards();



</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">