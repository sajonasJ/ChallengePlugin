<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) { // Check if the user has admin capabilities
    $settings = new admin_settingpage(
        'local_challenge',
        get_string('pluginname', 'local_challenge')
    );

    // Add a text area to configure site names
    $settings->add(
        new admin_setting_configtextarea(
            'local_challenge/site_names',
            get_string('sitenames', 'local_challenge'),
            get_string('sitenames_desc', 'local_challenge'),
            "Gold Coast University Hospital\nRobina Hospital\nVarsity Lakes Day Hospital",
            PARAM_TEXT
        )
    );

    // Add settings page to the local plugins category
    $ADMIN->add('localplugins', $settings);
}
