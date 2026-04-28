<?php

require_once dirname(__DIR__, 3) . "/config.php";
require_once BLOCKER_PATH;

    if ($_SESSION["role"] !== "admin") 
    {
        //header("Location: " . ACCOUNT_F_URL . "account.php");
        //exit;
    }


include DB_PATH;


?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel</title>
</head>
<body>
    <?php
    $result = $connection->query("SELECT * FROM products");
    ?>

    <select id="productSelect">
    <option value="">Wybierz produkt</option>
    <?php while($row = $result->fetch_assoc()): ?>
        <option class="product" value="<?= $row['id'] ?>"
        data-id="<?=$row["id"] ?>"
        data-name="<?=$row["name"] ?>"
        data-description="<?=$row["description"] ?>"
        data-price="<?=$row["price"] ?>"
        data-stock="<?=$row["stock"] ?>"
        data-available="<?=$row["is_available"] ?>"
        data-img="<?=$row["img"] ?>"
        >
            <?= $row['name'] ?>
        </option>
    <?php endwhile; ?>
</select>

<br><br>

<form action="<?=ACCOUNT_B_URL?>update-product.php" method="post" id="productForm">
    <label>id:</label>
    <input id="id" name="id" type="text" readonly><br>

    <input type="text" id="name" name="name" placeholder="Name"><br>

    <textarea id="description" name="description" placeholder="Description"></textarea><br>

    <input type="number" id="price" name="price" step="0.01" placeholder="price"><br>

    <input type="number" id="stock" name="stock" placeholder="stock"><br>

    <input type="text" id="img" name="img" placeholder="img"><br>

    <label>
        Available:
        <input type="checkbox" id="is_available" name="is_available">
    </label>
        <button type="submit" name="action" value="update">Update</button>
        <button type="submit" name="action" value="delete">Delete</button>
</form>

<?php

$result = $connection->query
("
    SELECT AUTO_INCREMENT 
    FROM information_schema.TABLES 
    WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'products'
");

$row = $result->fetch_assoc();
$nextId = $row['AUTO_INCREMENT'];

?>

<form action="<?=ACCOUNT_B_URL?>add-product.php" method="post" id="productForm">
    <input id="id" name="id" type="text" value="<?=$nextId?>" readonly><br>

    <input type="text" id="name" name="name" placeholder="Name"><br>

    <textarea id="description" name="description" placeholder="Description"></textarea><br>

    <input type="number" id="price" name="price" step="0.01" placeholder="price"><br>

    <input type="number" id="stock" name="stock" placeholder="stock"><br>

    <input type="text" id="img" name="img" placeholder="img"><br>

    <label>
        Available:
        <input type="checkbox" id="is_available" name="is_available">
    </label>
        <button type="submit">add</button>
</form>

<script src="<?=JS_URL?>admin.js"></script>
</body>
</html>