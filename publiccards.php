<div id="loadingCards" class="grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-2 gap-4 animate-pulse">

    <?php for ($i = 0; $i < 4; $i++): ?>
        <div>

            <div class="rounded-lg shadow-lg relative z-10">
                <div class="w-full h-[250px] bg-gray-200 rounded-lg"></div>

                <div class="absolute -bottom-6 left-0 w-full flex justify-center items-center">

                    <div class="bg-white/90 p-1 rounded-lg shadow-xl border">

                        <img src="./images/teamac.png" alt="QR Code" class="w-16 h-16 block mx-auto">

                        <div class="flex gap-2 items-center justify-center">
                            <button
                                class="p-2 flex items-center justify-center gap-2 text-sm hover:text-blue-600 hover:underline">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                                    stroke="currentColor" class="w-4 h-4">
                                    <path strokeLinecap="round" strokeLinejoin="round"
                                        d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                                </svg>

                                <span>
                                    Share </span>
                            </button>

                            <button
                                class="p-2 flex items-center justify-center gap-2 text-sm hover:text-red-600 hover:underline">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                                    stroke="currentColor" class="w-4 h-4">
                                    <path strokeLinecap="round" strokeLinejoin="round"
                                        d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                                </svg>


                                <span>
                                    Copy Link </span>
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <div class="p-4 bg-white shadow-lg mx-4 py-10 rounded-b-lg">

                <!-- Name -->
                <h1 class="font-bold text-xl mb-2 h-6 w-44 bg-gray-200 rounded-md"></h1>

                <!-- Category / Role -->
                <p class="text-sm text-gray-500 mb-2 h-6 w-48 bg-gray-200 rounded-md"></p>

                <!-- Location -->
                <p class="text-sm text-gray-500 mb-2 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 11c1.5 0 3-2 3-3s-1.5-3-3-3-3 1.5-3 3 1.5 3 3 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c-4 0-7 3-7 7h14c0-4-3-7-7-7z" />
                    </svg>
                    <span class="h-6 w-32 bg-gray-200 rounded-md">

                    </span>
                </p>

                <!-- Bio / Short Description -->
                <p class="text-sm text-gray-600 line-clamp-2 h-4 w-full">
                </p>

                <div class="mt-6 text-center">
                    <a href="card-details.html"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded h-6 w-32 block">
                    </a>
                </div>

            </div>


        </div>
    <?php endfor; ?>
</div>


<div id="noCardsBox"
    class="text-center hidden p-12 bg-white rounded-lg shadow-lg border-2 border-dashed border-gray-300">
    <i class="fas fa-id-card-alt text-6xl text-gray-400 mb-4"></i>
    <p class="text-2xl text-gray-700 font-bold mb-2">Oops! Looks a bit empty here…</p>
    <p class="text-gray-500 mb-6">No digital cards have been created yet. You could be the first to showcase your
        profile!</p>
    <a href="dashboard.php?page=create-card"
        class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-lg shadow-lg transition">
        Create Your Card Now
    </a>
</div>




<div id="cardsContainer" class="grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-2 gap-4">

</div>

<script>


    const body = document.querySelector('body')

    async function getCards() {
        try {
            const response = await fetch("api/api.php?route=getPublicCards");

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
            // body.append(msgDiv);

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
        <div>

        <div class="rounded-lg shadow-lg relative z-10">
            <img src="${card.profile_image}" class="rounded-lg w-full h-[250px] object-cover object-center" />

            <div class="absolute -bottom-6 left-0 w-full flex justify-center items-center">

                <div class="bg-white/90 p-1 rounded-lg shadow-xl border">

                    <img src="./images/teamac.png" alt="QR Code" class="w-16 h-16 block mx-auto">

                    <div class="flex gap-2 items-center justify-center">
                        <button
                            class="p-2 flex items-center justify-center gap-2 text-sm hover:text-blue-600 hover:underline">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                                stroke="currentColor" class="w-4 h-4">
                                <path strokeLinecap="round" strokeLinejoin="round"
                                    d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                            </svg>

                            <span>
                                Share </span>
                        </button>

                        <button
                            class="p-2 flex items-center justify-center gap-2 text-sm hover:text-red-600 hover:underline">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                                stroke="currentColor" class="w-4 h-4">
                                <path strokeLinecap="round" strokeLinejoin="round"
                                    d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                            </svg>


                            <span>
                                Copy Link </span>
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div class="p-4 bg-white shadow-lg mx-4 py-10 rounded-b-lg">

            <!-- Name -->
            <h1 class="font-bold text-xl mb-1">${card.name}</h1>

            <!-- Category / Role -->
            <p class="text-sm text-gray-500 mb-2 uppercase">${card.card_type} / ${card.title_role}</p>

            <!-- Location -->
            <p class="text-sm text-gray-500 mb-2 flex items-center gap-1 line-clamp-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 11c1.5 0 3-2 3-3s-1.5-3-3-3-3 1.5-3 3 1.5 3 3 3z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c-4 0-7 3-7 7h14c0-4-3-7-7-7z" />
                </svg>
                ${card.address ? card.address : 'N/A'}
            </p>

            <!-- Bio / Short Description -->
            <p class="text-sm text-gray-600 line-clamp-2">
            ${card.bio}
            </p>

            <div class="mt-6 text-center">
                <a href="card-details.html?cardid=${card.id}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                    View More...
                </a>
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