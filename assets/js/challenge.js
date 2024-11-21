// Add event listeners to all number input fields to trigger the calculation of total support time
document.querySelectorAll('input[type="number"]').forEach((input) => {
  input.addEventListener("input", calculateTotalSupportTime);
});

// Function to calculate the total support time based on user input
function calculateTotalSupportTime() {
  let totalMinutes = 0;

  // Sum email support times
  document.querySelectorAll(".email-level").forEach((input) => {
    totalMinutes += input.value * input.getAttribute("data-minutes");
  });

  // Sum phone support times
  document.querySelectorAll(".phone-level").forEach((input) => {
    totalMinutes += input.value * input.getAttribute("data-minutes");
  });

  // Update total support time display
  document.getElementById(
    "total-support-time"
  ).innerHTML = `<strong>This day you provided ${totalMinutes} minutes of support.</strong>`;
}

// Initialize Flatpickr date picker with specific options
document.addEventListener('DOMContentLoaded', () => {
  flatpickr('#date', {
      dateFormat: "Y-m-d",
      onClose: function(selectedDates, dateStr, instance) {
          // Check if a hidden input already exists, and remove it to prevent duplicates
          const existingTimestampInput = document.querySelector('input[name="date_timestamp"]');
          if (existingTimestampInput) {
              existingTimestampInput.remove();
          }

          if (selectedDates.length > 0) {
              const timestampInput = document.createElement('input');
              timestampInput.type = 'hidden';
              timestampInput.name = 'date_timestamp';
              timestampInput.value = Math.floor(selectedDates[0].getTime() / 1000);
              document.querySelector('#support-time-form').appendChild(timestampInput);
          }
      }
  });
});
