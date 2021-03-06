<?php

// This file is part of the MRBS block for Moodle
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

require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/config.php');

$dayurl = new moodle_url('/blocks/mrbs/web/day.php');
$PAGE->set_url($dayurl); // Hopefully will never be needed
require_login();

if (!has_capability('block/mrbs:editmrbs', get_context_instance(CONTEXT_SYSTEM)) && !has_capability('block/mrbs:administermrbs', get_context_instance(CONTEXT_SYSTEM))) {
    redirect($dayurl);
}

$touser = required_param('id', PARAM_INT);
$message = required_param('message', PARAM_TEXT);

$touser = $DB->get_record('user', array('id'=>$touser));

if (!confirm_sesskey()) {
    print_error('Invalid sesskey');
}

email_to_user($touser, $USER, 'Request vacate room', $message);

redirect($dayurl);