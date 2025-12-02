<?php
// --- PLACEHOLDER DATA (Replace with actual DB fetch when ready) ---
$cards = [
    (object)[
        'card_id' => 101, 
        'full_name' => 'John Doe Personal Card', 
        'title_role' => 'PHP/Azure Student', 
        'card_type' => 'personal', 
        'share_slug' => 'john-doe-me', 
        'last_updated' => '2025-11-28',
        'views_count' => 45
    ],
    (object)[
        'card_id' => 102, 
        'full_name' => 'Acme Corp Business Card', 
        'title_role' => 'Regional Manager', 
        'card_type' => 'business', 
        'share_slug' => 'acme-corp-profile', 
        'last_updated' => '2025-11-25',
        'views_count' => 134
    ],
    (object)[
        'card_id' => 103, 
        'full_name' => 'Freelance Portfolio', 
        'title_role' => 'Designer & Coder', 
        'card_type' => 'personal', 
        'share_slug' => 'freelance-connect', 
        'last_updated' => '2025-12-01',
        'views_count' => 12
    ],
];
// --- END PLACEHOLDER DATA ---

// You would typically include your DB connection here:
// require_once __DIR__ . '/../db.php'; 
// And execute a query like: 
// $stmt = $db->prepare("SELECT * FROM cards WHERE user_id = :user_id");
// $stmt->execute([':user_id' => $user_id]);
// $cards = $stmt->fetchAll();
?>

<div class="container mx-auto p-4 md:p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Your Digital Cards (<?= count($cards) ?>)</h1>
        <a href="?page=create-card" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg shadow-md transition duration-200 flex items-center">
            <i class="fas fa-plus mr-2 text-sm"></i> Create New Card
        </a>
    </div>

    <?php if (empty($cards)): ?>
        <div class="text-center p-12 bg-white rounded-lg shadow-lg border-2 border-dashed border-gray-300">
            <i class="fas fa-id-card-alt text-6xl text-gray-400 mb-4"></i>
            <p class="text-xl text-gray-600 font-semibold mb-3">No Cards Found</p>
            <p class="text-gray-500 mb-6">It looks like you haven't created any digital cards yet.</p>
            <a href="?page=create-card" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-lg shadow-lg">
                Start Your First Card
            </a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($cards as $card): ?>
                <div class="bg-white rounded-xl shadow-xl overflow-hidden transform hover:scale-[1.02] transition duration-300 border-t-4 
                    <?= $card->card_type == 'business' ? 'border-blue-500' : 'border-green-500' ?>">
                    
                    <div class="p-6">
                        <span class="text-xs font-semibold uppercase px-2 py-0.5 rounded-full 
                            <?= $card->card_type == 'business' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' ?>">
                            <?= htmlspecialchars($card->card_type) ?>
                        </span>

                        <h3 class="text-2xl font-bold text-gray-800 mt-2 truncate"><?= htmlspecialchars($card->full_name) ?></h3>
                        <p class="text-sm text-gray-500 truncate mb-4"><?= htmlspecialchars($card->title_role) ?></p>

                        <div class="flex justify-between text-sm text-gray-600 mb-4 border-t pt-3">
                             <p>
                                 <i class="fas fa-eye text-teal-500 mr-1"></i> Views: 
                                 <span class="font-bold"><?= $card->views_count ?? 0 ?></span>
                             </p>
                             <p>
                                 <i class="fas fa-clock text-gray-500 mr-1"></i> Updated: 
                                 <?= date('M d, Y', strtotime($card->last_updated)) ?>
                             </p>
                        </div>

                        <div class="mb-4 bg-gray-100 p-3 rounded-md border border-gray-200">
                             <p class="text-xs font-medium text-gray-500 mb-1">Share Link:</p>
                             <p class="text-sm font-semibold text-indigo-600 truncate">
                                 [Your Site URL]/<?= htmlspecialchars($card->share_slug) ?>
                             </p>
                        </div>

                        <div class="flex gap-2 mt-4 border-t pt-4">
                            <a href="/<?= htmlspecialchars($card->share_slug) ?>" target="_blank" class="flex-1 text-center bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg text-sm font-medium">
                                <i class="fas fa-external-link-alt mr-1"></i> View
                            </a>
                            <a href="?page=edit-card&id=<?= $card->card_id ?>" class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg text-sm font-medium">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <button onclick="confirmDelete(<?= $card->card_id ?>, '<?= htmlspecialchars($card->full_name) ?>')" class="flex-1 text-center bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg text-sm font-medium">
                                <i class="fas fa-trash-alt mr-1"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

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
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">