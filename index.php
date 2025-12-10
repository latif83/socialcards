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

    <?php include "login-modal.php"; ?>

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

        <button onclick="toggleModal(true)" type="button" class="p-3 rounded-md bg-white px-6 text-sm font-medium">
            Login / Register
        </button>
    </header>

    <!-- Hero Section -->
    <section
        class="py-12 bg-[url(./images/bg.jpg)] bg-cover bg-center h-[400px] relative flex justify-center items-center sm:px-12 px-3">

        <div class="absolute top-0 left-0 w-full h-full bg-black/50"> </div>

        <div class="relative z-40 text-white flex flex-col items-center justify-center gap-6">
            <h2 class="text-4xl font-bold mb-4">Connect with Friends and Businesses</h2>
            <p class="text-gray-100 mb-6 font-semibold">Organize your social contacts and discover new connections
                easily.</p>
            <a href="#" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">Create Your
                Card</a>
        </div>
    </section>

    <section class="md:px-12 px-3 py-12">

        <?php include 'publiccards.php'; ?>

    </section>

    <!-- Footer -->
    <footer class="bg-white shadow-inner mt-12">
        <div class="container mx-auto p-6 text-center text-gray-600">
            &copy; 2025 SocialCards. All rights reserved.
        </div>
    </footer>

</body>

</html>