"use strict";

// Select all product forms (one per product card + the "add new" form)
const createForm = document.querySelectorAll(".createForm");

const adminUpdateToast = document.getElementById('adminUpdateToast');
const toast = bootstrap.Toast.getOrCreateInstance(adminUpdateToast);
const result = document.getElementById("adminUpdateResult");

// Attach submit handler to every product form
createForm.forEach(form =>
{
    form.addEventListener("submit", (e) =>
    {
        e.preventDefault();

        // Include the submitter button so actionBtn value is sent correctly
        const formData = new FormData(e.currentTarget, e.submitter);

        fetch(window.CONFIG.BACKEND_URL + "admin/productUpdate.php",
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
            // Display success message in the toast
            result.innerHTML = data.message;
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

// Live image preview – updates whenever the filename input changes
const productImgInput = document.getElementById("productImgInput");
const productImg      = document.getElementById("productImg");

productImgInput.addEventListener("input", () =>
{
    productImg.src = window.CONFIG.PUBLIC_URL + "img/products/" + productImgInput.value;
});