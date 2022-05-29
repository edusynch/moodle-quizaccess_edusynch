<?php
/**
 * @copyright 2022 Edusynch <contact@edusynch.com>
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
 * @copyright  2022 Edusynch <contact@edusynch.com>
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