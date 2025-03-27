document.addEventListener("DOMContentLoaded", () => {
    const toggleButton = document.querySelector(".price-toggle-button");
    const priceDropdown = document.querySelector(".price-dropdown");
    const applyPriceButton = document.querySelector(".apply-price");

    toggleButton.addEventListener("click", () => {
        priceDropdown.style.display =
            priceDropdown.style.display === "none" || !priceDropdown.style.display
                ? "block"
                : "none";
    });

    applyPriceButton.addEventListener("click", () => {
        const priceFrom = document.querySelector("#price_from").value;
        const priceTo = document.querySelector("#price_to").value;

        if (priceFrom || priceTo) {
            toggleButton.textContent = `${priceFrom || "Min"} - ${priceTo || "Max"} (ezer) Ft`;
        } else {
            toggleButton.textContent = "Összes";
        }

        priceDropdown.style.display = "none";
    });

    document.addEventListener("click", (event) => {
        if (!event.target.closest(".price-chip")) {
            priceDropdown.style.display = "none";
        }
    });
});
