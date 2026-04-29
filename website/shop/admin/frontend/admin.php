<?php
require_once dirname(__DIR__, 3) . "/config.php";
require_once BLOCKER_PATH;
include DB_PATH;

    if ($_SESSION["role"] !== "admin") 
    {
        //header("Location: " . ACCOUNT_F_URL . "account.php");
        //exit;
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="<?=CSS_URL?>admin.css">
</head>
<body>
    <header class="container-fluid sticky-top p-3">
        <div class="top row align-items-center">

            <!-- LOGO -->
            <div class="col-sm-3 col-9 mb-2 d-flex justify-content-sm-end justify-content-start">
                <a 
                    href="https://www.zs4.oswiata.tychy.pl/"
                    class="d-inline-block shadow-none">
                        <img 
                            src="<?=IMG_URL?>logo.svg"
                            class="img-fluid img-logo" alt="logo"
                        >
                </a>
            </div>

            <div class="col-lg-5 col-0 mb-2 d-lg-flex d-none justify-content-md-start">
                <a 
                    href="<?=HOME_F_URL?>home.php"
                    class="d-inline-block shadow-none">
                        <img 
                            src="<?=IMG_URL?>zegowska-szama2.png"
                            class="img-fluid img-logo" alt="zegowska-szama"
                        >
                </a>
            </div>

            <!-- NAV -->
            <div class="nav col-lg-4 col-sm-9 col-3 d-flex justify-content-end gap-2">
                <a
                    href="<?=ACCOUNT_F_URL?>account.php"
                    class="btn btn-dark">
                    Konto
                    </a>
                <a
                    href="<?=CART_F_URL?>cart.php"
                    class="btn btn-dark">
                    Koszyk
                </a>
                <a
                    href="<?=HOME_F_URL?>home.php"
                    class="btn btn-dark">
                    Sklep
                </a>
            </div>

        </div>
    </header>





    <?php
    $result = $connection->query("SELECT * FROM products");
    ?>

    <select id="productSelect">
        <option>Wybierz produkt</option>
        <?php while($row = $result->fetch_assoc()): ?>
        <option 
            class="product"
            value="<?= $row['id'] ?>"
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


    <form action="<?=ADMIN_B_URL?>update-product.php" method="post" id="productForm">

        <label for="id">id:</label>
        <input
            id="id"
            name="id"
            type="text"
            readonly
        ><br>

        <input
            type="text"
            id="name"
            name="name"
            placeholder="Name"
        ><br>

        <textarea
            id="description"
            name="description"
            placeholder="Description">
        </textarea><br>

        <input
            type="number"
            id="price"
            name="price"
            step="0.01"
            placeholder="price"
        ><br>

        <input
            type="number"
            id="stock"
            name="stock"
            placeholder="stock"
        ><br>

        <input
            type="text"
            id="img"
            name="img"
            placeholder="img"
        ><br>

        <label for="is_available">Available:</label>
        <input
            type="checkbox"
            id="is_available"
            name="is_available"
        ><br>
    
        <button
            type="submit"
            name="action"
            value="update">
            Update
        </button>

        <button
            type="submit"
            name="action"
            value="delete">
            Delete
        </button>

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

    <form action="<?=ADMIN_B_URL?>add-product.php" method="post" id="productForm">

        <label for="id">id:</label>
        <input
            id="id"
            name="id"
            type="text"
            value="<?=$nextId?>"
            readonly
        ><br>

        <input
            type="text"
            id="name"
            name="name"
            placeholder="Name"
        ><br>

        <textarea
            id="description"
            name="description"
            placeholder="Description">
        </textarea><br>

        <input
            type="number"
            id="price"
            name="price"
            step="0.01"
            placeholder="price"
        ><br>

        <input
            type="number"
            id="stock"
            name="stock"
            placeholder="stock"
        ><br>

        <input
            type="text"
            id="img"
            name="img"
            placeholder="img"
        ><br>

        <label for="is_available">Available:</label>
        <input
            type="checkbox"
            id="is_available"
            name="is_available"
        ><br>

        <button
            type="submit">
            add
        </button>

    </form>


dodawanie prod
usuwanie/edycja prod

zarzadzanie user

dodawanie disc
usuwanie/edycja disc

obsluga order




<script src="<?=JS_URL?>admin.js"></script>
</body>
</html>