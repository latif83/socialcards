<?php
session_start();

// prevent errors if not set
if (!isset($activePage))
    $activePage = "";

// check login state
$isLoggedIn = isset($_SESSION['user_id']);
?>

<header class="bg-black shadow-md py-6 px-3 sm:px-12 flex justify-between items-center">

    <!-- Logo -->
    <div class="flex items-center gap-2 text-blue-300">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor"
            class="w-7 h-7">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
        </svg>
        <h1 class="text-xl font-bold">Connect</h1>
    </div>

    <!-- Desktop Navigation -->
    <nav class="hidden md:flex items-center gap-8 text-white">

        <a href="dashboard.php"
            class="pb-1 border-b-2 transition duration-200 
            <?= $activePage == 'dashboard' ? 'border-blue-400 text-blue-300' : 'border-transparent hover:text-blue-300 hover:border-blue-300' ?>">
            Dashboard
        </a>

        <a href="dashboard.php?page=cards"
            class="pb-1 border-b-2 transition duration-200 
            <?= $activePage == 'cards' ? 'border-blue-400 text-blue-300' : 'border-transparent hover:text-blue-300 hover:border-blue-300' ?>">
            My Cards
        </a>

        <a href="dashboard.php?page=create-card"
            class="pb-1 border-b-2 transition duration-200 
            <?= $activePage == 'create-card' ? 'border-blue-400 text-blue-300' : 'border-transparent hover:text-blue-300 hover:border-blue-300' ?>">
            Create Card
        </a>


    </nav>

    <!-- Desktop Account Buttons -->
    <div class="hidden md:flex items-center gap-4">

        <?php if (!$isLoggedIn): ?>

            <a href="dashboard.php?page=profile" class="text-white hover:text-blue-300 text-sm">
                My Profile
            </a>

            <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded-md text-sm hover:bg-red-700">
                Logout
            </a>

        <?php else: ?>

            <a href="auth.php" class="bg-white text-black px-5 py-2 rounded-md text-sm">
                Login / Register
            </a>

        <?php endif; ?>

    </div>

    <!-- Mobile Menu Button -->
    <button id="menuBtn" class="md:hidden text-white">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-7 h-7">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 6.75h15m-15 5.25h15m-15 5.25h15" />
        </svg>
    </button>
</header>

<!-- Mobile Dropdown -->
<div id="mobileMenu" class="md:hidden hidden bg-black text-white px-6 py-4 space-y-3">

    <a href="dashboard.php"
        class="block py-2 border-l-4 pl-2 transition 
        <?= $activePage == 'dashboard' ? 'border-blue-400 text-blue-300' : 'border-transparent hover:text-blue-300 hover:border-blue-300' ?>">
        Dashboard
    </a>

    <a href="dashboard.php?page=cards"
        class="block py-2 border-l-4 pl-2 transition
        <?= $activePage == 'cards' ? 'border-blue-400 text-blue-300' : 'border-transparent hover:text-blue-300 hover:border-blue-300' ?>">
        My Cards
    </a>

    <a href="dashboard.php?page=create-card"
        class="block py-2 border-l-4 pl-2 transition
        <?= $activePage == 'add-card' ? 'border-blue-400 text-blue-300' : 'border-transparent hover:text-blue-300 hover:border-blue-300' ?>">
        Create Card
    </a>


    <!-- Mobile Auth Buttons -->
    <?php if ($isLoggedIn): ?>

        <a href="dashboard.php?page=profile"
            class="block py-2 border-l-4 pl-2 transition hover:text-blue-300 hover:border-blue-300">
            My Profile
        </a>

        <a href="logout.php" class="block bg-red-600 text-white py-2 mt-2 rounded-md text-center hover:bg-red-700">
            Logout
        </a>

    <?php else: ?>

        <a href="auth.php" class="block bg-white text-black py-2 mt-2 rounded-md text-center">
            Login / Register
        </a>

    <?php endif; ?>

</div>

<script>
    const btn = document.getElementById("menuBtn");
    const menu = document.getElementById("mobileMenu");

    btn.addEventListener("click", () => {
        menu.classList.toggle("hidden");
    });
</script>