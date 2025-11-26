<?php
require 'config.php';

// Handle CRUD actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    // Insert new row
    if ($action === 'insert') {
        $table = $_POST['table'];
        $columns = $_POST['columns'];
        $values = $_POST['values'];

        $colString = implode(',', array_map(fn($c) => "`$c`", $columns));
        $placeholders = implode(',', array_fill(0, count($values), '?'));
        $stmt = $db->prepare("INSERT INTO `$table` ($colString) VALUES ($placeholders)");
        $stmt->execute($values);
    }

    // Delete row
    if ($action === 'delete') {
        $table = $_POST['table'];
        $idCol = $_POST['idCol'];
        $idVal = $_POST['idVal'];
        $stmt = $db->prepare("DELETE FROM `$table` WHERE `$idCol` = ?");
        $stmt->execute([$idVal]);
    }
}

// Fetch tables
$tables = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'")->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html>
<head>
    <title>SQLite Admin Panel</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { border-collapse: collapse; margin-bottom: 20px; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #eee; }
        form { margin-bottom: 20px; }
        input[type=text] { width: 100%; }
    </style>
</head>
<body>

<h1>SQLite Admin Panel</h1>

<?php foreach ($tables as $table): ?>
    <h2>Table: <?= htmlspecialchars($table) ?></h2>

    <?php
    // Show structure
    $schemaStmt = $db->query("SELECT sql FROM sqlite_master WHERE name='$table'");
    $schema = $schemaStmt->fetchColumn();
    echo "<pre>$schema</pre>";

    // Show data
    $dataStmt = $db->query("SELECT * FROM `$table`");
    $rows = $dataStmt->fetchAll(PDO::FETCH_ASSOC);
    if ($rows):
    ?>
    <table>
        <tr>
            <?php foreach (array_keys($rows[0]) as $col): ?>
                <th><?= htmlspecialchars($col) ?></th>
            <?php endforeach; ?>
            <th>Actions</th>
        </tr>
        <?php foreach ($rows as $row): ?>
            <tr>
                <?php foreach ($row as $col => $val): ?>
                    <td><?= htmlspecialchars($val) ?></td>
                <?php endforeach; ?>
                <td>
                    <form method="post" style="display:inline">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="table" value="<?= htmlspecialchars($table) ?>">
                        <input type="hidden" name="idCol" value="id"> <!-- assumes table has 'id' column -->
                        <input type="hidden" name="idVal" value="<?= $row['id'] ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <p>No rows in this table.</p>
    <?php endif; ?>

    <!-- Insert new row -->
    <form method="post">
        <h3>Insert new row in <?= htmlspecialchars($table) ?></h3>
        <input type="hidden" name="action" value="insert">
        <input type="hidden" name="table" value="<?= htmlspecialchars($table) ?>">
        <?php
        $columnsStmt = $db->query("PRAGMA table_info(`$table`)");
        $columns = $columnsStmt->fetchAll(PDO::FETCH_ASSOC);
        $colNames = [];
        foreach ($columns as $col) {
            $colName = $col['name'];
            $colNames[] = $colName;
            echo "<label>$colName: <input type='text' name='values[]'></label><br>";
        }
        echo "<input type='hidden' name='columns[]' value='".implode(',', $colNames)."'>";
        ?>
        <button type="submit">Insert</button>
    </form>

<?php endforeach; ?>

</body>
</html>
