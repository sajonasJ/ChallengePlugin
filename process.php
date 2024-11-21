<?php
require_once('../../config.php');

try {
    // Ensure only admins can access this script.
    require_login();
    if (!is_siteadmin()) {
        redirect($CFG->wwwroot, get_string('accessdenied', 'admin'));
    }

    // Validation Functions
    function validate_name($name)
    {
        $name = trim($name);
        if (strlen($name) < 3 || strlen($name) > 20) {
            throw new moodle_exception(' Invalid name length. Name must be between 3 and 20 characters.');
        }
        if (!preg_match('/^[a-zA-Z \'-]+$/', $name)) {
            throw new moodle_exception(' Invalid name format. Only letters, spaces, hyphens, and apostrophes are allowed.');
        }
        return $name;
    }

    function validate_total_support_time($totalSupportTime)
    {
        if ($totalSupportTime <= 0) {
            throw new moodle_exception(' Total support time must be greater than zero.');
        }
    }

    function check_duplicate_record($name, $date, $siteName)
    {
        global $DB;
        $existing = $DB->get_record('challenge_support_time', [
            'name' => $name,
            'date' => $date,
            'site' => $siteName,
        ]);
        if ($existing) {
            throw new moodle_exception(' A record for this user, date, and site already exists.');
        }
    }

    function trim_inputs($data)
    {
        return array_map('trim', $data);
    }

    // Get Form Data
    $name = validate_name(required_param('user-name', PARAM_TEXT));
    $date = trim(required_param('date', PARAM_TEXT));
    $siteName = trim(required_param('site-name', PARAM_TEXT));

    $emailLevels = trim_inputs([
        'level1' => required_param('email-level-1', PARAM_INT),
        'level2' => required_param('email-level-2', PARAM_INT),
        'level3' => required_param('email-level-3', PARAM_INT),
        'level4' => required_param('email-level-4', PARAM_INT),
    ]);

    $phoneLevels = trim_inputs([
        'level1' => required_param('phone-level-1', PARAM_INT),
        'level2' => required_param('phone-level-2', PARAM_INT),
        'level3' => required_param('phone-level-3', PARAM_INT),
        'level4' => required_param('phone-level-4', PARAM_INT),
    ]);

    // Validate Date
    if (!strtotime($date)) {
        throw new moodle_exception(' Invalid date format. Please provide a valid date.');
    }

    //Site Name fallback
    $site_names = explode("\n", get_config('local_challenge', 'site_names'));
    $site_names = array_map('trim', $site_names);

    if (empty(array_filter($site_names))) {
        // Fallback to default site names
        $site_names = [
            'Gold Coast University Hospital',
            'Robina Hospital',
            'Varsity Lakes Day Hospital'
        ];
    }


    // Validate Email and Phone Levels
    foreach (array_merge($emailLevels, $phoneLevels) as $level => $value) {
        if ($value < 0) {
            throw new moodle_exception(" Invalid value for $level: must be a non-negative integer.");
        }
    }

    // Calculate Total Support Time
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
    validate_total_support_time($totalSupportTime);

    // Check for Duplicate Records
    check_duplicate_record($name, $date, $siteName);

    // Insert Record
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

    $DB->insert_record('challenge_support_time', $record);

    // Redirect with Success
    redirect(new moodle_url('/local/challenge/index.php'), 'Support time has been recorded successfully.', null, \core\output\notification::NOTIFY_SUCCESS);
} catch (moodle_exception $e) {
    // Handle Exceptions
    redirect(new moodle_url('/local/challenge/index.php'), $e->getMessage(), null, \core\output\notification::NOTIFY_ERROR);
}
