<!-- ORDERING -->
<div
    class="modal fade"
    id="orderModal"
    tabindex="-1"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">

            <div class="modal-header">
                <h5 class="modal-title">Zamówienie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form
                    action="<?=BACKEND_URL?>cart/order.php"
                    method="post"
                >
                    <input
                        type="text"
                        name="name"
                        class="form-control mb-2"
                        placeholder="Imię"
                        required
                    >
                    <input
                        type="email"
                        name="email"
                        class="form-control mb-2"
                        placeholder="Email"
                        required
                    >
                    <p
                        class="h6">
                        Całkowita cena do zapłaty: <?=$totalPrice ?? '0';?> zł
                    </p>

                    <label class="fw-bold mb-1">Metoda płatności</label>
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="payment"
                            value="online"
                            disabled
                        >
                        <label class="form-check-label">💳 Online</label>
                    </div>
                    <div class="form-check mb-3">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="payment"
                            value="cod"
                            checked
                        >
                        <label class="form-check-label">📦 Przy odbiorze</label>
                    </div>
                    <button
                        type="submit"
                        class="btn btn-success w-100"
                    >
                        Zamawiam
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>





<!-- CLEARING CART -->
<div
    class="modal fade"
    id="clearModal"
    tabindex="-1"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-light rounded-4 shadow">

            <div class="modal-header">
                <h5 class="modal-title">Czy napewno chcesz wyczyścić koszyk?</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">
                <form
                    action="<?=BACKEND_URL?>cart/cartClear.php"
                    method="post"
                    class="w-100 h-75 d-flex gap-2"
                >
                    <button
                        type="submit"
                        class="btn btn-danger w-50">
                        Wyczyść
                    </button>
                    <button
                        type="button"
                        class="btn btn-success w-50"
                        data-bs-dismiss="modal">
                        Anuluj
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div
        id="addToCartToast"
        class="toast"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
    >

        <div class="toast-header">

            <img src="" class="rounded me-2" alt="">
            <strong class="me-auto h4">Koszyk</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>

        </div>

        <div class="toast-body">
            <p
                id="addToCartResult"
                class="h6"
            >

            </p>
        </div>

    </div>
</div>