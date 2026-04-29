<?php
require_once dirname(__DIR__, 3) . "/config.php";
require_once BLOCKER_PATH;
include DB_PATH;
include BASE_PATH . "config.js.php";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zegowska Szama</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="<?=CSS_URL?>home.css">
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
                <button
                    type="button" 
                    class="btn btn-dark menuBtn">
                    Filtry
                </button>
            </div>

        </div>
    </header>


    <main>
        <section class="products p-3">
            <div class="row g-4">

                <?php
                $products = $connection->query
                ("
                    SELECT id, name, description, price, stock, is_available, img 
                    FROM products
                ");

                while ($product = $products->fetch_assoc()) 
                {
                    $disabled = $product["is_available"] == 0;
                ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2">
                    <div 
                        class="h-100 d-flex flex-column p-1 <?= $disabled ? 'opacity-50' : '' ?> product"
                        data-name="<?= strtolower($product["name"]) ?>"
                        data-price="<?= $product["price"] ?>"
                        data-available="<?= $product["is_available"]?>">

                            <img 
                                src="<?= $product["img"] ?>" 
                                class="card-img-top"
                                alt="<?= $product["name"] ?>"
                            >

                            <div class="p-2 d-flex flex-column flex-grow-1">

                                <h2 class="fw-bold">
                                    <?= $product["name"] ?>
                                </h2>

                                <small>
                                    <?= $product["description"] ?>
                                </small>

                                <p class="fw-bold mt-auto p-0 m-0">
                                    <?= $product["price"] ?> zł
                                </p>

                                <form class="cartAdd">
                                    <input 
                                        type="hidden"
                                        name="id"
                                        value="<?= $product["id"] ?>"
                                    >
                                    <button class="btn cart-btn btn-success w-100 fw-semibold shadow-sm p-1 m-0"
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

                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-4 mt-2 menu menuDisabled">

                    <div class="card bg-light border-dark shadow-sm">
                        <div class="card-body">

                            <h6 class="mb-3">
                                Filtry
                            </h6>

                            <input
                                type="text"
                                id="searchName"
                                class="form-control outline-dark border-secondary mb-2"
                                placeholder="Szukaj po nazwie..."
                            >

                            <input
                                type="number"
                                id="minPrice"
                                class="form-control outline-dark border-secondary mb-2"
                                placeholder="Cena min"
                            >

                            <input
                                type="number"
                                id="maxPrice"
                                class="form-control outline-dark border-secondary mb-3"
                                placeholder="Cena max"
                            >

                            <div class="form-check mb-3">
                                <input
                                    type="checkbox"
                                    id="available"
                                    class="form-check-input"
                                >
                                <label class="form-check-label" for="available">
                                    Pokaż tylko dostępne
                                </label>
                            </div>

                            <button
                                id="resetFilters"
                                class="btn btn-dark w-100">
                                Reset
                            </button>

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    
    <footer>

    </footer>

    
    <script src="<?=JS_URL?>menu.js"></script>
    <script src="<?=JS_URL?>cart.js"></script>
</body>
</html>