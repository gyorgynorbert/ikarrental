document.addEventListener("DOMContentLoaded", () => {
    const filterForm = document.querySelector(".filter-form");
    const carGrid = document.querySelector(".main-content-grid-wrapper");

    filterForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData(filterForm);
        const queryString = new URLSearchParams(formData).toString();
        try {
            const response = await fetch("/assets/includes/filter_cars.php?" + queryString, {
                method: "GET",
            });

            if (response.ok) {
                const html = await response.text();
                carGrid.innerHTML = html;
            } else {
                console.error("Failed to fetch data:", response.statusText);
            }
        } catch (error) {
            console.error("Error during fetch:", error);
        }
    });
});