<div
    class="modal fade"
    id="cartAddModal"
    tabindex="-1"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-light rounded-4 shadow">

            <div class="modal-header">
                <h5 class="modal-title">Podaj ilość</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">
                <form
                    id="addToCartForm"
                    class="w-100 h-75 d-flex gap-2"
                    method=""
                    action=""
                >
                    <input
                        id="homeCartQtyInp"
                        name="quantity"
                        class=""
                        value="1"
                        type="number"
                        placeholder=""
                    >
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
                        class=""
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
                name=""
                class="h6"
            >

            </p>
        </div>

    </div>
</div>