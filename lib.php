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

defined('INTERNAL') || die();

// If Cloud plugin is installed then use that OAuth library
if (file_exists(get_config('docroot') . 'artefact/cloud/lib/oauth.php')) {
    require_once(get_config('docroot') . 'artefact/cloud/lib/oauth.php');
}
// otherwise use local OAuth library
else {
    require_once('oauth.php');
}


class PluginBlocktypeLinkedinprofile extends SystemBlocktype {

    public static function get_title() {
        return get_string('title', 'blocktype.linkedinprofile');
    }

    public static function get_description() {
        return get_string('description', 'blocktype.linkedinprofile');
    }

    public static function get_css_icon() {
        return 'linkedin-square';
    }

    public static function get_categories() {
        return array('internal');
    }

    public static function render_instance(BlockInstance $instance, $editing=false) {
        $configdata = $instance->get('configdata');
        $type  = (isset($configdata['linkedindata']) ? $configdata['linkedindata'] : 'basicprofile');
        $owner = $instance->get_view()->get('owner');

        $profile = self::get_user_profile($type, $owner);
        $smarty = smarty_core();
        $smarty->assign('profile', $profile);
        return $smarty->fetch('blocktype:linkedinprofile:' . $type . '.tpl');
    }

    public static function has_instance_config() {
        return true;
    }

    public static function instance_config_form($instance) {
        global $USER, $THEME;
        $configdata = $instance->get('configdata');
        $data = get_record('usr_account_preference', 'usr', $USER->get('id'), 'field', 'linkedinprofile');
        if ($data) {
            return array(
                'linkedin' => array(
                    'type' => 'fieldset',
                    'elements' => array(
                        'linkedinlogo' => array(
                            'type' => 'html',
                            'value' => '<img src="' . get_config('wwwroot') . 'blocktype/linkedinprofile/theme/raw/static/images/logo.png">',
                        ),
                        'linkedindisconnect' => array(
                            'type' => 'cancel',
                            'value' => get_string('revokeconnection', 'blocktype.linkedinprofile'),
                            'goto' => get_config('wwwroot') . 'blocktype/linkedinprofile/account.php?action=logout',
                        ),
                        'linkedindata' => array(
                            'type' => 'radio',
                            'labelhtml' => get_string('datatoshow', 'blocktype.linkedinprofile'),
                            'defaultvalue' => (isset($configdata['linkedindata']) && !empty($configdata['linkedindata']) ? $configdata['linkedindata'] : 'basicprofile'),
                            'options' => array(
                                'basicprofile' => get_string('basicprofile', 'blocktype.linkedinprofile'),
                                'fullprofile'  => get_string('fullprofile', 'blocktype.linkedinprofile'),
                                'contactinfo'  => get_string('contactinfo', 'blocktype.linkedinprofile'),
                            ),
                            'separator' => '<br>',
                        ),
                    ),
                ),
            );
        }
        else {
            return array(
                'linkedin' => array(
                    'type' => 'fieldset',
                    'elements' => array(
                        'linkedinlogo' => array(
                            'type' => 'html',
                            'value' => '<img src="' . get_config('wwwroot') . 'blocktype/linkedinprofile/theme/raw/static/images/logo.png">',
                        ),
                        'linkedinconnect' => array(
                            'type' => 'cancel',
                            'value' => get_string('connecttolinkedin', 'blocktype.linkedinprofile'),
                            'goto' => get_config('wwwroot') . 'blocktype/linkedinprofile/account.php?action=login',
                        ),
                    ),
                ),
            );
        }
    }

    public static function instance_config_save($values) {
        unset($values['linkedinlogo']);
        return $values;
    }

    public static function has_config() {
        return true;
    }

