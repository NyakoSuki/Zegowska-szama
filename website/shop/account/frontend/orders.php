<?php
require_once dirname(__DIR__, 3) . "/config.php";
require_once BLOCKER_PATH;
include DB_PATH;

$_SESSION["site"] = "orders";
include HEADER_PATH;
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zanówienia - Zegowska szama</title>
</head>
<body class="<?=$_SESSION["theme"]?>">

     <section class="products p-3">
            <div class="row g-4">

                <?php
                $orders = $connection->query
                ("
                SELECT
                    orders.total_price,
                    orders.status,
                    orders.created_at
                FROM orders
                ");

$orderId = $_GET['id'];

$details = $connection->query
("
SELECT 
    ordered_products.quantity,
    products.name
FROM ordered_products
JOIN products 
    ON ordered_products.product_id = products.id
WHERE ordered_products.order_id = $orderId
");


                                    

                while ($order = $orders->fetch_assoc())
                {
                ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2">
                    <div 
                        class="h-100 d-flex flex-column border p-1 <?= $disabled ? 'opacity-50' : '' ?> <?= $noDiscount ? 'border-dark' : 'border-3 border-warning' ?> product">

                            <div class="p-2 d-flex flex-column flex-grow-1">

                                <h2 class="fw-bold">
                                    <?= $order["created_at"] ?>
                                </h2>

                                <small>
                                    <?= $order["status"] ?>
                                </small>

                                <p class="fw-bold mt-auto p-0 m-0">
                                    <?= $order["total_price"] ?> zł
                                </p>

                               
                 <button 
    type="button"
    class="btn btn-success"
    data-bs-toggle="modal"
    data-bs-target="#detailsModal"
    data-order-id="<?= $order['id'] ?>">
    Zamów
</button>

                            </div>
                        </div>
                    </div>
                <?php } ?>

                
            </div>
        </section>
    </main>
    
    <?php include "popups.php"?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="order.js"></script>
</body>
</html>