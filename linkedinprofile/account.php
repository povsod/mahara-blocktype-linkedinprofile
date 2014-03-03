<?php
/**
 * Mahara: Electronic portfolio, weblog, resume builder and social networking
 * Copyright (C) 2006-2012 Catalyst IT Ltd and others; see:
 *                         http://wiki.mahara.org/Contributors
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    mahara
 * @subpackage blocktype-linkedinprofile
 * @author     Gregor Anzelj
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2014 Gregor Anzelj, gregor.anzelj@gmail.com
 *
 */

define('INTERNAL', 1);
define('PUBLIC', 1);
define('NOCHECKPASSWORDCHANGE', 1);
require(dirname(dirname(dirname(__FILE__))) . '/init.php');
safe_require('blocktype', 'linkedinprofile');

$action = param_alpha('action', 'login');

switch ($action) {
    case 'login':
        PluginBlocktypeLinkedinprofile::request_token();
        break;
    case 'logout':
        PluginBlocktypeLinkedinprofile::revoke_access();
        PluginBlocktypeLinkedinprofile::delete_token();
        $SESSION->add_ok_msg(get_string('connectionrevoked', 'blocktype.linkedinprofile'));
        redirect(get_config('wwwroot') . 'view/index.php');
        break;
}

?>