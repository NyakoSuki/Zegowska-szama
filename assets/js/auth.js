"use strict";

document.addEventListener("DOMContentLoaded", () => 
{
    const signinBtn = document.getElementById("loginBtn");
    const signupBtn = document.getElementById("signupBtn");
    const container = document.querySelector(".container-box");

    signinBtn.addEventListener("click", () =>
    {
        container.classList.remove("signup-active");
    });

    signupBtn.addEventListener("click", () =>
    {
        container.classList.add("signup-active");
    });

});