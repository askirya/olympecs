<?php
include './conn.php';

$searchQuery = $_GET['query'] ?? '';

if ($searchQuery) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE :query OR article LIKE :query");
    $stmt->execute(['query' => "%$searchQuery%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $results = [];
}
?>

<?php if ($results): ?>
    <div class="search-results">
        <ul>
            <?php foreach ($results as $product): ?>
                <li class="search__con">
                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" width="50">
                    <div class="search-right">
                        <strong><?php echo htmlspecialchars($product['name']); ?></strong>
                        <p>Артикул: <?php echo htmlspecialchars($product['article']); ?></p>
                        <p>Цена: <?php echo number_format($product['discounted_price'], 2, ',', ' ') . ' ' . $product['currency']; ?></p>
                    </div>
                    <button class="add-to-cart" data-id="<?php echo $product['id']; ?>">+</button>
                </li>
            <?php endforeach; ?>
            <?php else: ?>
            <p class="pos">Ничего не найдено.</p>
        <?php endif; ?>
        </ul>
    </div>
