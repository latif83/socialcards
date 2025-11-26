<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialCards - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'ui-sans-serif', 'system-ui'],
                    },
                }
            }
        }
    </script>

</head>

<body class="bg-gray-100 font-sans">

    <!-- Navbar -->
    <header class="bg-black shadow-md py-6 sm:px-12 px-3 flex justify-between items-center">

        <div class="flex items-center gap-2 ">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5}
                stroke="currentColor" class="w-6 h-6 text-blue-300">
                <path strokeLinecap="round" strokeLinejoin="round"
                    d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
            </svg>

            <h1 class="text-xl font-bold text-blue-300">Connect</h1>
        </div>

        <!-- <nav class="space-x-4 text-white">
      <a href="#" class="text-gray-100 hover:text-blue-600">Home</a>
      <a href="#" class="text-gray-100 hover:text-blue-600">Categories</a>
    </nav> -->

        <button type="button" class="p-3 rounded-md bg-white px-6 text-sm font-medium">
            Login / Register
        </button>
    </header>

    <!-- Hero Section -->
    <section
        class="py-12 bg-[url(./images/bg.jpg)] bg-cover bg-center h-[400px] relative flex justify-center items-center sm:px-12 px-3">

        <div class="absolute top-0 left-0 w-full h-full bg-black/50"> </div>

        <div class="relative z-50 text-white flex flex-col items-center justify-center gap-6">
            <h2 class="text-4xl font-bold mb-4">Connect with Friends and Businesses</h2>
            <p class="text-gray-100 mb-6 font-semibold">Organize your social contacts and discover new connections
                easily.</p>
            <a href="#" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">Create Your
                Card</a>
        </div>
    </section>

    <section class="md:px-12 px-3 py-12">

        <div class="grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-2 gap-4">

            <div>

                <div class="rounded-lg shadow-lg relative">
                    <img src="./images/avatar1.jpg" class="rounded-lg w-full h-[250px] object-cover object-center" />

                    <div class="absolute -bottom-6 left-0 w-full flex justify-center items-center">

                        <div class="bg-white/90 p-1 rounded-lg shadow-xl border">

                            <img src="./images/teamac.png" alt="QR Code" class="w-16 h-16 block mx-auto">

                            <div class="flex gap-2 items-center justify-center">
                                <button
                                    class="p-2 flex items-center justify-center gap-2 text-sm hover:text-blue-600 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        strokeWidth={1.5} stroke="currentColor" class="w-4 h-4">
                                        <path strokeLinecap="round" strokeLinejoin="round"
                                            d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                                    </svg>

                                    <span>
                                        Share </span>
                                </button>

                                <button
                                    class="p-2 flex items-center justify-center gap-2 text-sm hover:text-red-600 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        strokeWidth={1.5} stroke="currentColor" class="w-4 h-4">
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
                    <h1 class="font-bold text-xl mb-1">John Doe</h1>

                    <!-- Category / Role -->
                    <p class="text-sm text-gray-500 mb-2">Personal / Designer</p>

                    <!-- Location -->
                    <p class="text-sm text-gray-500 mb-2 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 11c1.5 0 3-2 3-3s-1.5-3-3-3-3 1.5-3 3 1.5 3 3 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 11c-4 0-7 3-7 7h14c0-4-3-7-7-7z" />
                        </svg>
                        London, UK
                    </p>

                    <!-- Bio / Short Description -->
                    <p class="text-sm text-gray-600 line-clamp-2">
                        Freelance designer creating digital experiences. Passionate about UI/UX and building tools that
                        simplify life.
                    </p>

                    <div class="mt-6 text-center">
                        <a href="card-details.html"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                            View More...
                        </a>
                    </div>

                </div>


            </div>

            <div>

                <div class="rounded-lg shadow-lg relative">
                    <img src="./images/avatar2.jpg" class="rounded-lg w-full h-[250px] object-cover object-center" />

                    <div class="absolute -bottom-6 left-0 w-full flex justify-center items-center">

                        <div class="bg-white/90 p-1 rounded-lg shadow-xl border">

                            <img src="./images/teamac.png" alt="QR Code" class="w-16 h-16 block mx-auto">

                            <div class="flex gap-2 items-center justify-center">
                                <button
                                    class="p-2 flex items-center justify-center gap-2 text-sm hover:text-blue-600 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        strokeWidth={1.5} stroke="currentColor" class="w-4 h-4">
                                        <path strokeLinecap="round" strokeLinejoin="round"
                                            d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                                    </svg>

                                    <span>
                                        Share </span>
                                </button>

                                <button
                                    class="p-2 flex items-center justify-center gap-2 text-sm hover:text-red-600 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        strokeWidth={1.5} stroke="currentColor" class="w-4 h-4">
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
                    <h1 class="font-bold text-xl mb-1">Jane Smith</h1>

                    <!-- Category / Role -->
                    <p class="text-sm text-gray-500 mb-2">Business / Photographer</p>

                    <!-- Location -->
                    <p class="text-sm text-gray-500 mb-2 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 11c1.5 0 3-2 3-3s-1.5-3-3-3-3 1.5-3 3 1.5 3 3 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 11c-4 0-7 3-7 7h14c0-4-3-7-7-7z" />
                        </svg>
                        Paris, FR
                    </p>

                    <!-- Bio / Short Description -->
                    <p class="text-sm text-gray-600 line-clamp-2">
                        Professional photographer capturing moments that tell a story. Specializes in portrait and
                        lifestyle photography. Combines creativity with technical expertise to deliver images that
                        resonate with viewers. Loves travel, art, and documenting life’s fleeting moments.
                    </p>

                    <div class="mt-6 text-center">
                        <a href="card-details.html"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                            View More...
                        </a>
                    </div>

                </div>


            </div>

            <div>

                <div class="rounded-lg shadow-lg relative">
                    <img src="./images/avatar3.jpg" class="rounded-lg w-full h-[250px] object-cover object-center" />

                    <div class="absolute -bottom-6 left-0 w-full flex justify-center items-center">

                        <div class="bg-white/90 p-1 rounded-lg shadow-xl border">

                            <img src="./images/teamac.png" alt="QR Code" class="w-16 h-16 block mx-auto">

                            <div class="flex gap-2 items-center justify-center">
                                <button
                                    class="p-2 flex items-center justify-center gap-2 text-sm hover:text-blue-600 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        strokeWidth={1.5} stroke="currentColor" class="w-4 h-4">
                                        <path strokeLinecap="round" strokeLinejoin="round"
                                            d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                                    </svg>

                                    <span>
                                        Share </span>
                                </button>

                                <button
                                    class="p-2 flex items-center justify-center gap-2 text-sm hover:text-red-600 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        strokeWidth={1.5} stroke="currentColor" class="w-4 h-4">
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
                    <h1 class="font-bold text-xl mb-1">Michael Lee</h1>

                    <!-- Category / Role -->
                    <p class="text-sm text-gray-500 mb-2">Personal / Developer</p>

                    <!-- Location -->
                    <p class="text-sm text-gray-500 mb-2 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 11c1.5 0 3-2 3-3s-1.5-3-3-3-3 1.5-3 3 1.5 3 3 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 11c-4 0-7 3-7 7h14c0-4-3-7-7-7z" />
                        </svg>
                        Berlin, DE
                    </p>

                    <!-- Bio / Short Description -->
                    <p class="text-sm text-gray-600 line-clamp-2">
                        Full-stack developer focused on building scalable and performant web applications. Enjoys
                        working with PHP, JavaScript, and modern frameworks. Always learning and exploring new
                        technologies to improve coding efficiency and software architecture.
                    </p>

                    <div class="mt-6 text-center">
                        <a href="card-details.html"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                            View More...
                        </a>
                    </div>

                </div>


            </div>

            <div>

                <div class="rounded-lg shadow-lg relative">
                    <img src="./images/avatar4.jpg" class="rounded-lg w-full h-[250px] object-cover object-center" />

                    <div class="absolute -bottom-6 left-0 w-full flex justify-center items-center">

                        <div class="bg-white/90 p-1 rounded-lg shadow-xl border">

                            <img src="./images/teamac.png" alt="QR Code" class="w-16 h-16 block mx-auto">

                            <div class="flex gap-2 items-center justify-center">
                                <button
                                    class="p-2 flex items-center justify-center gap-2 text-sm hover:text-blue-600 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        strokeWidth={1.5} stroke="currentColor" class="w-4 h-4">
                                        <path strokeLinecap="round" strokeLinejoin="round"
                                            d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                                    </svg>

                                    <span>
                                        Share </span>
                                </button>

                                <button
                                    class="p-2 flex items-center justify-center gap-2 text-sm hover:text-red-600 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        strokeWidth={1.5} stroke="currentColor" class="w-4 h-4">
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
                    <h1 class="font-bold text-xl mb-1">Sara Johnson</h1>

                    <!-- Category / Role -->
                    <p class="text-sm text-gray-500 mb-2">Business / Marketer</p>

                    <!-- Location -->
                    <p class="text-sm text-gray-500 mb-2 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 11c1.5 0 3-2 3-3s-1.5-3-3-3-3 1.5-3 3 1.5 3 3 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 11c-4 0-7 3-7 7h14c0-4-3-7-7-7z" />
                        </svg>
                        Milan, IT
                    </p>

                    <!-- Bio / Short Description -->
                    <p class="text-sm text-gray-600 line-clamp-2">
                        Digital marketer helping brands grow online with strategic campaigns. Skilled in content
                        creation, SEO, and social media management. Passionate about connecting businesses with
                        audiences through creative storytelling and data-driven insights.
                    </p>

                    <div class="mt-6 text-center">
                        <a href="card-details.html"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                            View More...
                        </a>
                    </div>

                </div>


            </div>

            <div>

                <div class="rounded-lg shadow-lg relative">
                    <img src="./images/avatar5.jpg" class="rounded-lg w-full h-[250px] object-cover object-center" />

                    <div class="absolute -bottom-6 left-0 w-full flex justify-center items-center">

                        <div class="bg-white/90 p-1 rounded-lg shadow-xl border">

                            <img src="./images/teamac.png" alt="QR Code" class="w-16 h-16 block mx-auto">

                            <div class="flex gap-2 items-center justify-center">
                                <button
                                    class="p-2 flex items-center justify-center gap-2 text-sm hover:text-blue-600 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        strokeWidth={1.5} stroke="currentColor" class="w-4 h-4">
                                        <path strokeLinecap="round" strokeLinejoin="round"
                                            d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                                    </svg>

                                    <span>
                                        Share </span>
                                </button>

                                <button
                                    class="p-2 flex items-center justify-center gap-2 text-sm hover:text-red-600 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        strokeWidth={1.5} stroke="currentColor" class="w-4 h-4">
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
                    <h1 class="font-bold text-xl mb-1">David Brown</h1>

                    <!-- Category / Role -->
                    <p class="text-sm text-gray-500 mb-2">Personal / Writer</p>

                    <!-- Location -->
                    <p class="text-sm text-gray-500 mb-2 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 11c1.5 0 3-2 3-3s-1.5-3-3-3-3 1.5-3 3 1.5 3 3 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 11c-4 0-7 3-7 7h14c0-4-3-7-7-7z" />
                        </svg>
                        Warsaw, PL
                    </p>

                    <!-- Bio / Short Description -->
                    <p class="text-sm text-gray-600 line-clamp-2">
                        Writer and content creator focusing on storytelling across multiple platforms. Writes blog
                        posts, short stories, and web content that engages readers. Interested in literature, tech, and
                        psychology. Loves inspiring people through words and narratives.
                    </p>

                    <div class="mt-6 text-center">
                        <a href="card-details.html"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                            View More...
                        </a>
                    </div>

                </div>


            </div>


            <div>

                <div class="rounded-lg shadow-lg relative">
                    <img src="./images/avatar6.jpg" class="rounded-lg w-full h-[250px] object-cover object-center" />

                    <div class="absolute -bottom-6 left-0 w-full flex justify-center items-center">

                        <div class="bg-white/90 p-1 rounded-lg shadow-xl border">

                            <img src="./images/teamac.png" alt="QR Code" class="w-16 h-16 block mx-auto">

                            <div class="flex gap-2 items-center justify-center">
                                <button
                                    class="p-2 flex items-center justify-center gap-2 text-sm hover:text-blue-600 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        strokeWidth={1.5} stroke="currentColor" class="w-4 h-4">
                                        <path strokeLinecap="round" strokeLinejoin="round"
                                            d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                                    </svg>

                                    <span>
                                        Share </span>
                                </button>

                                <button
                                    class="p-2 flex items-center justify-center gap-2 text-sm hover:text-red-600 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        strokeWidth={1.5} stroke="currentColor" class="w-4 h-4">
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
                    <h1 class="font-bold text-xl mb-1">Emily Davis</h1>

                    <!-- Category / Role -->
                    <p class="text-sm text-gray-500 mb-2">Business / Consultant</p>

                    <!-- Location -->
                    <p class="text-sm text-gray-500 mb-2 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 11c1.5 0 3-2 3-3s-1.5-3-3-3-3 1.5-3 3 1.5 3 3 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 11c-4 0-7 3-7 7h14c0-4-3-7-7-7z" />
                        </svg>
                        Stockholm, SE
                    </p>

                    <!-- Bio / Short Description -->
                    <p class="text-sm text-gray-600 line-clamp-2">
                        Business consultant specializing in digital transformation and strategy. Advises companies on
                        improving processes, optimizing operations, and leveraging technology to achieve growth.
                        Passionate about problem-solving, analytics, and driving business impact.
                    </p>

                    <div class="mt-6 text-center">
                        <a href="card-details.html"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                            View More...
                        </a>
                    </div>

                </div>


            </div>

        </div>

    </section>

    <!-- Footer -->
    <footer class="bg-white shadow-inner mt-12">
        <div class="container mx-auto p-6 text-center text-gray-600">
            &copy; 2025 SocialCards. All rights reserved.
        </div>
    </footer>

</body>

</html>