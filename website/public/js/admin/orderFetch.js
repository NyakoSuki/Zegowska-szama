// orderFetch.js – wysyła akcje na zamówieniu do orderUpdate.php i odświeża stronę

(function () {
    'use strict';

    const UPDATE_URL = window.CONFIG.BACKEND_URL + "admin/orderUpdate.php";
    const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
    const confirmBtn   = document.getElementById('confirmModalBtn');

    let pendingForm = null;


    // ── Pomocnik: wyślij POST fetch do orderUpdate.php ────────────────────────
    async function sendAction(formData)
    {
        const res  = await fetch(UPDATE_URL, { method: "POST", body: formData });
        const data = await res.json();

        if (data.success)
        {
            location.reload();
        }
        else
        {
            alert("Błąd: " + (data.message ?? "Nieznany błąd"));
        }
    }


    // ── Przyciski „Oznacz jako gotowe" i „Anuluj" – bezpośredni submit ────────
    document.querySelectorAll('form.order-action-form').forEach(form =>
    {
        form.addEventListener('submit', async (e) =>
        {
            e.preventDefault();
            await sendAction(new FormData(form));
        });
    });


    // ── Przycisk „Oznacz jako odebrane" – wymaga potwierdzenia w modalu ───────
    document.querySelectorAll('.needs-confirm').forEach(btn =>
    {
        btn.addEventListener('click', () =>
        {
            pendingForm = btn.closest('form');
            confirmModal.show();
        });
    });

    confirmBtn.addEventListener('click', async () =>
    {
        confirmModal.hide();
        if (pendingForm)
        {
            await sendAction(new FormData(pendingForm));
            pendingForm = null;
        }
    });

    document.getElementById('confirmModal').addEventListener('hidden.bs.modal', () =>
    {
        pendingForm = null;
    });

})();