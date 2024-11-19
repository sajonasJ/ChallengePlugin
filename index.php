<?php
require_once('../../config.php');

$PAGE->set_url('/local/challenge/index.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Challenge Plugin');
$PAGE->set_heading('Challenge Plugin');

// Output the header.
echo $OUTPUT->header();
?>

<!-- Main Form Content -->
<h2>Support Time Tracker</h2>

<form method="post" action="#">

    <!-- User Information -->
    <div>
        <label for="name">Name</label>
        <input type="text" id="name" value="John Doe (logged in user)" readonly>
    </div>

    <div>
        <label for="date">Select date</label>
        <input type="date" id="date" name="date">
    </div>

    <div>
        <label for="site">Site name</label>
        <select id="site" name="site">
            <option value="">Select site</option>
            <option value="site1">Site 1</option>
            <option value="site2">Site 2</option>
            <option value="site3">Site 3</option>
        </select>
    </div>

    <!-- Support Time Inputs -->
    <div style="display: flex; gap: 20px; margin-top: 20px;">
        <!-- Email Support Section -->
        <div style="flex: 1; border: 1px solid #ccc; padding: 15px; border-radius: 8px;">
            <h3>📧 Email Support</h3>
            <label>Level 1 (6 mins)</label>
            <input type="number" name="email_level1" value="0" min="0">

            <label>Level 2 (15 mins)</label>
            <input type="number" name="email_level2" value="0" min="0">

            <label>Level 3 (30 mins)</label>
            <input type="number" name="email_level3" value="0" min="0">

            <label>Level 4 (45 mins)</label>
            <input type="number" name="email_level4" value="0" min="0">
        </div>

        <!-- Phone Support Section -->
        <div style="flex: 1; border: 1px solid #ccc; padding: 15px; border-radius: 8px;">
            <h3>📞 Phone Support</h3>
            <label>Level 1 (6 mins)</label>
            <input type="number" name="phone_level1" value="0" min="0">

            <label>Level 2 (15 mins)</label>
            <input type="number" name="phone_level2" value="0" min="0">

            <label>Level 3 (30 mins)</label>
            <input type="number" name="phone_level3" value="0" min="0">

            <label>Level 4 (45 mins)</label>
            <input type="number" name="phone_level4" value="0" min="0">
        </div>
    </div>

    <!-- Total Support Time -->
    <div style="margin-top: 20px;">
        <h3>Total Support Time</h3>
        <p>This day you provided <strong>66 minutes</strong> of support</p>
    </div>

    <!-- Submit Button -->
    <button type="submit" style="padding: 10px 20px; background-color: #0073aa; color: white; border: none; border-radius: 5px;">
        Submit
    </button>

</form>

<?php
// Output the footer.
echo $OUTPUT->footer();
