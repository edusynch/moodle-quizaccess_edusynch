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
 * Import Student Form class
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace quizaccess_edusynch;

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

use moodleform;

/**
 * importstudent_form class.
 *
 * This class manages the E-Proctoring student import form
 *
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class importstudent_form extends moodleform {
    /**
     * Defines the form
     *
     * @return void 
     */            
    public function definition() {
        global $CFG;
       
        $mform = $this->_form; 

        $mform->addElement('filepicker', 'import_list', get_string('config:import_students_file', 'quizaccess_edusynch'), null, ['accepted_types' => ['text/csv']]); // Add elements to your form.

        $this->add_action_buttons(false, get_string('config:import', 'quizaccess_edusynch'));
    }

    /**
     * Custom Validation rules for the form
     *
     * @param array $data   Form Data
     * @param array $files Form Files
     * @return array The validation 
     */        
    function validation($data, $files) {
        return array();
    }
}