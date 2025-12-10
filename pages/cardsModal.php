<div id="cardModal" class="fixed top-0 left-0 w-full h-svh bg-black/30 backdrop-blur-[2px] pt-12 hidden">

    <div class="max-w-6xl bg-white h-full w-full mx-auto rounded-t-lg sm:p-6 p-3">

        <div class="flex items-center justify-between">
            <span class="text-lg font-medium">Card Details</span>
            <button onClick="closeModal()" type="button"
                class="w-6 h-6 hover:bg-red-600 hover:text-white text-red-600 rounded-full p-4 flex items-center justify-center block">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <div id="loadingSpinner"
            class="container mx-auto mt-32 rounded-xl p-8 flex items-center flex-col justify-center gap-4">

            <i class="fas fa-spinner fa-spin text-3xl"></i>

            <p>Loading Data...</p>

        </div>

        <div id="dataContainer" class="container hidden mx-auto mt-32 bg-white rounded-xl">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-10">

                <!-- LEFT SIDE -->
                <div class="flex flex-col items-center md:items-start md:w-1/3">
                    <div id="avatarImgContainer" class="relative w-48 h-48">


                    </div>


                    <!-- Social Links -->
                    <div id="cardLinks" class="flex flex-col mt-6 gap-3">
                    </div>
                </div>

                <!-- RIGHT SIDE -->
                <div id="dataFlow" class="md:w-2/3">



                </div>
            </div>
        </div>

    </div>

</div>

<script>

    function closeModal() {
        const cardModal = document.getElementById('cardModal')
        cardModal.classList.add("hidden")
    }


    function renderCardData(cardData) {
        const cardLinks = document.getElementById("cardLinks")
        const avatarImgContainer = document.getElementById("avatarImgContainer")

        const dataFlow = document.getElementById("dataFlow")

        const loadingSpinner = document.getElementById("loadingSpinner")

        const dataContainer = document.getElementById("dataContainer")

        setTimeout(() => {
            loadingSpinner.classList.remove("flex")
            loadingSpinner.classList.add("hidden")

            dataContainer.classList.remove("hidden")
        }, 1000);

        const socialLinks = JSON.parse(cardData.social_links)

        // console.log(socialLinks)

        dataFlow.innerHTML = `
             <h1 class="text-4xl font-bold">${cardData.name}</h1>
                <p class="text-xl text-secondary mt-2"><span class="uppercase text-sm font-bold">${cardData.card_type}</span> / <span class="text-sm"> ${cardData.title_role} </span></p>

                <!-- Location -->
                <p class="flex items-center text-secondary mt-4 gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-secondary" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 11c1.5 0 3-2 3-3s-1.5-3-3-3-3 1.5-3 3 1.5 3 3 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c-4 0-7 3-7 7h14c0-4-3-7-7-7z" />
                    </svg>
                    ${cardData.address ? cardData.address : 'N/A'}
                </p>

                <!-- Contact Details -->
                <div class="mt-6 space-y-2 text-secondary">
                    <p><span class="font-semibold">Email:</span> ${cardData.email}</p>
                    <p><span class="font-semibold">Phone:</span> ${cardData.phone}</p>
                    <p><span class="font-semibold">Website:</span> ${socialLinks.website ? socialLinks.website : 'N/A'}</p>
                </div>

                <!-- Bio -->
                <p class="text-secondary mt-6 text-lg leading-relaxed">
                    ${cardData.bio}
                </p>

 <!-- ACTION BUTTONS -->
                <div class="flex gap-4 mt-8">
                    <button onClick="share(${cardData.id})" class="bg-indigo-800 text-white px-6 py-3 rounded-lg hover:bg-indigo-600 flex items-center justify-center gap-2">
                        <i class="fas fa-share"> </i>
                       <span>Share Link</span>
                    </button>
                    <button class="bg-gray-100 text-secondary px-6 py-3 rounded-lg hover:bg-gray-200 flex items-center justify-center gap-2">
                        <i class="fas fa-qrcode"></i>
                        <span>QR Code</span>
                    </button>
                </div>
            `

        avatarImgContainer.innerHTML = `<img id="avatarImg" src="${cardData.profile_image}"
                        class="w-full h-full rounded-full object-cover shadow-lg border-4 border-gray-50 bg-white" />  <!-- Expand Button -->
                    <button onclick="openImageModal('./images/avatar1.jpg')"
                        class="absolute bottom-2 right-2 bg-indigo-800 text-white p-2 rounded-full shadow-md hover:bg-indigo-600 transition">
                        <!-- Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5m1 11h4m0 0v-4m0 4l-5-5M4 16H4m0 0v4m0-4l5 5" />
                        </svg>
                    </button> `

                    cardLinks.innerHTML = ''

        for (const key in socialLinks) {
            cardLinks.innerHTML += `<a href="${socialLinks[key]}" class="flex gap-1 text-primary hover:text-blue-500 flex-col">
                    <span class="uppercase font-bold text-xs">${key}:</span>
                        <span>${socialLinks[key] ? socialLinks[key] : 'N/A'} </span>
                </a>`
        }
    }

    async function fetchCard(cardId) {

        if (!cardId) {
            return alert('card id not found!')
        }

        const res = await fetch(`api/api.php?route=getCard&id=${cardId}`)
        if (!res.ok) {
            // error here
        }

        const data = await res.json()
        const cardData = data.card

        renderCardData(cardData)

        // console.log(cardData)

    }

    function share(cardId) {
            if (!cardId) {
                alert("Error: Card ID is missing.");
                return;
            }

            // 1. Determine the base URL
            // window.location.origin provides the protocol + hostname + port (e.g., https://yourdomain.com)
            const baseUrl = window.location.origin;

            // Determine the path to the card details page.
            // Assuming your card details view is accessible at /card.html or /your-app-root/card.html

            // We will assume the base path is /card.html relative to the domain root
            // ADJUST THIS PATH: Ensure '/card.html' is the correct file path relative to your domain root.
            const cardPath = '/card-details.html';

            // 2. Construct the full public URL using your parameter structure
            const cardUrl = `${baseUrl}${cardPath}?cardid=${cardId}`;

            // 3. Attempt to copy the URL to the clipboard (Modern approach with fallback)
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(cardUrl)
                    .then(() => {
                        alert("Success! Card link copied to clipboard:\n" + cardUrl);
                    })
                    .catch(err => {
                        console.error('Could not copy text via Clipboard API:', err);
                        promptForCopy(cardUrl);
                    });
            } else {
                // Fallback for older browsers
                promptForCopy(cardUrl);
            }
        }



</script>