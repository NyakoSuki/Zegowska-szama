"use strict";

const userSearchActive = document.getElementById("userSearchActive");
let userState = 2;


userSearchActive.addEventListener("click", ()=>
{
    userState = (userState + 1) % 3;
    userSearchActive.classList.remove
    (
        "btn-info",
        "btn-success",
        "btn-danger"
    );

    switch (userState)
    {
        case 0 : showUnactive(); break;
        case 1 : showActive(); break;
        case 2 : showAll(); break;
    }
});

function showAll()
{
    userSearchActive.textContent = "Wyświetla wszystkich";
    userSearchActive.classList.add("btn-info");
}

function showActive()
{
    userSearchActive.textContent = "Wyświetla aktywnych";
    userSearchActive.classList.add("btn-success");
}

function showUnactive()
{
    userSearchActive.textContent = "Wyświetla nieaktywnych";
    userSearchActive.classList.add("btn-danger");
}



const users = document.querySelectorAll(".user");
const userResetBtn = document.getElementById("userResetBtn");

const userSearchName = document.getElementById("userSearchName");
const userSearchEmail = document.getElementById("userSearchEmail");
const userSearchRole = document.getElementById("userSearchRole");


function filterUsers()
{
    const nameValue = userSearchName.value.toLowerCase();
    const emailValue = userSearchEmail.value.toLowerCase();
    const roleValue = userSearchRole.value.toLowerCase();
    const activeValue = userState;

    users.forEach(user => 
    {
        const userName = user.dataset.username;
        const userEmail = user.dataset.email;
        const userRole = user.dataset.role;
        const userActive = user.dataset.active;

        const matchName = userName.includes(nameValue);
        const matchEmail = userEmail.includes(emailValue);
        const matchRole = userRole.includes(roleValue);
        const matchActive = (Number(userActive) === userState || userState == 2);

        if (matchName && matchEmail && matchRole && matchActive)
        {
            user.hidden = false;
        } 
        else
        {
            user.hidden = true;
        }
    });
}

userSearchName.addEventListener("input", filterUsers);
userSearchEmail.addEventListener("input", filterUsers);
userSearchRole.addEventListener("input", filterUsers);

userSearchActive.addEventListener("click", filterUsers);

userResetBtn.addEventListener("click", () => 
{
    userSearchName.value = "";
    userSearchEmail.value = "";
    userSearchRole.value = "";
    userState = 2;
    showAll();
    filterUsers();
});





const userSelect = document.getElementById("userSelect");

userSelect.addEventListener("change", () => 
{
    const selected = userSelect.options[userSelect.selectedIndex];

    if (!selected.value) return;

    document.getElementById("userId").value = selected.dataset.id || "";
    document.getElementById("userName").value = selected.dataset.username || "";
    document.getElementById("userEmail").value = selected.dataset.email || "";
    document.getElementById("userRole").value = selected.dataset.role || "none";
    document.getElementById("userActive").checked = selected.dataset.active == 1;
});