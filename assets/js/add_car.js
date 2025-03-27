const createCarBtn = document.querySelector('#createCarBtn');
const carModalWrapper = document.querySelector('#carModalWrapper');
const carModalContainer = document.querySelector('#carModalContainer');
const closeLoginModal = document.querySelector('#closeCarModal');
const addCarForm = document.querySelector('#addCarForm');
const feedback = document.querySelector('#feedback');
const mainFeedbackWrapper = document.querySelector('#mainFeedbackWrapper');
const mainFeedbackText = document.querySelector('#mainFeedbackText');
const mainFeedbackBtn = document.querySelector('#mainFeedbackButton');
const main = document.querySelector('body');

createCarBtn.addEventListener('click', () => {
    carModalWrapper.classList.remove('hidden');
    main.classList.add('modal-active');
});

closeLoginModal.addEventListener('click', () => {
    carModalWrapper.classList.add('hidden');
    main.classList.remove('modal-active');
});

carModalWrapper.addEventListener('click', (event) => {
    if (event.target === carModalWrapper) {
        carModalWrapper.classList.add('hidden');
        main.classList.remove('modal-active');
    }
});

addCarForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const year = parseInt(document.querySelector('#carYear').value, 10);
    const passengers = parseInt(document.querySelector('#carPassengers').value, 10);
    const price = parseInt(document.querySelector('#carPrice').value, 10);
    const currentYear = new Date().getFullYear();

    const requiredFields = ['#carBrand', '#carModel', '#carTransmission', '#carFuel', '#carPrice', '#carThumbnail'];
    for (const selector of requiredFields) {
        const field = document.querySelector(selector);
        if (!field.value.trim()) {
            feedback.innerHTML += "Minden mezőt ki kell tölteni!";
            feedback.style.color = 'var(--red)';
            return;
        }
    }

    if (!year || year > currentYear) {
        feedback.innerHTML += "Az évjárat nem lehet nagyobb, mint a jelenlegi év!";
        feedback.style.color = 'var(--red)';
        return;
    } 

    if (year < 1886) {
        feedback.innerHTML += "A legelső autó 1886-ban épült!";
        feedback.style.color = 'var(--red)';
        return;

    }

    if (!passengers || passengers < 0) {
        feedback.innerHTML += "Legalább 1 helynek kell lennie az autóban!";
        feedback.style.color = 'var(--red)';
        return;
    }

    if (!price || price < 0) {
        feedback.innerHTML += "Nem adhatod ingyen az autód!";
        feedback.style.color = 'var(--red)';
        return;
    }

    const formData = new FormData(addCarForm);

    await fetch('/assets/includes/add_car.php', {
        method: 'POST',
        body: formData
    })
        .then(response => {
            if(!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(text => {
            try {
                const data = JSON.parse(text);

                if (data.success) {
                    carModalWrapper.style.display = 'none';
                    mainFeedbackWrapper.classList.remove('hidden');
                    main.classList.add('modal-active');
                    mainFeedbackText.innerHTML += data.message;
                    mainFeedbackText.style.color = 'var(--green)';
                } else {
                    carModalWrapper.style.display = 'none';
                    mainFeedbackWrapper.classList.remove('hidden')
                    main.classList.add('modal-active');
                    mainFeedbackText.innerHTML += data.errors;
                    modalMessage.style.color = 'var(--red)';
                }
            } catch (error) {
                carModalWrapper.style.display = 'none';
                mainFeedbackWrapper.classList.remove('hidden')
                main.classList.add('modal-active');
                mainFeedbackText.innerHTML += 'Invalid server response.';
                console.error('JSON Parse Error:', error);
            }
        })
        .catch (error => {
            carModalWrapper.style.display = 'none';
                mainFeedbackWrapper.classList.remove('hidden')
                main.classList.add('modal-active');
                mainFeedbackText.innerHTML += 'Hiba történt a foglalás során';
                console.error('Error:', error);
        });
});

mainFeedbackBtn.addEventListener('click', () => {
    window.location.reload();
    main.classList.remove('modal-active')
})