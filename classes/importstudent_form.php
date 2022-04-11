<?php
/**
 * @copyright 2022 Edusynch <contact@edusynch.com>
 */

namespace quizaccess_edusyncheproctoring;

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

use moodleform;

/**
 * importstudent_form class.
 *
 * This class manages the E-Proctoring student import form
 *
 * @package    quizaccess_edusyncheproctoring
 * @category   quiz
 * @copyright  2022 Edusynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class importstudent_form extends moodleform {
    public function definition() {
        global $CFG;
       
        $mform = $this->_form; 

        $mform->addElement('filepicker', 'import_list', "CSV File", null, ['accepted_types' => ['text/csv']]); // Add elements to your form.

        $this->add_action_buttons(false, 'Import');
    }

    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}