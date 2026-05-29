document.addEventListener("DOMContentLoaded", () =>
{
    const filterMin        = document.getElementById("filterMin");
    const filterMax        = document.getElementById("filterMax");
    const filterIsActive   = document.getElementById("filterIsActive");
    const filterIsExpired  = document.getElementById("filterIsExpired");
    const filterIsFuture   = document.getElementById("filterIsFuture");
    const resetBtn         = document.getElementById("resetFiltersBtn");

    function applyFilters()
    {
        const min = filterMin.value !== "" ? parseFloat(filterMin.value) : null;
        const max = filterMax.value !== "" ? parseFloat(filterMax.value) : null;

        const showActive  = filterIsActive.checked;
        const showExpired = filterIsExpired.checked;
        const showFuture  = filterIsFuture.checked;

        const now = Date.now();

        document.querySelectorAll(".product[data-action='update']").forEach(card =>
        {
            const procent = parseInt(card.dataset.procent);
            const start   = new Date(card.dataset.start).getTime();
            const end     = new Date(card.dataset.end).getTime();

            // Determine status
            let status = "future";
            if (now >= start && now <= end) status = "active";
            else if (now > end)             status = "expired";

            const passStatus =
                (status === "active"  && showActive)  ||
                (status === "expired" && showExpired) ||
                (status === "future"  && showFuture);

            const passMin = min === null || procent >= min;
            const passMax = max === null || procent <= max;

            const visible = passStatus && passMin && passMax;
            card.closest(".col-12").style.display = visible ? "" : "none";
        });
    }

    [filterMin, filterMax, filterIsActive, filterIsExpired, filterIsFuture]
        .forEach(el => el.addEventListener("input", applyFilters));

    resetBtn.addEventListener("click", () =>
    {
        filterMin.value       = "";
        filterMax.value       = "";
        filterIsActive.checked  = true;
        filterIsExpired.checked = true;
        filterIsFuture.checked  = true;
        applyFilters();
    });
});