<?php
/**
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
