<?php
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
 * External Web Service Template
 *
 * @package    block_moodlefolder
 * @copyright  2015 TUM ITSZ-Medienzentrum
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once($CFG->libdir . "/externallib.php");
function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}
class block_moodlefolder_external extends external_api {
	static $REST_URL = get_config('block_moodlefolder', 'server_addr');


    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function subscribe_parameters() {
        return new external_function_parameters(
                array('courseid' => new external_value(PARAM_INT, 'The course the current user should subscribe to'))
        );
    }
    public static function subscribe_is_allowed_from_ajax() {
    	return true;
    }
    /**
     * Returns welcome message
     * @return string welcome message
     */
    public static function subscribe($courseid) {
        global $USER, $DB;
        $params = self::validate_parameters(self::subscribe_parameters(),
                array('courseid' => $courseid));

        $context = context_user::instance($USER->id);
        self::validate_context($context);

        $result = CallAPI('POST', block_moodlefolder_external::$REST_URL . 'addUserToCourse', array('courseid' => $courseid, 'userid' => $USER->username));
        $DB->insert_record('moodlefolder', array('username' => $USER->username, 'courseid' => $params['courseid']), false);
        return 'User ' . $USER->username . ' was added to course ' . $params['courseid'] . '. Result: ' . $result . '.';
    }
    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function subscribe_returns() {
        return new external_value(PARAM_TEXT, 'Message about the subscription');
    }

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function unsubscribe_parameters() {
        return new external_function_parameters(
                array('courseid' => new external_value(PARAM_INT, 'The course the current user should unsubscribe from'))
        );
    }
    public static function unsubscribe_is_allowed_from_ajax() {
    	return true;
    }
    /**
     * Returns welcome message
     * @return string welcome message
     */
    public static function unsubscribe($courseid) {
        global $USER, $DB;
        $params = self::validate_parameters(self::unsubscribe_parameters(),
                array('courseid' => $courseid));

        $context = context_user::instance($USER->id);
        self::validate_context($context);

        $result = CallAPI('POST', block_moodlefolder_external::$REST_URL . 'removeUserFromCourse', array('courseid' => $courseid, 'userid' => $USER->username));

        $DB->delete_records('moodlefolder', array('username' => $USER->username, 'courseid' => $params['courseid']), false);
        return 'User ' . $USER->username . ' was removed from course ' . $params['courseid'] . '. Result: ' . $result ;
    }
    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function unsubscribe_returns() {
        return new external_value(PARAM_TEXT, 'Message about the unsubscription');
    }
}