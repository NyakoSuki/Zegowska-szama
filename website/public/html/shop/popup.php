<div
    class="modal fade"
    id="cartAddModal"
    tabindex="-1"
>
    <div class="modal-dialog modal-dialog-centered modal-sm modal-fullscreen-sm-down">
        <div class="modal-content border-0 shadow-lg rounded-4">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">🛒 Dodaj do koszyka</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body pt-0">

                <form
                    id="addToCartForm"
                    class="d-flex flex-column gap-3"
                    method=""
                    action=""
                >

                    <div class="text-center">
                        <small class="text-muted">Produkt</small>
                        <h6 id="cartProductName" class="fw-semibold mb-0"></h6>
                    </div>

                    <div class="input-group input-group-lg">
                        <button
                            class="btn btn-outline-secondary"
                            type="button"
                            onclick="this.nextElementSibling.stepDown()"
                        >
                            −
                        </button>

                        <input
                            id="homeCartQtyInp"
                            name="quantity"
                            class="form-control text-center fw-bold"
                            value="1"
                            type="number"
                            min="1"
                            max=10
                        >

                        <button
                            class="btn btn-outline-secondary"
                            type="button"
                            onclick="this.previousElementSibling.stepUp()"
                        >
                            +
                        </button>
                    </div>

                    <input
                        id="homeCartIdInp"
                        name="id"
                        class=""
                        value=""
                        type="hidden"
                        placeholder=""
                    >

                    <input
                        id="homeCartNameInp"
                        name="name"
                        class=""
                        value=""
                        type="hidden"
                        placeholder=""
                    >

                    <button
                        id="homeCartAddBtn"
                        class="btn btn-info btn-lg w-100 fw-bold shadow-sm"
                        type="submit"
                    >
                        🛒 Dodaj do koszyka
                    </button>

                </form>

            </div>

        </div>
    </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div
        id="cartAddToast"
        class="toast border-0 shadow"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
    >
        <div class="toast-header border-0">

            <strong class="me-auto fw-bold">Koszyk</strong>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="toast"
                aria-label="Close"
            ></button>

        </div>

        <div class="toast-body">
            <p
                id="addToCartResult"
                name=""
                class="h6 mb-0"
            >
            </p>
        </div>

    </div>
</div>