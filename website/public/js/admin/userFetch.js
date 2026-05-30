// userFetch.js – wysyła akcje na użytkowniku do userUpdate.php i odświeża stronę

(function () {
    'use strict';

    const UPDATE_URL   = window.CONFIG.BACKEND_URL + "admin/userUpdate.php";
    const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
    const confirmBtn   = document.getElementById('confirmModalBtn');
    const modalTitle   = document.getElementById('confirmModalTitle');
    const modalBody    = document.getElementById('confirmModalBody');

    let pendingForm = null;

    const messages = {
        deactivate:   {
            title: 'Dezaktywuj konto',
            body:  (u) => `Czy na pewno chcesz dezaktywować konto użytkownika <strong>${u}</strong>? Nie będzie mógł się zalogować.`,
            btn:   'btn-warning'
        },
        make_admin:   {
            title: 'Nadaj uprawnienia',
            body:  (u) => `Czy na pewno chcesz nadać użytkownikowi <strong>${u}</strong> uprawnienia admina?`,
            btn:   'btn-danger'
        },
        remove_admin: {
            title: 'Odbierz uprawnienia',
            body:  (u) => `Czy na pewno chcesz odebrać uprawnienia admina użytkownikowi <strong>${u}</strong>?`,
            btn:   'btn-danger'
        },
    };


    // ── Pomocnik: wyślij POST fetch do userUpdate.php ─────────────────────────
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


    // ── Przyciski „Aktywuj" – bezpośredni submit ──────────────────────────────
    document.querySelectorAll('form.user-action-form').forEach(form =>
    {
        form.addEventListener('submit', async (e) =>
        {
            e.preventDefault();
            await sendAction(new FormData(form));
        });
    });


    // ── Przyciski wymagające potwierdzenia ────────────────────────────────────
    document.querySelectorAll('.needs-confirm').forEach(btn =>
    {
        btn.addEventListener('click', () =>
        {
            const action   = btn.dataset.action;
            const username = btn.dataset.username;
            const cfg      = messages[action];

            modalTitle.textContent = cfg.title;
            modalBody.innerHTML    = cfg.body(username);
            confirmBtn.className   = `btn ${cfg.btn}`;
            confirmBtn.textContent = 'Potwierdź';
            pendingForm            = btn.closest('form');

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