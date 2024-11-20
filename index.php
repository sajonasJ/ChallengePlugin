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

<!-- Link External CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="challenge.css">

<!-- Main Form Content -->
<main readonly>
    <form id="support-time-form" method="post" action="#">

        <!-- User Information -->
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" value="<?php echo fullname($USER) . ' (logged in user)'; ?>" readonly>
        </div>

        <!-- Date Picker -->
        <div class="form-group">
            <label for="date">Select date</label>
            <input type="text" id="date" name="date" placeholder="Pick a date" required>
        </div>

        <!-- Support Time Inputs -->
        <div class="support-sections">
            <!-- Email Support Section -->
            <div class="support-section">
            <h3><i class="fas fa-envelope"></i> Email Support</h3>
                <label>Level 1 (6 mins)</label>
                <input type="number" class="email-level" data-minutes="6" value="0" min="0" required>
                <label>Level 2 (15 mins)</label>
                <input type="number" class="email-level" data-minutes="15" value="0" min="0" required>
                <label>Level 3 (30 mins)</label>
                <input type="number" class="email-level" data-minutes="30" value="0" min="0" required>
                <label>Level 4 (45 mins)</label>
                <input type="number" class="email-level" data-minutes="45" value="0" min="0" required>
            </div>

            <!-- Phone Support Section -->
            <div class="support-section">
                <h3><i class="fa-solid fa-phone"></i> Phone Support</h3>
                <label>Level 1 (6 mins)</label>
                <input type="number" class="phone-level" data-minutes="6" value="0" min="0" required>
                <label>Level 2 (15 mins)</label>
                <input type="number" class="phone-level" data-minutes="15" value="0" min="0" required>
                <label>Level 3 (30 mins)</label>
                <input type="number" class="phone-level" data-minutes="30" value="0" min="0" required>
                <label>Level 4 (45 mins)</label>
                <input type="number" class="phone-level" data-minutes="45" value="0" min="0" required>
            </div>
        </div>

        <!-- Total Support Time -->
        <div class="total-time">
            <h3><i class="fa-regular fa-clock"></i> Total Support Time</h3>
            <p id="total-support-time"><strong>This day you provided 0 minutes of support.</strong></p>
        </div>

        <!-- Submit Button -->
        <div class="form-group">
            <button type="submit">Submit</button>
        </div>

    </form>
</main>

<!-- Link External JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="challenge.js"></script>

<?php
// Output the footer.
echo $OUTPUT->footer();
