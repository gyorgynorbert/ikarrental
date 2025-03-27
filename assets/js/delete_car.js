document.addEventListener('DOMContentLoaded', () => {
    const deleteCarBtn = document.querySelector('#deleteCarBtn');
    const wrapper = document.querySelector('#deleteConfirmWrapper');
    const cancelBtn = document.querySelector('#cancelDeleteBtn');
    const deleteBtn = document.querySelector('#deleteBtn');
    const mainFeedbackWrapper = document.querySelector('#mainFeedbackWrapper');
    const mainFeedbackText = document.querySelector('#mainFeedbackText');
    const mainFeedbackBtn = document.querySelector('#mainFeedbackButton');
    const body = document.querySelector('body');
    let selectedCarId = null;

    deleteCarBtn.addEventListener('click', (e) => {
        e.preventDefault();
        selectedCarId = deleteCarBtn.dataset.carId;
        wrapper.classList.remove('hidden-wrapper');
    });

    cancelBtn.addEventListener('click', () => {
        selectedCarId = null;
        wrapper.classList.add('hidden-wrapper');
    });

    deleteBtn.addEventListener('click', () => {
        console.log('a');
        if (!selectedCarId) return;
        console.log('b');

        fetch('/assets/includes/delete_car.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ carId: selectedCarId })
        })
        .then(response => {
            if (response.ok) {
                wrapper.classList.add('hidden-wrapper');
                mainFeedbackWrapper.classList.remove('hidden-wrapper');
                body.classList.add('modal-active');
                mainFeedbackText.innerHTML += 'Foglalás törölve!';
                mainFeedbackText.style.color = 'var(--green)';
            } else {
                wrapper.classList.add('hidden-wrapper');
                mainFeedbackWrapper.classList.remove('hidden-wrapper');
                body.classList.add('modal-active');
                mainFeedbackText.innerHTML += 'Hiba történt a foglalás törlése közben!';
                mainFeedbackText.style.color = 'var(--red)';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hálózati hiba történt!');
        })
        .finally(() => {
            selectedCarId = null;
        });
    });

    mainFeedbackBtn.addEventListener('click', () => {
        window.location.href = 'profile.php';
        body.classList.remove('modal-active')
    })
});