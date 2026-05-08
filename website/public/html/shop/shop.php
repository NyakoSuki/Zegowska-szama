<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/Zegowska-szama/website/backend/config/config.php";
require_once SITE_BLOCKER;
include DATABASE_FILE;
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zegowska Szama - sklep</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=CSS_URL?>main.css">
</head>
<body class="<?=$_SESSION['theme']?>">
    <?php
    $site = "shop";
    include HTML_PATH . "/shared/header.php";
    ?>
    <main>
        <!--
        * ====================PRODUCTS====================
         * generated in productCreate.php
        * ==================================================
        -->
            <?php include SHARED_B . "productCreate.php"?>

        <!--
        * ====================MENU====================
         * 
        * ==================================================
        -->
        <section>
            <div
                id="filters"
                class="filterDisabled
                col-12 col-sm-6 col-md-4 col-lg-6 col-xxl-4 mt-2"
            >
                <div
                    class="card bg-white"
                >
                    <div
                        class="card-body"
                    >
                        <h6
                            class="mb-3 fw-bold"
                        >
                            Filtry
                        </h6>
                        <input
                            type="text"
                            id="filterName"
                            class="form-control bg-light mb-2"
                            placeholder="Szukaj po nazwie..."
                        >
                        <input
                            type="number"
                            id="filterMin"
                            class="form-control bg-light mb-2"
                            step=0.01
                            placeholder="Cena minimalna"
                        >
                        <input
                            type="number"
                            id="filterMax"
                            class="form-control bg-light mb-3"
                            step=0.01
                            placeholder="Cena maksymalna"
                        >
                        <hr>
                        <h6
                            class="mb-3 fw-bold"
                        >
                            Zaznacz kategorie
                        </h6>

                        <div
                            class="row justify-content-center mb-1 gap-4"
                        >
                            <button
                                id="filterIsAvailable"
                                class="btn btn-info opacity-50 col-5 h-100 mb-2"
                            >
                                Dostępne
                            </button>
                            <button 
                                id="filterIsDiscounted"
                                class="btn btn-info opacity-50 col-5 h-100"
                            >
                                Promocje
                            </button>
                        </div>
                        <div
                            class="row justify-content-center mb-4 gap-lg-4"
                        >
                            <button
                                id="filterFood"
                                class="btn btn-info opacity-50 col-lg-3 h-100 mb-2"
                            >
                                Jedzenie
                            </button>
                            <button
                                id="filterDrink"
                                class="btn btn-info opacity-50 col-lg-3 h-100 mb-2"
                            >
                                Napoje
                            </button>
                            <button
                                id="filterSchool"
                                class="btn btn-info opacity-50 col-lg-3 h-100 mb-2"
                            >
                                Szkoła
                            </button>
                        </div>

                        <button
                                id="resetFiltersBtn"
                                class="btn btn-danger col-8 offset-2"
                            >
                                Reset
                        </button>

                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <?php include JS_CONFIG?>
    <?php include HTML_PATH . "shop/popup.php"?>
    <script src="<?=JS_SHOP?>filter.js"></script>
</body>
</html>