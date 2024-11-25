<?php if ($results): ?>
    <div class="search-results">
        <h3>Результаты поиска:</h3>
        <ul>
            <?php foreach ($results as $product): ?>
                <li>
                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" width="50">
                    <strong><?php echo htmlspecialchars($product['name']); ?></strong>
                    <p>Артикул: <?php echo htmlspecialchars($product['article']); ?></p>
                    <p>Цена: <?php echo number_format($product['discounted_price'], 2, ',', ' ') . ' ' . $product['currency']; ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php else: ?>
    <p>Ничего не найдено.</p>
<?php endif; ?>