<?php
include './public/conn.php';

$stmt = $pdo->query("SELECT name FROM products ORDER BY id ASC LIMIT 10");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="dropdown">
    <button class="dropdown-toggle">Продукты</button>
    <div class="dropdown-menu">
        <?php foreach ($products as $index => $product): ?>
            <a href="#" class="dropdown-item"><?php echo htmlspecialchars($product['name']); ?></a>
            <?php if ($index == 1): ?>
                <div class="dropdown-scrollable">
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if (count($products) > 2): ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .dropdown { position: relative; display: inline-block; }
    .dropdown-menu {
        display: none;
        position: absolute;
        background-color: #333;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        max-height: 150px;
        overflow-y: auto;
    }
    .dropdown:hover .dropdown-menu { display: block; }
    .dropdown-item { color: white; padding: 12px 16px; text-decoration: none; display: block; }
    .dropdown-item:hover { background-color: #555; }
    .dropdown-scrollable { max-height: 100px; overflow-y: scroll; }
</style>