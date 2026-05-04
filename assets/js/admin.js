"use strict";

const userActive = document.getElementById("userActive");
let state = 2;


userActive.addEventListener("click", ()=>
{
    state = (state + 1) % 3;

switch (state)
{
    case 0 : showUnactive(); break;
    case 1 : showActive(); break;
    case 2 : showAll(); break;
}
});

function showAll()
{
    userActive.textContent = "Wyświetla wszystkich";
    userActive.classList.add("btn-secondary");
    userActive.classList.remove("btn-success");
    userActive.classList.remove("btn-danger");
}

function showActive()
{
    userActive.textContent = "Wyświetla aktywnych";
    userActive.classList.add("btn-success");
    userActive.classList.remove("btn-danger");
}

function showUnactive()
{
    userActive.textContent = "Wyświetla nieaktywnych";
    userActive.classList.add("btn-danger");
    userActive.classList.remove("btn-secondary");
}



const users = document.querySelectorAll(".user");
const resetBtn = document.getElementById("resetBtn");

const searchName = document.getElementById("searchName");
const searchEmail = document.getElementById("searchEmail");
const searchRole = document.getElementById("searchRole");


function filterUsers()
{
    const nameValue = searchName.value.toLowerCase();
    const emailValue = searchEmail.value.toLowerCase();
    const roleValue = searchRole.value.toLowerCase();
    const activeValue = state;

    users.forEach(user => 
    {
        const userName = user.dataset.username;
        const userEmail = user.dataset.email;
        const userRole = user.dataset.role;
        const userActive = user.dataset.active;

        const matchName = userName.includes(nameValue);
        const matchEmail = userEmail.includes(emailValue);
        const matchRole = userRole.includes(roleValue);
        const matchActive = (Number(userActive) === state || state == 2);

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

searchName.addEventListener("input", filterUsers);
searchEmail.addEventListener("input", filterUsers);
searchRole.addEventListener("input", filterUsers);

userActive.addEventListener("click", filterUsers);

resetBtn.addEventListener("click", () => 
{
    searchName.value = "";
    searchEmail.value = "";
    searchRole.value = "";
    state = 2;
    showAll();
    filterUsers();
});





const userSelect = document.getElementById("userSelect");

userSelect.addEventListener("change", () => 
{
    const selected = userSelect.options[userSelect.selectedIndex];

    if (!selected.value) return;

    document.getElementById("userChangeId").value = selected.dataset.id || "";
    document.getElementById("userChangeName").value = selected.dataset.username || "";
    document.getElementById("userChangeEmail").value = selected.dataset.email || "";
    document.getElementById("userChangeRole").value = selected.dataset.role || "none";
    document.getElementById("userChangeActive").checked = selected.dataset.active == 1;
});