<div
    class="modal fade"
    id="orderModal"
    tabindex="-1"
>
    <div
        class="modal-dialog modal-dialog-centered"
    >
        <div
            class="modal-content rounded-4 shadow"
        >
            <div
                class="modal-header"
            >
                <p
                    class="modal-title h5"
                >
                    Zamówienie
                </p>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                >
                </button>
            </div>

            <div
                class="modal-body"
            >
                <form
                    action="<?=BACKEND_URL?>cart/cartOrder.php"
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
                        class="h6"
                    >
                        Całkowita cena do zapłaty: <?=$totalPrice ?? '0';?> zł
                    </p>

                    <label
                        class="fw-bold mb-1"
                    >
                        Metoda płatności
                    </label>
                    <div
                        class="form-check"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            name="payment"
                            value="online"
                            disabled
                        >
                        <label
                            class="form-check-label"
                        >
                            💳 Online
                        </label>
                    </div>

                    <div
                        class="form-check mb-3"
                    >
                        <input
                            class="form-check-input"
                            type="radio"
                            name="payment"
                            value="cod"
                            checked
                        >
                        <label
                            class="form-check-label"
                        >
                            📦 Przy odbiorze
                        </label>
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



<div
    class="modal fade"
    id="clearModal"
    tabindex="-1"
>
    <div
        class="modal-dialog modal-dialog-centered"
    >
        <div
            class="modal-content bg-light rounded-4 shadow"
        >
            <div
                class="modal-header"
            >
                <p
                    class="modal-title h5"
                >
                    Czy napewno chcesz wyczyścić koszyk?
                </p>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <div
            class="modal-body">
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