    public static function get_config_options() {
        $elements = array();
        $elements['applicationdesc'] = array(
            'type'  => 'html',
            'value' => get_string('applicationdesc', 'blocktype.linkedinprofile', '<a href="https://www.linkedin.com/secure/developer" target="_blank">', '</a>'),
        );
        $elements['applicationinfo'] = array(
            'type' => 'fieldset',
            'legend' => get_string('applicationinfo', 'blocktype.linkedinprofile'),
            'elements' => array(
                'applicationname' => array(
                    'type'        => 'html',
                    'title'       => get_string('applicationname', 'blocktype.linkedinprofile'),
                    'value'       => get_config('sitename'),
                    'description' => get_string('applicationnamedesc', 'blocktype.linkedinprofile'),
                ),
                'websiteurl' => array(
                    'type'        => 'html',
                    'title'       => get_string('websiteurl', 'blocktype.linkedinprofile'),
                    'value'       => get_config('wwwroot'),
                    'description' => get_string('websiteurldesc', 'blocktype.linkedinprofile'),
                ),
                'applicationuse' => array(
                    'type'         => 'html',
                    'title'        => get_string('applicationuse', 'blocktype.linkedinprofile'),
                    'value'        => 'Other',
                    'description'  => get_string('applicationusedesc', 'blocktype.linkedinprofile'),
                ),
                'livestatus' => array(
                    'type'         => 'html',
                    'title'        => get_string('livestatus', 'blocktype.linkedinprofile'),
                    'value'        => 'Live',
                    'description'  => get_string('livestatusdesc', 'blocktype.linkedinprofile'),
                ),
            )
        );
        $elements['oauthkeys'] = array(
            'type' => 'fieldset',
            'legend' => get_string('oauthkeys', 'blocktype.linkedinprofile'),
            'elements' => array(
                'apikey' => array(
                    'type'         => 'text',
                    'title'        => get_string('apikey', 'blocktype.linkedinprofile'),
                    'defaultvalue' => get_config_plugin('blocktype', 'linkedinprofile', 'apikey'),
                    'description'  => get_string('apikeydesc', 'blocktype.linkedinprofile'),
                    'rules' => array('required' => true),
                ),
                'secretkey' => array(
                    'type'         => 'text',
                    'title'        => get_string('secretkey', 'blocktype.linkedinprofile'),
                    'defaultvalue' => get_config_plugin('blocktype', 'linkedinprofile', 'secretkey'),
                    'description'  => get_string('secretkeydesc', 'blocktype.linkedinprofile'),
                    'rules' => array('required' => true),
                ),
                'redirecturl' => array(
                    'type'        => 'html',
                    'title'       => get_string('redirecturl', 'blocktype.linkedinprofile'),
                    'value'       => get_config('wwwroot') . 'blocktype/linkedinprofile/callback.php',
                    'description' => get_string('redirecturldesc', 'blocktype.linkedinprofile'),
                ),
            )
        );
        return array(
            'elements' => $elements,
        );
    }

    public static function save_config_options($form, $values) {
        set_config_plugin('blocktype', 'linkedinprofile', 'apikey', $values['apikey']);
        set_config_plugin('blocktype', 'linkedinprofile', 'secretkey', $values['secretkey']);
    }

    public static function default_copy_type() {
        return 'shallow';
    }

    // LinkedIn blocktype is only allowed in personal views, because
    // there's no such thing as group/site profiles, etc.
    public static function allowed_in_view(View $view) {
        return $view->get('owner') != null;
    }        

    /**********************************************
     * Methods & stuff for accessing LinkedIn API *
     **********************************************/

    private function get_service_consumer() {
        global $USER;
        $usrprefs = get_field('usr_account_preference', 'value', 'usr', $USER->get('id'), 'field', 'linkedinprofile');
        $service = new StdClass();
        $service->ssl      = true;
        $service->apiurl   = 'https://api.linkedin.com/v1/';
        $service->oauthurl = 'https://www.linkedin.com/uas/oauth2/';
        $service->key      = get_config_plugin('blocktype', 'linkedinprofile', 'apikey');
        $service->secret   = get_config_plugin('blocktype', 'linkedinprofile', 'secretkey');
        $service->callback = get_config('wwwroot') . 'blocktype/linkedinprofile/callback.php';
        $service->usrprefs = (!empty($userprefs) ? unserialize($usrprefs) : null );
        return $service;
    }

