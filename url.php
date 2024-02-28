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
 * URL actions
 * 
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
header('Content-Type: application/json');

require_once(__DIR__ . '/../../../../config.php');

global $PAGE, $DB, $CFG;

$config = new \quizaccess_edusynch\config();

$action = required_param('action', PARAM_ALPHA);

if ($action == 'save') {
    $arguments = file_get_contents('php://input');
    $payload = json_decode($arguments, true);
    $config->set_key('lti_url', $payload['url']);

    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
}

