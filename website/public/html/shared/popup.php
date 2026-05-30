<!--
< ====================CART INFO====================
 -> showes up in corner and gives user appropriate response
< ==================================================
-->
<div
    class="toast-container position-fixed bottom-0 end-0 p-3"
>
    <div
        id="cartAddToast"
        class="toast border-0 shadow"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
    >
        <div
            class="toast-header border-0"
        >
            <strong
                class="me-auto fw-bold"
            >
                Koszyk
            </strong>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="toast"
                aria-label="Close"
            >
            </button>
        </div>

        <div
            class="toast-body"
        >
            <p
                id="addToCartResult"
                name=""
                class="h6 mb-0"
            >
            </p>
        </div>
    </div>
</div>