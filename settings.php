<?php
defined('MOODLE_INTERNAL') || die();

// Check if the user has admin capabilities
if ($hassiteconfig) {
    $settings = new admin_settingpage(
        'local_challenge',
        get_string('pluginname', 'local_challenge')
    );

    // Default site names
    $default_site_names = "Gold Coast University Hospital\nRobina Hospital\nVarsity Lakes Day Hospital";

    // Add a text area to configure site names
    $settings->add(
        new admin_setting_configtextarea(
            'local_challenge/site_names',
            get_string('sitenames', 'local_challenge'),
            get_string('sitenames_desc', 'local_challenge'),
            $default_site_names,
            PARAM_TEXT
        )
    );

    // Ensure fallback to default site names if the setting is empty
    $current_site_names = get_config('local_challenge', 'site_names');
    if (empty(trim($current_site_names))) {
        set_config('site_names', $default_site_names, 'local_challenge');
    }

    // Add settings page to the local plugins category
    $ADMIN->add('localplugins', $settings);
}
