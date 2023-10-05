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
 * Ajax actions
 * 
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
header('Content-Type: application/json');

require_once(__DIR__ . '/../../../../config.php');

global $PAGE, $DB;

$config = new \quizaccess_edusynch\config();

$action = required_param('action', PARAM_ALPHA);

$headers = apache_request_headers();

if (is_null($headers['Authorization'])) {
    header("HTTP/1.1 401 Unauthorized");
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    die;
}

if ($action == 'show') {
    $userId       = required_param('userId', PARAM_INT);

    $user = $DB->get_record('user', ['id' => $userId]); 

    if ($user) {
        echo json_encode(['success' => true, 'user' => [
            'username'  => $user->username,
            'firstname' => $user->firstname,
            'lastname'  => $user->lastname,
            'email'     => $user->email,
            'address'   => $user->address,
            'city'      => $user->city,
            'country'   => $user->country,
            'name'      => "{$user->firstname} {$user->lastname}",
        ]]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Profile not found']);
    }
}

