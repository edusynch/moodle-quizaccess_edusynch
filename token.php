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
 * oAuth actions
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

if ($action == 'validate') {
    $token_param = required_param('token', PARAM_ALPHANUMEXT);
    $token       = $config->get_key('oauth_token');

    if ($token->value === $token_param) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Valid token']);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid token']);
    }
}

if ($action == 'install') {
    $arguments = file_get_contents('php://input');
    $payload = json_decode($arguments, true);
    if (!is_siteadmin($payload['user_id'])) {
        header("HTTP/1.1 401 Unauthorized");
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        die;
    }

    $config->set_key('oauth_token', $payload['token']);
    $url = new moodle_url('/mod/quiz/accessrule/edusynch/index.php?action=launch');

    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'url' => $url->__toString()]);
    die;
}

