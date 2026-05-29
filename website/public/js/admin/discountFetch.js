"use strict";

const adminUpdateToast = document.getElementById('adminUpdateToast');
const toast = bootstrap.Toast.getOrCreateInstance(adminUpdateToast);
const result = document.getElementById("adminUpdateResult");

document.querySelectorAll(".createDiscountForm").forEach(form =>
{
    form.addEventListener("submit", (e) =>
    {
        e.preventDefault();
        const formData = new FormData(e.currentTarget, e.submitter);

        fetch(window.CONFIG.BACKEND_URL + "admin/discountUpdate.php",
        {
            method: "POST",
            body: formData
        })
        .then(async (response) =>
        {
            const data = await response.json();

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
                card?.remove();
            }
            else
            {
                setTimeout(() => location.reload(), 800);
            }
        })
        .catch((error) =>
        {
            result.innerHTML = error;
        })
        .finally(() =>
        {
            toast.show();
        });
    });
});