    // SEE: http://developer.linkedin.com/documents/authentication
    public function request_token() {
        global $USER, $SESSION;
        $consumer = self::get_service_consumer();
        if (!empty($consumer->key) && !empty($consumer->secret)) {
            $params = array(
                'response_type' => 'code',
                'client_id'     => $consumer->key,
                // As of February 12th 2015 do not pass optional parameter 'scope' anymore.
                // More info: https://developer.linkedin.com/support/developer-program-transition#troubleshooting
                //'scope'         => 'r_fullprofile r_emailaddress r_contactinfo rw_groups',
                'state'         => 'newaccesstoken',
                'redirect_uri'  => $consumer->callback,
            );
            redirect($consumer->oauthurl . 'authorization?' . oauth_http_build_query($params));
        }
        else {
            throw new ConfigException('Can\'t find LinkedIn api key and/or secret key.');
        }
    }

    // SEE: http://developer.linkedin.com/documents/authentication
    public function access_token($code, $state) {
        global $USER, $SESSION;
        $consumer = self::get_service_consumer();
        if (!empty($consumer->key) && !empty($consumer->secret)) {
            $url = $consumer->oauthurl . 'accessToken';
            $method = 'POST';
            $port = $consumer->ssl ? '443' : '80';
            $params = array(
                'grant_type'    => 'authorization_code',
                'code'          => $code,
                'redirect_uri'  => $consumer->callback,
                'client_id'     => $consumer->key,
                'client_secret' => $consumer->secret,
            );
            $query = oauth_http_build_query($params);
            $header = array();
            $header[] = build_oauth_header($params, "LinkedIn API PHP Client");
            $header[] = 'Content-Length: ' . strlen($query);
            $header[] = 'Content-Type: application/x-www-form-urlencoded';
            $config = array(
                CURLOPT_URL => $url,
                CURLOPT_PORT => $port,
                CURLOPT_HEADER => true,
                CURLOPT_HTTPHEADER => $header,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $query,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_CAINFO => dirname(__FILE__) . '/cert/cacert.crt'
            );
            $result = mahara_http_request($config);
            if ($result->info['http_code'] == 200 && !empty($result->data)) {
                $data = json_decode(substr($result->data, $result->info['header_size']), true);
                // Save timestamp when access token was issued
                $data = array_merge($data, array('timestamp' => time()));
                if ($state == 'newaccesstoken') {
                    $SESSION->add_ok_msg(get_string('accesstokensaved', 'blocktype.linkedinprofile'));
                }
                else {
                    $SESSION->add_ok_msg(get_string('accesstokenrefreshed', 'blocktype.linkedinprofile'));
                }
                return $data;
            }
            else {
                $errno = (isset($result->errno) && !empty($result->errno) ? $result->errno : 0);
                $error = (isset($result->error) && !empty($result->error) ? $result->errno : '');
                $SESSION->add_error_msg(get_string('curlerror', 'blocktype.linkedinprofile', $errno, $error));
                $httpcode = (isset($result->info['http_code']) && $result->info['http_code'] != 200 ? $result->info['http_code'] : 200);
                $SESSION->add_info_msg(get_string('httpcode', 'blocktype.linkedinprofile', $httpcode));
            }
        }
        else {
            throw new ConfigException('Can\'t find LinkedIn api key and/or secret key.');
        }
    }

    // SEE: http://developer.linkedin.com/documents/handling-errors-invalid-tokens
    public function check_access_token($referring_page) {
        global $USER, $SESSION;
        $consumer = self::get_service_consumer();
        if (!empty($consumer->key) && !empty($consumer->secret)) {
            $data = get_record('usr_account_preference', 'usr', $USER->get('id'), 'field', 'linkedinprofile');
            $token = unserialize($data->value);
            // Find out access token expiration and take away 10 seconds
            // to avoid access token expiry problems between API calls...
            $valid = intval($token['timestamp']) + intval($token['expires_in']) - 10;
            $now = time();
            if ($valid < $now) {
                $params = array(
                    'response_type' => 'code',
                    'client_id'     => $consumer->key,
                    // As of February 12th 2015 do not pass optional parameter 'scope' anymore.
                    // More info: https://developer.linkedin.com/support/developer-program-transition#troubleshooting
                    //'scope'         => 'r_fullprofile r_emailaddress r_contactinfo rw_groups',
                    'state'         => $referring_page,
                    'redirect_uri'  => $consumer->callback,
                );
                redirect($consumer->oauthurl . 'authorization?' . oauth_http_build_query($params));
            }
        }
        else {
            throw new ConfigException('Can\'t find LinkedIn api key and/or secret key.');
        }
    }

