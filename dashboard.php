<?php
// Default page = dashboard
$page = $_GET['page'] ?? 'dashboard';

// Whitelist allowed pages (security)
$allowed_pages = ['dashboard', 'cards', 'create-card', 'view-card', 'edit-card', 'profile'];

if (!in_array($page, $allowed_pages)) {
    $page = 'dashboard';
}

$activePage = $page;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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

<body class="font-sans">

    <?php include "header.php"; ?>

    <?php include "pages/$page.php"; ?>

</body>

</html>