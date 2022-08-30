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
 * String file - EN
 * 
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


// Plugin name
$string['pluginname'] = 'EduSynch E-Proctoring';

// Capabilities
$string['edusyncheproctoring:view_report'] = 'Can view E-Proctoring Reports';
$string['edusyncheproctoring:edit_settings'] = 'Can edit E-Proctoring Settings';
$string['edusyncheproctoring:enable_quiz'] = 'Can enable E-Proctoring plugin';

// Miscellaneous 
$string['misc:btn_prev'] = 'Previous';
$string['misc:btn_next'] = 'Next';
$string['misc:success'] = 'Success!';
$string['misc:error'] = 'Error';
$string['misc:yes'] = 'Yes';
$string['misc:no'] = 'No';
$string['misc:label_total_pages'] = 'of {$a}';


// Config page
$string['config:keys'] = 'Keys';
$string['config:api_key'] = 'API Key';
$string['config:students_api'] = 'Students API';
$string['config:cms_api'] = 'CMS API';
$string['config:events_api'] = 'Events API';
$string['config:user'] = 'User';
$string['config:password'] = 'Password';
$string['config:save'] = 'Save';
$string['config:import_students'] = 'Import students';
$string['config:total_students']  = 'You have <strong>{$a}</strong> students enabled.';
$string['config:import_students_desc'] = 'Use the box below to import a .CSV file with your students data, like';
$string['config:import_students_desc_link'] = 'this example';
$string['config:import_students_file'] = 'CSV File';
$string['config:courses_enabled'] = 'Courses enabled';
$string['config:manage_courses'] = 'Manage Courses';
$string['config:list_courses'] = 'List';
$string['config:course'] = 'Course';
$string['config:courses'] = 'Courses';
$string['config:quiz'] = 'Quiz';
$string['config:add'] = 'Add';
$string['config:add_course'] = 'Add Course';
$string['config:add_course_for_save'] = 'For Save';
$string['config:import'] = 'Import';
$string['config:no_courses'] = 'Please, add a course!';
$string['config:select_course'] = 'Select Course';
$string['config:select_quiz'] = 'Select Quiz';
$string['config:require_for_quiz'] = 'Require E-Proctoring Plugin';
$string['config:no_settings'] = 'Please, visit <a href="{$a}">Settings Page</a> to set your credentials before continue.';

// Navbar menu
$string['navbar_menu:settings'] = 'Settings';
$string['navbar_menu:sessions'] = 'Sessions';

// Sessions list
$string['sessions_list:title'] = 'Sessions list';
$string['sessions_list:no_sessions'] = 'There are no sessions registered';
$string['sessions_list:button'] = 'View EduSynch E-Proctoring reports';
$string['sessions_list:id'] = 'ID';
$string['sessions_list:student'] = 'Student';
$string['sessions_list:date'] = 'Date';
$string['sessions_list:incident_level'] = 'Incident Level';
$string['sessions_list:actions'] = 'Actions';
$string['sessions_list:select_course_and_quiz'] = 'Select course and quiz below to view the reports';
$string['sessions_list:total_number'] = 'Total Sessions';
$string['sessions_list:view_reports'] = 'View Reports';
$string['sessions_list:no_quiz_enabled'] = 'There are no quizzes enabled to E-Proctoring. Enable at least one in SETTINGS page';
$string['sessions_list:reviewed'] = 'Reviewed';

// Session report
$string['session_report:session_details'] = 'Session details';
$string['session_report:start_time'] = 'Start time';
$string['session_report:end_time'] = 'End time';
$string['session_report:completed'] = 'Completed';
$string['session_report:log'] = 'Log';
$string['session_report:incident:low'] = 'Low';
$string['session_report:incident:medium'] = 'Medium';
$string['session_report:incident:high'] = 'High';
$string['session_report:incident:invalid'] = 'Invalid';
$string['session_report:screen_archive'] = 'Screen Archive';
$string['session_report:no_screens'] = 'There are no screenshots for this session';
$string['session_report:no_logs'] = 'There are no events for this session';
$string['session_report:hour'] = 'Hour';
$string['session_report:type'] = 'Type';
$string['session_report:video_archive'] = 'Video Archive';
$string['session_report:no_videos'] = 'There are no videos for this session';
$string['session_report:incident_level_changed'] = 'Incident level successfully changed!';
$string['session_report:review_changed'] = 'Session review updated!';
$string['session_report:back_to_list'] = 'Back to list';
$string['session_report:comments'] = 'Comments';
$string['session_report:session_updated'] = 'Session updated!';

// Events
$string['EVENT_MULTIPLE_FACES_DETECTED'] = "Multiple people detected on camera";
$string['EVENT_NO_FACE_DETECTED'] = "No user detected";
$string['EVENT_NEW_TAB_WINDOW'] = "User attempted to open new tabs and/or new windows";
$string['EVENT_START_STREAMING'] = "Video streaming started";
$string['EVENT_STOP_STREAMING'] = "Video streaming stopped";
$string['EVENT_MORE_THAN_ONE_CAM'] = "Multiple cameras detected";
$string['EVENT_MULTIPLE_DISPLAYS_DETECTED'] = "Multiple screens detected";
$string['EVENT_MOVE_FOCUS'] = "Moved focus away from testing window";
$string['EVENT_CLOSED_WINDOW'] = "Closed browser or tab/refreshed the page via browser";
$string['EVENT_CLOSED_WINDOW_OR_TAB'] = "Closed browser or tab/refreshed the page via keyboard";
$string['EVENT_FINISH_SIMULATION'] = "Exam completed successfully";
$string['EVENT_START_SIMULATION'] = "Exam started";
$string['EVENT_TEST_PAUSED'] = "Exam paused";
$string['EVENT_TEST_RESUMED'] = "Exam resumed";
$string['EVENT_SUSPENDED_CAMERA'] = "User / some error suspended the camera";
$string['EVENT_GAZE_DETECTION'] = "User looked away from screen for at least 3 seconds";

// Error messages
$string['error:unable_list_sessions'] = 'Unable to list sessions. Check your credentials in SETTINGS section.';
$string['error:unable_session_details'] = 'Unable to get session details';
$string['error:unable_session_events'] = 'Unable to get session events';
$string['error:general'] = 'An error occurred: {$a}';

// Privacy API 
$string['privacy:metadata:quizaccess_edusynch:antifraud_api:firstname'] = 'We use firstname to store the student\'s first name in our data base. This is for admins to be able to further identify the student.';
$string['privacy:metadata:quizaccess_edusynch:antifraud_api:lastname'] = 'We use lastname to store the student\'s last name in our data base. This is for admins to be able to further identify the student.';
$string['privacy:metadata:quizaccess_edusynch:antifraud_api:email'] = 'We use email to store the student\'s email address. This is the cornerstone of the student\'s account, in that Admin\'s will typically use the email address as the primary unique identifier of the student.';
$string['privacy:metadata:quizaccess_edusynch:antifraud_api'] = 'We use this our antifraud_api to determine if the user tried to open new tabs, moved focus away from the browser, or performed any other action that is not permitted by the plugin in order to prevent cheating.';