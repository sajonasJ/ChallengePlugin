// Dynamic Support Time Calculation
document.querySelectorAll('input[type="number"]').forEach(input => {
    input.addEventListener('input', calculateTotalSupportTime);
});

function calculateTotalSupportTime() {
    let totalMinutes = 0;

    // Sum email support times
    document.querySelectorAll('.email-level').forEach(input => {
        totalMinutes += input.value * input.getAttribute('data-minutes');
    });

    // Sum phone support times
    document.querySelectorAll('.phone-level').forEach(input => {
        totalMinutes += input.value * input.getAttribute('data-minutes');
    });

    // Update total support time display
    document.getElementById('total-support-time').innerHTML = `<strong>This day you provided ${totalMinutes} minutes of support.</strong>`;
}

// Initialize Flatpickr
flatpickr("#date", {
    dateFormat: "Y-m-d",
    allowInput: true,
});
