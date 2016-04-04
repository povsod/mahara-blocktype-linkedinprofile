<?php
/**
 *
 * @package    mahara
 * @subpackage blocktype-linkedinprofile
 * @author     Gregor Anzelj
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2014-2016 Gregor Anzelj, info@povsod.com
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
