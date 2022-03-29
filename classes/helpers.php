<?php
/**
 * @copyright 2022 Edusynch <contact@edusynch.com>
 */

namespace quizaccess_edusyncheproctoring;

defined('MOODLE_INTERNAL') || die();

/**
 * helpers class.
 *
 * This class contains helper methods
 *
 * @package    quizaccess_edusyncheproctoring
 * @category   quiz
 * @copyright  2022 Edusynch <contact@edusynch.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class helpers {

    /**
     * Generates a JWT string
     *
     * @param  array   $payload Array with payload 
     * @return string  The JWT payload 
     */        
    public static function get_jwt($payload)
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode($payload);
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, '', true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
        
        return $jwt;        
    }

}