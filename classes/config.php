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
 * Config class
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


namespace quizaccess_edusynch;

defined('MOODLE_INTERNAL') || die();

use stdClass;

/**
 * config class.
 *
 * This class manages the vars who will be used to do the interaction with Edusynch servers
 *
 * @package    quizaccess_edusynch
 * @category   quiz
 * @copyright  2022 EduSynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class config {

    /** @var string The table name */
    protected $table = 'quizaccess_edusynch_conf';
    /** @var int The config record's primary key */
    public $id;
    /** @var string The record's key  */    
    public $config_key; 
    /** @var string This record's value */    
    public $value;


    /**
     * Sets and saves a new config key
     *
     * @param string   $key_str The key 
     * @param string   $value   The value
     * @return void 
     */    
    public function set_key($key_str, $value) 
    {
        $this->config_key = $key_str;
        $this->value      = $value;
        $this->_save();
    }

    /**
     * Finds a key
     *
     * @param string   $key_str The key wanted 
     * @return config  The complete record (id, config_key and value) 
     */       
    public function get_key($key_str)
    {
        return $this->_get($key_str);
    }

    /**
     * Saves a key
     *
     * @return void 
     */     
    private function _save()
    {
        global $DB; 

        $check = $this->_get($this->config_key);
        
        if (is_null($check)) {
            $this->id = null;
            $insert = $DB->insert_record($this->table, $this);
        } else {
            $this->id = $check->id;
            $update = $DB->update_record($this->table, $this);
        }
    }

    /**
     * Finds a key
     *
     * @param string   $key The key wanted 
     * @return config  The complete record (id, config_key and value) 
     */    
    private function _get($key)
    {
        global $DB;

        $record = $DB->get_record($this->table, ['config_key' => $key]);

        if($record) {
            return $record;
        }

        return null;
    }    
}