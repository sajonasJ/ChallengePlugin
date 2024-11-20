<?php
require_once('../../config.php');

// Ensure only admins can access this script.
require_login();
if (!is_siteadmin()) {
    redirect($CFG->wwwroot, get_string('accessdenied', 'admin'));
}

// Get form data
$name = required_param('user-name', PARAM_TEXT);
$date = required_param('date', PARAM_TEXT);
$siteName = required_param('site-name', PARAM_TEXT);
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

// Calculate total support time.
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

// Prepare the record for insertion.
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

// Insert into the database.
global $DB;
$DB->insert_record('challenge_support_time', $record);

// Redirect back to the form with a success message.
redirect(new moodle_url('/local/challenge/index.php'), 'Support time has been recorded successfully.', null, \core\output\notification::NOTIFY_SUCCESS);
