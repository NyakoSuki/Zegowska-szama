<?php
// orderGenerate.php – funkcje generujące fragmenty HTML dla zamówień

$statusLabels = ['pending' => 'Oczekujące', 'ready' => 'Gotowe', 'claimed' => 'Odebrane', 'canceled' => 'Anulowane'];
$nextStep     = ['pending' => 'ready', 'ready' => 'claimed'];


function renderOrderCardHeader(array $order, array $statusLabels): void
{
    $oid    = $order['order_id'];
    $status = $order['status'];
    $label  = $statusLabels[$status] ?? $status;
    $date   = htmlspecialchars($order['created_at']);
    echo <<<HTML
    <div class="card-header d-flex align-items-center gap-2">
        <strong>#$oid</strong>
        <span class="badge badge-$status rounded-pill">$label</span>
        <span class="ms-auto text-muted small">$date</span>
    </div>
    HTML;
}


function renderCustomerInfo(array $order): void
{
    $name  = htmlspecialchars($order['customer_name']);
    $email = htmlspecialchars($order['email']);
    $total = number_format((float)$order['total_price'], 2, ',', ' ');
    echo <<<HTML
    <div class="col-12 col-md-4">
        <p class="mb-1"><strong>Klient:</strong> $name</p>
        <p class="mb-1"><strong>E-mail:</strong> <a href="mailto:$email">$email</a></p>
        <p class="mb-0"><strong>Łącznie:</strong> $total zł</p>
    </div>
    HTML;
}


function renderProductsTable(array $products): void
{
    echo <<<HTML
    <div class="col-12 col-md-5">
        <table class="table table-sm table-striped mb-0">
            <thead>
                <tr>
                    <th>Produkt</th>
                    <th class="text-end">Cena</th>
                    <th class="text-end">Ilość</th>
                    <th class="text-end">Suma</th>
                </tr>
            </thead>
            <tbody>
    HTML;

    foreach ($products as $p) {
        $name  = htmlspecialchars($p['product_name']);
        $price = number_format((float)$p['product_price'], 2, ',', ' ');
        $qty   = (int)$p['quantity'];
        $total = number_format((float)$p['product_total'], 2, ',', ' ');
        echo <<<HTML
                <tr>
                    <td>$name</td>
                    <td class="text-end">$price zł</td>
                    <td class="text-end">$qty</td>
                    <td class="text-end">$total zł</td>
                </tr>
        HTML;
    }

    echo <<<HTML
            </tbody>
        </table>
    </div>
    HTML;
}


function renderOrderActions(array $order, array $nextStep): void
{
    $oid    = $order['order_id'];
    $status = $order['status'];

    echo '<div class="col-12 col-md-3 d-flex flex-column justify-content-center gap-2">';

    if (isset($nextStep[$status])) {
        $next   = $nextStep[$status];
        $action = ($next === 'claimed') ? 'delete' : 'update';

        echo '<form class="order-action-form">';
        echo "<input type=\"hidden\" name=\"order_id\"  value=\"$oid\">";
        echo "<input type=\"hidden\" name=\"status\"    value=\"$next\">";
        echo "<input type=\"hidden\" name=\"actionBtn\" value=\"$action\">";

        if ($next === 'claimed') {
            echo <<<HTML
            <button type="button" class="btn btn-success w-100 btn-sm needs-confirm">
                Oznacz jako odebrane
            </button>
            HTML;
        } else {
            echo '<button type="submit" class="btn btn-primary w-100 btn-sm">Oznacz jako gotowe</button>';
        }

        echo '</form>';
    }

    if ($status !== 'canceled' && $status !== 'claimed') {
        echo <<<HTML
        <form class="order-action-form">
            <input type="hidden" name="order_id"  value="$oid">
            <input type="hidden" name="status"    value="canceled">
            <input type="hidden" name="actionBtn" value="delete">
            <button type="submit" class="btn btn-danger w-100 btn-sm">Anuluj zamówienie</button>
        </form>
        HTML;
    }

    if ($status === 'claimed' || $status === 'canceled') {
        echo '<span class="text-muted small fst-italic">Brak akcji</span>';
    }

    echo '</div>';
}


function renderOrderCard(array $order, array $statusLabels, array $nextStep): void
{
    $oid    = $order['order_id'];
    $status = $order['status'];
    $name   = strtolower(htmlspecialchars($order['customer_name']));
    $email  = strtolower(htmlspecialchars($order['email']));
    $price  = (float)$order['total_price'];

    echo <<<HTML
    <div class="card order-card shadow-sm"
         data-status="$status"
         data-name="$name"
         data-email="$email"
         data-orderid="$oid"
         data-price="$price">
    HTML;

    renderOrderCardHeader($order, $statusLabels);

    echo '<div class="card-body"><div class="row g-3">';
    renderCustomerInfo($order);
    renderProductsTable($order['products']);
    renderOrderActions($order, $nextStep);
    echo '</div></div></div>';
}