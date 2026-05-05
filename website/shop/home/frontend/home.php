<?php
require_once dirname(__DIR__, 3) . "/config.php";
require_once BLOCKER_PATH;
include DB_PATH;
include JS_PATH;
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zegowska Szama - sklep</title>
</head>
<body class="<?=$_SESSION['theme']?>">
    <?php
    //---HEADER---
    $_SESSION["site"] = "home";
    include HEADER_PATH;
    ?>
    <main>
        <!-- PRODUCTS -->
        <section class="products p-3">
            <div class="row g-4">
                <?php
                $products = $connection->query
                ("
                SELECT
                    p.id,
                    p.name,
                    p.description,
                    p.price,
                    p.stock,
                    p.is_available,
                    p.img,
                    d.procent,
                    d.start_date,
                    d.end_date
                FROM products p
                LEFT JOIN (
                    SELECT *
                    FROM (
                        SELECT 
                            d.*,
                            dp.product_id,
                            ROW_NUMBER() OVER (
                                PARTITION BY dp.product_id
                                ORDER BY d.procent DESC
                            ) AS rn
                        FROM discounts d
                        JOIN discounted_products dp 
                            ON d.id = dp.discount_id
                        WHERE d.start_date <= NOW()
                        AND d.end_date >= NOW()
                    ) x
                    WHERE rn = 1
                ) d ON p.id = d.product_id
                ORDER BY p.id;
                ");
                while ($product = $products->fetch_assoc())
                {
                    $disabled = (int)($product["is_available"]) === 0;
                    $noDiscount = $product["procent"] === null;
                    $price = round($product["price"] * (1 - $product["procent"] / 100), 2);
                ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2">
                    <div 
                        class="product h-100 d-flex flex-column border p-1
                        <?= $disabled ? 'opacity-50' : '' ?>
                        <?= $noDiscount ? 'border-dark' : 'border-3 border-warning' ?>"
                        data-name="<?= strtolower($product["name"]) ?>"
                        data-price="<?= $price ?>"
                        data-available="<?= $product["is_available"]?>"
                        data-discount="<?= $product["procent"]?>"
                    >
                        <img 
                            src="<?=IMG_P_URL . $product["img"] ?>" 
                            class="card-img-top h2 text-center p-0 m-0"
                            alt="<?= $product["name"] ?>"
                        >
                        <div class="p-2 d-flex flex-column flex-grow-1">
                            <h2 
                                class="fw-bold">
                                <?= $product["name"] ?>
                            </h2>
                            <small>
                                <?= $product["description"] ?>
                            </small>
                            <div class="d-flex mt-auto p-0 m-0 gap-2">
                                <?php
                                if(!$noDiscount)
                                {
                                ?>
                                <small
                                    class="fw-bold p-0 m-0 mt-auto text-decoration-line-through">
                                    <?= $product["price"] ?> zł
                                </small>
                                <?php } ?>
                                <p
                                    class="fw-bold p-0 m-0
                                    <?= $noDiscount ? '' : 'h4 text-warning' ?>">
                                    <?= $price ?> zł
                                </p>
                            </div>
                            <form class="cartAdd m-0">
                                <input 
                                    type="hidden"
                                    name="id"
                                    value="<?= $product["id"] ?>"
                                >
                                <button class="btn cart-bt w-100 fw-semibold shadow-sm p-1 m-0
                                    <?= $noDiscount ? 'btn-light border border-dark' : 'btn-warning' ?>"
                                    <?= $disabled ? 'disabled' : '' ?>>
                                    <span class="small">
                                        🛒 Dodaj do koszyka
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </section>


        <!-- MENU -->
        <section>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-4 mt-2 menu menuDisabled">
                <div class="card bg-light border-dark shadow-sm">
                    <div class="card-body">
                        <h6 class="mb-3">
                            Filtry
                        </h6>
                        <input
                            type="text"
                            id="searchName"
                            class="form-control border-secondary mb-2"
                            placeholder="Szukaj po nazwie..."
                        >
                        <input
                            type="number"
                            id="minPrice"
                            class="form-control border-secondary mb-2"
                            placeholder="Cena min"
                        >
                        <input
                            type="number"
                            id="maxPrice"
                            class="form-control border-secondary mb-3"
                            placeholder="Cena max"
                        >
                        <div class="row justify-content-center mb-4">
                            <button
                                id="available"
                                class="btn btn-info opacity-50 w-75 h-100 mb-2">
                                Pokaż tylko dostępne
                            </button>
                            <button
                                id="discount"
                                class="btn btn-info opacity-50 w-75 h-100">
                                Pokaż tylko promocje
                            </button>
                        </div>
                        <button
                                id="resetFilters"
                                class="btn btn-danger col-8 offset-2">
                                Reset
                        </button>

                    </div>
                </div>
            </div>
        </section>
    </main>

    
    <footer>

    </footer>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?=JS_URL?>menu.js"></script>
    <script src="<?=JS_URL?>cart.js"></script>
</body>
</html>