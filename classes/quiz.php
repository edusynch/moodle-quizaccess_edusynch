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
 * Quiz class
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace quizaccess_edusynch;

use quizaccess_edusynch\config;

defined('MOODLE_INTERNAL') || die();
/**
 * quiz class.
 *
 * This class manages the E-Proctoring configs for quizzes
 *
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class quiz {

    /**
     * Checks if a quiz is enabled for E-Proctoring
     *
     * @param   int     $quizid  The moodle Quiz ID 
     * @return  bool    true if quiz is enabled; false if don't  
     */       
    public static function is_enabled($quizid)
    {       
        global $DB;
       
        // Is Quiz enabled?
        $config      = new config();
        $quizzes     = $config->get_key('quizzes');

        $quizzes = $quizzes ? json_decode($quizzes->value, true) : [];

        $search = array_search($quizid, array_column($quizzes, 'id'));

        if($search === false) {
            return false;
        }

        return true;
    }

}