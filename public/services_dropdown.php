<?php
include './public/conn.php';

$stmt = $pdo->query("SELECT name FROM services ORDER BY id ASC LIMIT 10");
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="dropdown">
    <button class="dropdown-toggle">Услуги</button>
    <div class="dropdown-menu">
        <?php foreach ($services as $index => $service): ?>
            <a href="#" class="dropdown-item"><?php echo htmlspecialchars($service['name']); ?></a>
            <?php if ($index == 1): ?>
                <div class="dropdown-scrollable">
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if (count($services) > 2): ?>
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

    .dropdown{
        max-width: 181px;
        width: 100%;
        border-bottom: 1px solid #606060;
    }

    .dropdown-toggle{
        background-color: rgba( 0, 0, 0, 0);
        border: none;
        cursor: pointer;
        outline: none;
        font-weight: 400;
        color: #fff;
        color: rgba(255, 255, 255, 0.60);
        padding-top: 11px;
        padding-bottom: 11px;
        font-size: 16px;
    }
    .dropdown:hover .dropdown-menu { display: block; }
    .dropdown-item { color: white; padding: 12px 16px; text-decoration: none; display: block; }
    .dropdown-item:hover { background-color: #555; }
    .dropdown-scrollable { max-height: 100px; overflow-y: scroll; }
</style>