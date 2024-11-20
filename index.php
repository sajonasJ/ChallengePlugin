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

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $DB;

    // Get form values
    $name = required_param('user-name', PARAM_TEXT);
    $date = required_param('date', PARAM_TEXT);
    $siteName = required_param('site-name', PARAM_TEXT);

    // Support time inputs
    $emailLevels = [
        'level1' => required_param('email-level-1', PARAM_INT),
        'level2' => required_param('email-level-2', PARAM_INT),
        'level3' => required_param('email-level-3', PARAM_INT),
        'level4' => required_param('email-level-4', PARAM_INT),
    ];

    $phoneLevels = [
        'level1' => required_param('phone-level-1', PARAM_INT),
        'level2' => required_param('phone-level-2', PARAM_INT),
        'level3' => required_param('phone-level-3', PARAM_INT),
        'level4' => required_param('phone-level-4', PARAM_INT),
    ];

    // Calculate total support time
    $totalSupportTime = (
        ($emailLevels['level1'] * 6) +
        ($emailLevels['level2'] * 15) +
        ($emailLevels['level3'] * 30) +
        ($emailLevels['level4'] * 45) +
        ($phoneLevels['level1'] * 6) +
        ($phoneLevels['level2'] * 15) +
        ($phoneLevels['level3'] * 30) +
        ($phoneLevels['level4'] * 45)
    );

    // Prepare record for database
    $record = new stdClass();
    $record->name = $name;
    $record->date = $date;
    $record->site = $siteName;
    $record->email_level1 = $emailLevels['level1'];
    $record->email_level2 = $emailLevels['level2'];
    $record->email_level3 = $emailLevels['level3'];
    $record->email_level4 = $emailLevels['level4'];
    $record->phone_level1 = $phoneLevels['level1'];
    $record->phone_level2 = $phoneLevels['level2'];
    $record->phone_level3 = $phoneLevels['level3'];
    $record->phone_level4 = $phoneLevels['level4'];
    $record->total_support_time = $totalSupportTime;

    // Insert record into the database and get the ID of the new record
    $inserted_id = $DB->insert_record('challenge_support_time', $record);

    if ($inserted_id) {
        echo 'Record inserted successfully with ID: ' . $inserted_id;
    } else {
        echo 'Database insert failed.';
    }
    die();


    // Redirect with a success message
    redirect($PAGE->url, 'Support time has been recorded successfully.', null, \core\output\notification::NOTIFY_SUCCESS);
}

// Output the header.
echo $OUTPUT->header();
?>

<!-- Link External CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="challenge.css">

<!-- Main Form Content -->
<main class="challenge-main" readonly>
    <form id="support-time-form" method="post" action="#">

        <!-- User Information -->
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-input" id="name" value="<?php echo fullname($USER) . ' (logged in user)'; ?>" readonly>
            <input type="hidden" name="user-name" value="<?php echo fullname($USER); ?>">
        </div>
        <!-- Date Picker -->
        <div class="form-group date-picker">
            <label for="date">Select date</label>
            <div class="input-container">
                <input type="text" class="form-input" id="date" name="date" placeholder="Pick a date" required>
                <i class="fa-solid fa-calendar"></i>
            </div>
        </div>

        <!-- Site Information -->
        <div class="form-group">
            <label for="site-name">Site name</label>
            <select class="form-input" id="site-name" name="site-name" required>
                <option value="" disabled selected>Select site</option>
                <option value="Gold Coast University Hospital">Gold Coast University Hospital</option>
                <option value="Robina Hospital">Robina Hospital</option>
                <option value="Varsity Lakes Day Hospital">Varsity Lakes Day Hospital</option>
                <!-- Add more options as needed -->
            </select>
        </div>

        <!-- Support Time Inputs -->
        <div class="support-sections">
            <!-- Email Support Section -->
            <div class="support-section">
                <h3><i class="fas fa-envelope"></i> Email Support</h3>
                <label>Level 1 (6 mins)</label>
                <input type="number" class="form-input email-level" name="email-level-1" data-minutes="6" value="0" min="0" required>
                <label>Level 2 (15 mins)</label>
                <input type="number" class="form-input email-level" name="email-level-2" data-minutes="15" value="0" min="0" required>
                <label>Level 3 (30 mins)</label>
                <input type="number" class="form-input email-level" name="email-level-3" data-minutes="30" value="0" min="0" required>
                <label>Level 4 (45 mins)</label>
                <input type="number" class="form-input email-level" name="email-level-4" data-minutes="45" value="0" min="0" required>
            </div>

            <!-- Phone Support Section -->
            <div class="support-section">
                <h3><i class="fa-solid fa-phone"></i> Phone Support</h3>
                <label>Level 1 (6 mins)</label>
                <input type="number" class="form-input phone-level" name="phone-level-1" data-minutes="6" value="0" min="0" required>
                <label>Level 2 (15 mins)</label>
                <input type="number" class="form-input phone-level" name="phone-level-2" data-minutes="15" value="0" min="0" required>
                <label>Level 3 (30 mins)</label>
                <input type="number" class="form-input phone-level" name="phone-level-3" data-minutes="30" value="0" min="0" required>
                <label>Level 4 (45 mins)</label>
                <input type="number" class="form-input phone-level" name="phone-level-4" data-minutes="45" value="0" min="0" required>
            </div>
        </div>


        <!-- Total Support Time -->
        <div class="total-time">
            <h3><i class="fa-regular fa-clock"></i> Total Support Time</h3>
            <p id="total-support-time"><strong>This day you provided 0 minutes of support.</strong></p>
        </div>

        <!-- Submit Button -->
        <div class="form-group">
            <button type="submit" class="form-button">Submit</button>
        </div>

    </form>
</main>

<!-- Link External JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="challenge.js"></script>

<?php
// Output the footer.
echo $OUTPUT->footer();
