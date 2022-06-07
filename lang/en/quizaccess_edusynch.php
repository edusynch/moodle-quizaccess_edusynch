<?php 
/**
 * @copyright 2022 Edusynch <contact@edusynch.com>
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

// Session report
$string['session_report:session_details'] = 'Session details';
$string['session_report:start_time'] = 'Start time';
$string['session_report:end_time'] = 'End time';
$string['session_report:completed'] = 'Completed';
$string['session_report:log'] = 'Log';
$string['session_report:incident:low'] = 'Low';
$string['session_report:incident:medium'] = 'Medium';
$string['session_report:incident:high'] = 'High';
$string['session_report:screen_archive'] = 'Screen Archive';
$string['session_report:no_screens'] = 'There are no screenshots for this session';
$string['session_report:no_logs'] = 'There are no events for this session';
$string['session_report:hour'] = 'Hour';
$string['session_report:type'] = 'Type';

// Session Events
$string['EVENT_MOVE_FOCUS'] = 'Opened a new window or tab; Minimized the browser; Opened other program;';
$string['EVENT_CLOSED_WINDOW'] = 'Closed browser or tab; refreshed the page';
$string['EVENT_OFFLINE'] = 'Lost connection';
$string['EVENT_ONLINE'] = 'Connection established';
$string['EVENT_ONLINE_SERVER'] = 'Connection established with socket';
$string['EVENT_UI_EVENT'] = 'User Interface moved';
$string['EVENT_START_SIMULATION'] = 'Exam started';
$string['EVENT_FINISH_SIMULATION'] = 'Exam completed successfully';
$string['EVENT_NEW_TAB_WINDOW'] = 'Opened a new window or tab';

// Error messages
$string['error:unable_list_sessions'] = 'Unable to list sessions. Check your credentials in SETTINGS section.';
$string['error:unable_session_details'] = 'Unable to get session details';
$string['error:unable_session_events'] = 'Unable to get session events';
$string['error:general'] = 'An error occurred: {$a}';

