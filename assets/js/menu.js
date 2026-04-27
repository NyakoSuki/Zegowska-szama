"use strict";

const menuBtn = document.querySelector(".menuBtn");
const menu = document.querySelector(".menu");

menuBtn.addEventListener('click', () => 
{
  menu.classList.toggle("disabled");
});