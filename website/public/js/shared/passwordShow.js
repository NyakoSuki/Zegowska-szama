"use strict";

// Toggles password field visibility

function togglePassword(inp, btn)
{
    if (inp.type === "password")
    {
        inp.type = "text";
        btn.textContent = "Ukryj";
    }
    else
    {
        inp.type = "password";
        btn.textContent = "Pokaż";
    }
}

function setupToggle(inpId, btnId)
{
    const inp = document.getElementById(inpId);
    const btn = document.getElementById(btnId);

    if (!inp || !btn) return;

    btn.addEventListener("click", () =>
    {
        togglePassword(inp, btn);
    });
}

setupToggle("loginPasswordInp", "loginPasswordBtn");
setupToggle("signupPasswordInp", "signupPasswordBtn");
setupToggle("currentPasswordInp", "currentPasswordBtn");
setupToggle("newPasswordInp", "newPasswordBtn");
setupToggle("confirmPasswordInp", "confirmPasswordBtn");