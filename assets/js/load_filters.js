document.addEventListener("DOMContentLoaded", async () => {
    try {
        const response = await fetch("/assets/includes/load_filters.php");
        if (!response.ok) throw new Error("Hiba a szűrök betöltése során!");

        const data = await response.json();

        populateFilterOptions('brand', data.brands);
        populateFilterOptions('year', data.years);
        populateFilterOptions('passengers', data.passengers);
        populateFilterOptions('fuel_type', data.fuel_types);
        populateFilterOptions('transmission', data.transmissions);
    } catch (error) {
        console.error("Hiba a szűrök betöltése során!:", error);
    }

    function populateFilterOptions(filterId, options) {
        const selectElement = document.getElementById(filterId);
        if (!selectElement) return;

        options.forEach(option => {
            const opt = document.createElement("option");
            opt.value = option;
            opt.textContent = option;
            selectElement.appendChild(opt);
        });
    }

});