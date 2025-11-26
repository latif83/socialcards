<?php
require 'config.php';

// Handle CRUD & schema actions
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

    // Create new table
    if ($action === 'create_table') {
        $tableName = $_POST['new_table_name'];
        $columnsRaw = $_POST['new_table_columns']; // format: col1 TYPE, col2 TYPE
        $columnsArr = array_map('trim', explode(',', $columnsRaw));
        $colsSql = implode(', ', $columnsArr);
        $stmt = $db->prepare("CREATE TABLE IF NOT EXISTS `$tableName` ($colsSql)");
        $stmt->execute();
    }

    // Add new column
    if ($action === 'add_column') {
        $tableName = $_POST['table'];
        $newColumn = $_POST['new_column']; // format: colname TYPE
        $stmt = $db->prepare("ALTER TABLE `$tableName` ADD COLUMN $newColumn");
        $stmt->execute();
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

<!-- Create new table -->
<h2>Create New Table</h2>
<form method="post">
    <input type="hidden" name="action" value="create_table">
    <label>Table Name: <input type="text" name="new_table_name" required></label><br>
    <label>Columns (format: col1 TYPE, col2 TYPE): <input type="text" name="new_table_columns" required></label><br>
    <button type="submit">Create Table</button>
</form>

<!-- Add column to existing table -->
<h2>Add Column to Existing Table</h2>
<form method="post">
    <input type="hidden" name="action" value="add_column">
    <label>Table: 
        <select name="table">
            <?php foreach ($tables as $tableOption): ?>
                <option value="<?= htmlspecialchars($tableOption) ?>"><?= htmlspecialchars($tableOption) ?></option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>New Column (format: name TYPE): <input type="text" name="new_column" required></label><br>
    <button type="submit">Add Column</button>
</form>

<hr>

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
