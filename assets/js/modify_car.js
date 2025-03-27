const modifyCarBtn = document.querySelector('#modifyCarBtn');
const modifyCarWrapper = document.querySelector('#modifyCarWrapper');
const modifyCarContainer = document.querySelector('#modifyCarContainer');
const closeModifyCar = document.querySelector('#closeModifyCar');
const modifyCarForm = document.querySelector('#modifyCarForm');
const feedback = document.querySelector('#feedback');
const mainFeedbackWrapper = document.querySelector('#mainFeedbackWrapper');
const mainFeedbackText = document.querySelector('#mainFeedbackText');
const mainFeedbackBtn = document.querySelector('#mainFeedbackButton');
const body = document.querySelector('body');

modifyCarBtn.addEventListener('click', () => {
    modifyCarWrapper.classList.remove('hidden-wrapper');
    body.classList.add('modal-active');
});

closeModifyCar.addEventListener('click', () => {
    modifyCarWrapper.classList.add('hidden-wrapper');
    body.classList.remove('modal-active');
});

modifyCarWrapper.addEventListener('click', (event) => {
    if (event.target === modifyCarWrapper) {
        modifyCarWrapper.classList.add('hidden-wrapper');
        body.classList.remove('modal-active');
    }
});

modifyCarForm.addEventListener('submit', async (e) => {
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

    const formData = new FormData(modifyCarForm);

    await fetch('/assets/includes/modify_car.php', {
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
                    modifyCarWrapper.style.display = 'none';
                    mainFeedbackWrapper.classList.remove('hidden-wrapper');
                    body.classList.add('modal-active');
                    mainFeedbackText.innerHTML += data.message;
                    mainFeedbackText.style.color = 'var(--green)';
                } else {
                    modifyCarWrapper.style.display = 'none';
                    mainFeedbackWrapper.classList.remove('hidden-wrapper')
                    body.classList.add('modal-active');
                    mainFeedbackText.innerHTML += data.errors;
                    modalMessage.style.color = 'var(--red)';
                }
            } catch (error) {
                modifyCarWrapper.style.display = 'none';
                mainFeedbackWrapper.classList.remove('hidden-wrapper')
                body.classList.add('modal-active');
                mainFeedbackText.innerHTML += 'Invalid server response.';
                console.error('JSON Parse Error:', error);
            }
        })
        .catch (error => {
                modifyCarWrapper.style.display = 'none';
                mainFeedbackWrapper.classList.remove('hidden-wrapper')
                body.classList.add('modal-active');
                mainFeedbackText.innerHTML += 'Hiba történt a foglalás során';
                console.error('Error:', error);
        });
});

mainFeedbackBtn.addEventListener('click', () => {
    window.location.reload();
    body.classList.remove('modal-active')
})