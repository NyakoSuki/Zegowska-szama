<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/Zegowska-szama/website/backend/config/config.php";
include DATABASE_FILE;

$site = basename($_SERVER['PHP_SELF']);
?>

<section
    class="products p-3"
>
    <div
        class="row g-4"
    >
        <?php
        $query = $connection->query
        ("
        SELECT
            p.id,
            p.name,
            p.description,
            p.type,
            p.price,
            p.stock,
            p.is_available,
            p.is_active,
            p.img,
            d.procent,
            d.start_date,
            d.end_date
        FROM products p
        LEFT JOIN
        (
            SELECT *
            FROM
            (
                SELECT 
                    d.*,
                    dp.product_id,
                    ROW_NUMBER() OVER
                    (
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
        ORDER BY p.type;
        ");
        while ($row = $query->fetch_assoc())
        {
            $productId = (int)($row["id"]);
            if($site === "cart.php")
            {
                if (!isset($cart[$productId])) continue;
            }

            $productName = $row["name"];
            $productDescription = $row["description"];
            $productType = $row["type"];
            $productPrice = (float)($row["price"]);
            $productStock = (int)($row["stock"]);
            $productIsAvailable = (int)($row["is_available"]);
            $productIsActive = (int)($row["is_active"]);
            $productImg = $row["img"];

            $discountProcent = (int)($row["procent"]);
            $discountStartDate = $row["start_date"];
            $discountEndDate = $row["end_date"];

            if($site === "cart.php")
            {
                $quantity = $cart[$productId];
            }

            $isAvailable = ($productIsAvailable === 1 && ($productStock === -1 || $productStock > 0));

            $isActive = ($productIsActive === 1);
            if(!$isActive) continue;

            $isDiscounted = $discountProcent !== 0;
            if($isDiscounted)
                $truePrice = round($productPrice * (1 - $discountProcent / 100), 2);
            else
                $truePrice = $productPrice;
        ?>
        <div
            class="col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2"
        >
            <div 
                class="product
                h-100 d-flex flex-column border p-1
                <?= $isAvailable ? '' : 'opacity-50'?>
                <?= $isDiscounted ? 'border-3 border-warning' : ''?>"

                data-name="<?= $productName?>"
                data-price="<?= $truePrice?>"
                data-type="<?= $productType?>"
                data-stock="<?= $productStock?>"
                data-available="<?= $productIsAvailable?>"
                data-discount="<?= $discountProcent?>"
            >
                <img 
                    src="<?=IMG_PRODUCTS.$productImg?>"
                    alt="<?= $productName ?>"
                    class="card-img-top h2 text-center p-0 m-0 align-self-center
                    <?= ($productType === 'drink') ? 'w-25' : ''?>"
                >
                <div
                    class="p-2 d-flex flex-column flex-grow-1"
                >
                    <h3
                        class="fw-bold"
                    >
                        <?= $productName ?>
                    </h3>
                    <small>
                        <?= $productDescription ?>
                    </small>

                    <div
                        class="d-flex mt-auto p-0 m-0 gap-2"
                    >
                        <p
                            class="fw-bold p-0 m-0 mt-auto
                            <?= $isDiscounted ? 'text-decoration-line-through' : ''?>"
                        >
                            <?= $productPrice * ($quantity ?? 1)?> zł
                        </p>
                        <p
                            class="fw-bold p-0 m-0 h4 text-warning align-self-end"
                        >
                            <?= $isDiscounted ? number_format($truePrice * ($quantity ?? 1), 2) . ' zł' : ''?>
                        </p>


                    <?php if($site === "shop.php") { ?>
                            <p
                                class="fw-bold p-0 m-0 h5 bg-danger text-light ms-auto rounded-5 p-1 m-1
                                <?= $isDiscounted ?  '' : 'd-none'?>"
                            >
                                -<?= $discountProcent?>%
                            </p>
                        </div>
                            <button
                                type="button"
                                class="btn w-100 fw-semibold shadow-sm p-1 m-0
                                <?= $isDiscounted ? 'btn-warning' : 'btn-light border border-dark' ?>"
                                <?= $isAvailable ? '' : 'disabled' ?>
                                data-bs-toggle="modal"
                                data-bs-target="#cartAddModal"
                                data-bs-product-id="<?= $productId ?>"
                                data-bs-product-name="<?= $productName ?>"
                            >
                                🛒 Dodaj do koszyka
                            </button>
                        </div>
                    <?php } ?>

                    <?php if($site === "cart.php") { ?>
                        </div>
                            <p
                                class="fw-bold p-0 m-0 h5 bg-danger text-light ms-auto rounded-5 p-1 m-1"
                            >
                                <?= $quantity?>
                            </p>
                        </div>
                    <?php } ?>


            </div>
        </div>
        <?php } ?>
    </div>
</section>