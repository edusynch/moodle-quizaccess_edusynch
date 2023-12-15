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
 * Login
 * 
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../config.php');

global $PAGE, $DB;

$arguments = file_get_contents('php://input');
$payload = json_decode($arguments, true);

$quizaccess_edusynch_token = $DB->get_record('quizaccess_edusynch_tokens', ['token' => $payload['token']]);

if (isset($quizaccess_edusynch_token)) {
  header('Content-Type: application/json');
  echo json_encode(['user_id' => $quizaccess_edusynch_token->user_id]);
  return;
}

header("HTTP/1.1 400 Bad Request");
header('Content-Type: application/json');
echo json_encode(['error' => 'Student not found']);
return;

