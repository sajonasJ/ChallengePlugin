<?php

defined('MOODLE_INTERNAL') || die();

function xmldb_local_challenge_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2024114000) {
        // Change the `date` column from VARCHAR(20) to BIGINT(10).
        $table = new xmldb_table('challenge_support_time');
        $field = new xmldb_field('date', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Update the field type if it exists.
        if ($dbman->field_exists($table, $field)) {
            $dbman->change_field_type($table, $field);
        }

        // Upgrade the plugin version.
        upgrade_plugin_savepoint(true, 2024114000, 'local', 'challenge');
    }

    return true;
}
