<?php
require_once('../../config.php');

// Ensure only admins can access the page.
require_login();
if (!is_siteadmin()) {
    redirect($CFG->wwwroot, get_string('accessdenied', 'admin'));
}

$PAGE->set_url('/local/challenge/index.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_heading('Support Time Tracker');

// Output the header.
echo $OUTPUT->header();
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
    input[type="date"]::before {
        content: "Pick a date";
        color: #aaa;
        font-size: 14px;
    }

    input[type="date"]:focus::before,
    input[type="date"]:valid::before {
        content: "";
    }

    input[type="date"] {
        width: 100%;
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
        color: #000;
    }

    input[type="date"]:focus {
        border-color: #0073aa;
        outline: none;
    }
</style>


<!-- Main Form Content -->
<h2 style="text-align: center;">Support Time Tracker</h2>

<form id="support-time-form" method="post" action="#">

    <!-- User Information -->
    <div style="margin-bottom: 20px;">
        <label for="name">Name</label>
        <input type="text" id="name" value="<?php echo fullname($USER) . ' (logged in user)'; ?>" readonly style="width: 100%; padding: 8px; margin-top: 5px;">
    </div>


    <div style="margin-bottom: 20px;">
    <label for="date">Select date</label>
    <input
        type="text"
        id="date"
        name="date"
        placeholder="Pick a date"
        required
        style="width: 100%; padding: 8px; margin-top: 5px; font-size: 14px; border-radius: 5px; border: 1px solid #ccc;">
</div>



    <!-- Support Time Inputs -->
    <div style="display: flex; gap: 20px; margin-top: 20px; flex-wrap: wrap;">
        <!-- Email Support Section -->
        <div style="flex: 1; border: 1px solid #ccc; padding: 15px; border-radius: 8px; min-width: 300px;">
            <h3>📧 Email Support</h3>
            <label>Level 1 (6 mins)</label>
            <input type="number" class="email-level" data-minutes="6" value="0" min="0" required style="width: 100%; padding: 8px; margin-bottom: 10px;">

            <label>Level 2 (15 mins)</label>
            <input type="number" class="email-level" data-minutes="15" value="0" min="0" required style="width: 100%; padding: 8px; margin-bottom: 10px;">

            <label>Level 3 (30 mins)</label>
            <input type="number" class="email-level" data-minutes="30" value="0" min="0" required style="width: 100%; padding: 8px; margin-bottom: 10px;">

            <label>Level 4 (45 mins)</label>
            <input type="number" class="email-level" data-minutes="45" value="0" min="0" required style="width: 100%; padding: 8px;">
        </div>

        <!-- Phone Support Section -->
        <div style="flex: 1; border: 1px solid #ccc; padding: 15px; border-radius: 8px; min-width: 300px;">
            <h3>📞 Phone Support</h3>
            <label>Level 1 (6 mins)</label>
            <input type="number" class="phone-level" data-minutes="6" value="0" min="0" required style="width: 100%; padding: 8px; margin-bottom: 10px;">

            <label>Level 2 (15 mins)</label>
            <input type="number" class="phone-level" data-minutes="15" value="0" min="0" required style="width: 100%; padding: 8px; margin-bottom: 10px;">

            <label>Level 3 (30 mins)</label>
            <input type="number" class="phone-level" data-minutes="30" value="0" min="0" required style="width: 100%; padding: 8px; margin-bottom: 10px;">

            <label>Level 4 (45 mins)</label>
            <input type="number" class="phone-level" data-minutes="45" value="0" min="0" required style="width: 100%; padding: 8px;">
        </div>
    </div>

    <!-- Total Support Time -->
    <div style="margin-top: 20px; text-align: center;">
        <h3>Total Support Time</h3>
        <p id="total-support-time">This day you provided <strong>0 minutes</strong> of support.</p>
    </div>

    <!-- Submit Button -->
    <div style="text-align: center;">
        <button type="submit" style="padding: 10px 20px; background-color: #0073aa; color: white; border: none; border-radius: 5px;">
            Submit
        </button>
    </div>

</form>

<script>
    // JavaScript for dynamic support time calculation
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
        document.getElementById('total-support-time').innerHTML = `This day you provided <strong>${totalMinutes} minutes</strong> of support.`;
    }

    flatpickr("#date", {
        dateFormat: "Y-m-d",
        allowInput: true,
    });
</script>

<?php
// Output the footer.
echo $OUTPUT->footer();
