<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin version and other meta-data are defined here.
 *
 * @package     local_greetings
 * @copyright   2022 Alessandro Romani - Black Lotus Consulting S.r.l. <info@blacklotus.eu>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

/**
 * Show greetings message.
 *
 * @param  $user is current user variable.
 */
function local_greetings_get_greeting($user) {
    if ($user == null) {
        return get_string('greetinguser', 'local_greetings');
    }

    $country = $user->country;

    switch ($country) {
        case 'ES':
            $langstr = 'greetinguseres';
            break;
        default:
            $langstr = 'greetingloggedinuser';
            break;
    }

    return get_string($langstr, 'local_greetings', fullname($user));
}

/**
 * Insert a link to index.php on the site front page navigation menu.
 *
 * @param navigation_node $frontpage Node representing the front page in the navigation tree.
 */
function local_greetings_extend_navigation_frontpage(navigation_node $frontpage) {
    if (get_config('local_greetings', 'showinnavigation')) {
        if (isloggedin() && !isguestuser()) {
            $frontpage->add(
                    get_string('pluginname', 'local_greetings'),
                    new moodle_url('/local/greetings/index.php'),
                    navigation_node::TYPE_CUSTOM,
                    null,
                    null,
                    new pix_icon('t/message', '')
            );
        }
    }
}
/**
 * Insert a link to index.php on the site global navigation menu.
 *
 * @param global_navigation $root Node representing the global nav page in the navigation tree.
 */
function local_greetings_extend_navigation(global_navigation $root) {
    if (isloggedin() && !isguestuser()) {
        $node = navigation_node::create(
                get_string('pluginname', 'local_greetings'),
                new moodle_url('/local/greetings/index.php'),
                navigation_node::TYPE_CUSTOM,
                null,
                null,
                new pix_icon('t/message', '')
        );

        $node->showinflatnavigation = get_config('local_greetings', 'showinnavigation');

        $root->add_node($node);
    }
}