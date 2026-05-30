"use strict";

const adminUpdateToast = document.getElementById('adminUpdateToast');
const toast = bootstrap.Toast.getOrCreateInstance(adminUpdateToast);
const result = document.getElementById("adminUpdateResult");

// Attach submit handler to every discount form (both "add" and "delete" actions)
document.querySelectorAll(".createDiscountForm").forEach(form =>
{
    form.addEventListener("submit", (e) =>
    {
        e.preventDefault();

        // Include the submitter button so actionBtn value is sent correctly
        const formData = new FormData(e.currentTarget, e.submitter);

        fetch(window.CONFIG.BACKEND_URL + "admin/discountUpdate.php",
        {
            method: "POST",
            body: formData
        })
        .then(async (response) =>
        {
            const data = await response.json();

            // Treat non-2xx responses as errors using the message from the server
            if (!response.ok)
            {
                throw new Error(data.message);
            }

            return data;
        })
        .then((data) =>
        {
            result.innerHTML = data.message;

            const action = e.submitter?.value ?? "";
            const card   = form.closest(".col-12");

            if (action === "delete")
            {
                // Remove the card from the DOM immediately without reloading
                card?.remove();
            }
            else
            {
                // Reload after a short delay so the user can read the success message
                setTimeout(() => location.reload(), 800);
            }
        })
        .catch((error) =>
        {
            // Display server or network error message in the toast
            result.innerHTML = error;
        })
        .finally(() =>
        {
            // Always show the toast regardless of success or failure
            toast.show();
        });
    });
});