    public function delete_token() {
        global $USER;
        delete_records('usr_account_preference', 'usr', $USER->get('id'), 'field', 'linkedinprofile');
    }

    public function revoke_access() {
        // LinkedIn API doesn't allow programmatical access revoking, so:
        // Nothing to do!
    }

    // SEE: http://developer.linkedin.com/documents/profile-api
    // SEE: http://developer.linkedin.com/documents/profile-fields
    // SEE: http://developer.linkedin.com/documents/field-selectors
    public function get_user_profile($type='basicprofile', $owner=null) {
        global $USER, $SESSION;
        $referring_page = basename($_SERVER['SCRIPT_NAME']) . '?' . $_SERVER['QUERY_STRING'];
        // TODO: check if that really works
        self::check_access_token($referring_page);
        $consumer = self::get_service_consumer();
        if (!$owner) {
            $owner = $USER->get('id');
        }

        if (!empty($consumer->key) && !empty($consumer->secret)) {
            $data = get_record('usr_account_preference', 'usr', $owner, 'field', 'linkedinprofile');
            if ($data) {
                $token = unserialize($data->value);
                switch ($type) {
                    case 'fullprofile':
                        //$fields = ':(first-name,last-name,formatted-name,headline,location:(name),picture-url,picture-urls::(original),public-profile-url,member-url-resources,num-connections,three-current-positions,three-past-positions,summary,specialties,positions,languages,educations,skills,group-memberships)';
                        // SEE: https://developer.linkedin.com/support/developer-program-transition#hero-par_longformtext_longform-text-content-par_resourceparagraph_5
                        $fields = ':(first-name,last-name,formatted-name,headline,location:(name),picture-url,picture-urls::(original),public-profile-url,num-connections,three-current-positions,three-past-positions,summary,specialties,positions,languages,educations,skills,group-memberships)';
                        break;
                    case 'contactinfo':
                        //$fields = ':(first-name,last-name,formatted-name,headline,location:(name),picture-url,picture-urls::(original),public-profile-url,member-url-resources,email-address,phone-numbers,main-address,primary-twitter-account)';
                        // SEE: https://developer.linkedin.com/support/developer-program-transition#hero-par_longformtext_longform-text-content-par_resourceparagraph_5
                        $fields = ':(first-name,last-name,formatted-name,headline,location:(name),picture-url,picture-urls::(original),public-profile-url,email-address)';
                        break;
                    case 'basicprofile':
                    default:
                        $fields = ':(first-name,last-name,formatted-name,headline,location:(name),picture-url,public-profile-url)';
                        break;
                }
                $url = $consumer->apiurl . 'people/~' . $fields;
                $method = 'POST';
                $port = $consumer->ssl ? '443' : '80';
                $params = array('oauth2_access_token' => $token['access_token']);
                $config = array(
                    CURLOPT_URL => $url.'?'.oauth_http_build_query($params),
                    CURLOPT_PORT => $port,
                    CURLOPT_POST => false,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYHOST => 2,
                    CURLOPT_SSL_VERIFYPEER => true,
                    CURLOPT_CAINFO => dirname(__FILE__) . '/cert/cacert.crt'
                );
                $result = mahara_http_request($config);
                if (isset($result->data) && !empty($result->data) &&
                    isset($result->info) && !empty($result->info) &&
                    $result->info['http_code'] == 200) {
                    $data = oauth_parse_xml($result->data);
                    return $data;
                }
                else {
                    $SESSION->add_error_msg(get_string('httprequesterror', 'blocktype.linkedinprofile') . ' ' . $result->info['http_code']);
                }
            }
            else {
                $SESSION->add_error_msg(get_string('notconnectedtolinkedin', 'blocktype.linkedinprofile'));
            }
        }
        else {
            throw new ConfigException('Can\'t find LinkedIn api key and/or secret key.');
        }
    }

}
