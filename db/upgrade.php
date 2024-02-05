<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 * Upgrade actions
 * 
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function xmldb_quizaccess_edusynch_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2022050300) {

        // Define table quizaccess_edusynch_sessions to be created.
        $table = new xmldb_table('quizaccess_edusynch_sessions');

        // Adding fields to table quizaccess_edusynch_sessions.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('session_id', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, null);
        $table->add_field('quiz_id', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table quizaccess_edusynch_sessions.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Conditionally launch create table for quizaccess_edusynch_sessions.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // edusynch savepoint reached.
        upgrade_plugin_savepoint(true, 2022050300, 'quizaccess', 'edusynch');
    }

    if ($oldversion < 2023121300) {

        // Define table quizaccess_edusynch_sessions to be created.
        $table = new xmldb_table('quizaccess_edusynch_tokens');

        // Adding fields to table quizaccess_edusynch_tokens.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('user_id', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, null);
        $table->add_field('token', XMLDB_TYPE_CHAR, '100', null, XMLDB_NOTNULL, null, null);
        $table->add_field('expiration', XMLDB_TYPE_DATETIME, '100', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table quizaccess_edusynch_tokens.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Conditionally launch create table for quizaccess_edusynch_sessions.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // edusynch savepoint reached.
        upgrade_plugin_savepoint(true, 2023121300, 'quizaccess', 'edusynch');
    }    

    return true;
}