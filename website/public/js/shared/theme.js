const themeToggle = document.getElementById("themeToggle");

function setTheme(theme)
{
    if(theme === "dark")
    {
        document.body.classList.add("darkTheme");
    }
    else
    {
        document.body.classList.remove("darkTheme");
    }

    localStorage.setItem("theme", theme);
}

const savedTheme = localStorage.getItem("theme") || "light";

setTheme(savedTheme);

themeToggle.addEventListener("click", () =>
{
    if(document.body.classList.contains("darkTheme"))
    {
        setTheme("light");
    }
    else
    {
        setTheme("dark");
    }
});