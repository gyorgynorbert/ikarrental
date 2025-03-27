document.addEventListener("DOMContentLoaded", () => {
    const bookingForm = document.querySelector('#bookingForm');
    const modalOverlay = document.querySelector('#modalOverlayBook');
    const modalMessage = document.querySelector('#modalBody');
    const okBtn = document.querySelector('#okBtn');
    const goToBtn = document.querySelector('#goToBtn');
    const retryBtn = document.querySelector('#retryBtn');

    console.log(modalOverlay);

    bookingForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        console.log('a1');

        const formData = new FormData(bookingForm);

        const formatter = new Intl.NumberFormat('hu-HU',{
            style: "currency",
            currency: "HUF",
        });

        await fetch('/assets/includes/book.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text(); 
            })
            .then(text => {
                try {
                    const data = JSON.parse(text);
                    if (data.success) {
                        modalOverlay.classList.remove('hidden-book');
                        goToBtn.classList.remove('hide-on-fail');
                        okBtn.classList.remove('hide-on-fail');
                        modalMessage.innerHTML += data.message + '<br>' + data.details.from + '-tól ' + data.details.to + '-ig. <br>' +
                        formatter.format(data.details.price_per_day) + ' napi árral.<br> Összesen: ' + formatter.format(data.details.total_price);
                        modalMessage.style.color = 'var(--green)';
                    } else {
                        modalOverlay.classList.remove('hidden-book');
                        retryBtn.classList.remove('hide-on-success');
                        modalMessage.innerHTML += data.errors.conflict;
                        modalMessage.style.color = 'var(--red)';
                    }
                } catch (err) {
                    modalOverlay.classList.remove('hidden-book');                 
                    modalMessage.innerHTML += 'Invalid server response.';
                    modalMessage.style.color = 'var(--red)';
                    retryBtn.classList.remove('hide-on-success');
                    console.error('JSON Parse Error:', err);
                }
            })
            .catch(error => {
                modalOverlay.classList.remove('hidden-book');         
                modalMessage.innerHTML += 'Hiba történt a foglalás során!';
                modalMessage.style.color = 'var(--red)';
                retryBtn.classList.remove('hide-on-success');
                console.error('Error:', error);
            });
    });

    okBtn.addEventListener('click', () => {
        modalOverlay.style.display = 'none';
        window.location.href = 'index.php';
    });

    goToBtn.addEventListener('click', () => {
        modalOverlay.style.display = 'none';
        window.location.href = 'profile.php';
    });

    retryBtn.addEventListener('click', () => {
        window.location.reload();
    })
});
