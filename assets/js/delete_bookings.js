document.addEventListener('DOMContentLoaded', () => {
    const deleteBtns = document.querySelectorAll('#deleteBookingBtn');
    const wrapper = document.querySelector('#deleteConfirmWrapper');
    const cancelBtn = document.querySelector('#cancelDeleteBtn');
    const deleteBtn = document.querySelector('#deleteBtn');
    const mainFeedbackWrapper = document.querySelector('#mainFeedbackWrapper');
    const mainFeedbackText = document.querySelector('#mainFeedbackText');
    const mainFeedbackBtn = document.querySelector('#mainFeedbackButton');
    const body = document.querySelector('body');
    let selectedBookingId = null;

    deleteBtns.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            selectedBookingId = button.dataset.bookingId;
            wrapper.classList.remove('hidden');
        });
    });

    cancelBtn.addEventListener('click', () => {
        selectedBookingId = null;
        wrapper.classList.add('hidden');
    });

    deleteBtn.addEventListener('click', () => {
        if (!selectedBookingId) return;

        fetch('/assets/includes/delete_booking.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ bookingId: selectedBookingId })
        })
        .then(response => {
            if (response.ok) {
                wrapper.classList.add('hidden');
                mainFeedbackWrapper.classList.remove('hidden');
                body.classList.add('modal-active');
                mainFeedbackText.innerHTML += 'Foglalás törölve!';
                mainFeedbackText.style.color = 'var(--green)';
            } else {
                wrapper.classList.add('hidden');
                mainFeedbackWrapper.classList.remove('hidden');
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
            selectedBookingId = null;
        });
    });

    mainFeedbackBtn.addEventListener('click', () => {
        window.location.reload();
        main.classList.remove('modal-active')
    })
});