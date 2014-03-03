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

global $USER, $SESSION;
$code = param_variable('code', null);
$state = param_variable('state', 'newaccesstoken');

// If there is a code (typically when signing user in) than proccess that code
// else (typically when signing user out & there is no code returned) do nothing...
if (!is_null($code)) {
    $prefs = PluginBlocktypeLinkedinprofile::access_token($code, $state);
    $where = array('usr' => $USER->get('id'), 'field' => 'linkedinprofile');
    $data = array('usr' => $USER->get('id'), 'field' => 'linkedinprofile',
                  'value' => serialize($prefs));
    ensure_record_exists('usr_account_preference', $where, $data);
}

if ($state == 'newaccesstoken') {
    redirect(get_config('wwwroot').'view/index.php');
}
else {
    // $state should be either view.php?id=X or blocks.php?id=X&
    redirect(get_config('wwwroot').'view/'.$state);
}

?>
