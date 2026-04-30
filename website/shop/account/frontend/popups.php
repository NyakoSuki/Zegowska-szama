<?php
require_once dirname(__DIR__, 3) . "/config.php";
require_once BLOCKER_PATH;
include DB_PATH;
?>

<!-- USERNAME CHAHGE -->
<div class="modal fade" id="orderModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">

            <div class="modal-header">
                <h5 class="modal-title">Zamówienie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form action="<?=CART_B_URL?>order.php" method="post">

                <input
                    type="text"
                    name="name"
                    class="form-control mb-2"
                    placeholder="Imię"
                    required
                >

                <button type="submit" class="btn btn-success w-100">
                    Zamawiam
                </button>

                </form>

            </div>

        </div>
    </div>
</div>





<!-- PASSWORD CHAHGE -->
<div class="modal fade" id="e" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">

            <div class="modal-header">
                <h5 class="modal-title">Zamówienie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form action="<?=CART_B_URL?>order.php" method="post">

                <input
                    type="text"
                    name="name"
                    class="form-control mb-2"
                    placeholder="Imię"
                    required
                >

                <button type="submit" class="btn btn-success w-100">
                    Zamawiam
                </button>

                </form>

            </div>

        </div>
    </div>
</div>





<!-- ORDER DETAILS -->
<div class="modal fade" id="detailsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">

            <div class="modal-header">
                <h5 class="modal-title">Zamówienie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <input type="hidden" id="orderIdInput">
            <div class="modal-body">

            

            </div>

        </div>
    </div>
</div>