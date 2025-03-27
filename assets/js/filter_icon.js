document.addEventListener("DOMContentLoaded", () => {
    const filterIconButton = document.querySelector('.filter-icon-button');
    const filterForm = document.querySelector('.filter-form');

    filterIconButton.addEventListener('click', () => {
        filterForm.classList.toggle('hidden');
    })

});