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
 * Web service local plugin template external functions and service definitions.
 *
 * @package    block_moodlefolder
 * @copyright  2015 TUM ITSZ-Medienzentrum
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
// We defined the web service functions to install.
$functions = array(
        'block_moodlefolder_subscribe' => array(
                'classname'   => 'block_moodlefolder_external',
                'methodname'  => 'subscribe',
                'classpath'   => 'blocks/moodlefolder/externallib.php',
                'description' => 'Subscribe user to the current course',
                'type'        => 'write',
        ),
        'block_moodlefolder_unsubscribe' => array(
                'classname'   => 'block_moodlefolder_external',
                'methodname'  => 'unsubscribe',
                'classpath'   => 'blocks/moodlefolder/externallib.php',
                'description' => 'Unsubscribe user from the current course',
                'type'        => 'write',
        )
);
// We define the services to install as pre-build services. A pre-build service is not editable by administrator.
$services = array(
        'moodlefolder' => array(
                'functions' => array ('block_moodlefolder_subscribe', 'block_moodlefolder_unsubscribe'),
                'restrictedusers' => 0,
                'enabled' => 1,
        )
);