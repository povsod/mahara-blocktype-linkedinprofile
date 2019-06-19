<?php
/**
 *
 * @package    mahara
 * @subpackage blocktype-linkedinprofile
 * @author     Gregor Anzelj
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @copyright  (C) 2014-2016 Gregor Anzelj, info@povsod.com
 *
 *
 * This file incorporates work covered by the following copyright and
 * permission notice:
 *
 *    The MIT License for OAuth Examples
 *    Copyright (c) 2010 Joe Chung - joechung at yahoo dot com
 *
 *    OAuth Examples code also contains software derived from the PHP OAuth Library
 *    Copyright 2007 Andy Smith:
 *
 *    MIT License - for PHP OAuth Library
 *    Copyright © 2007 Andy Smith
 *
 *    Permission is hereby granted, free of charge, to any person obtaining a copy
 *    of this software and associated documentation files (the "Software"), to deal
 *    in the Software without restriction, including without limitation the rights
 *    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *    copies of the Software, and to permit persons to whom the Software is
 *    furnished to do so, subject to the following conditions:
 *
 *    The above copyright notice and this permission notice shall be included in
 *    all copies or substantial portions of the Software.
 *
 *    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *    THE SOFTWARE.
 *
 */

defined('INTERNAL') || die();


class PluginBlocktypeLinkedinprofile extends SystemBlocktype {

    public static function get_title() {
        return get_string('title', 'blocktype.linkedinprofile');
    }

    public static function get_description() {
        return get_string('description', 'blocktype.linkedinprofile');
    }

    public static function get_css_icon($blocktypename) {
        return 'linkedin-square';
    }

    public static function get_categories() {
        return array('internal');
    }

    public static function render_instance(BlockInstance $instance, $editing=false, $versioning=false) {
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

    public static function instance_config_form(BlockInstance $instance) {
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

    public static function save_config_options(Pieform $form, $values) {
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
            redirect($consumer->oauthurl . 'authorization?' . self::oauth_http_build_query($params));
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
            $query = self::oauth_http_build_query($params);
            $header = array();
            $header[] = self::build_oauth_header($params, "LinkedIn API PHP Client");
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
            if ($data) {
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
                    redirect($consumer->oauthurl . 'authorization?' . self::oauth_http_build_query($params));
                }
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
                    CURLOPT_URL => $url.'?'.self::oauth_http_build_query($params),
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
                    $data = self::oauth_parse_xml($result->data);
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

    /***************************************************
     * OAuth helper methods for accessing LinkedIn API *
     ***************************************************/

    /**
     * Build a query parameter string according to OAuth Spec.
     * @param array $params an array of query parameters
     * @return string all the query parameters properly sorted and encoded
     * according to the OAuth spec, or an empty string if params is empty.
     * @link http://oauth.net/core/1.0/#rfc.section.9.1.1
     */
    private function oauth_http_build_query($params, $excludeOauthParams=false) {
      $query_string = '';
      if (! empty($params)) {

        // rfc3986 encode both keys and values
        $keys = self::rfc3986_encode(array_keys($params));
        $values = self::rfc3986_encode(array_values($params));
        $params = array_combine($keys, $values);

        // Parameters are sorted by name, using lexicographical byte value ordering.
        // http://oauth.net/core/1.0/#rfc.section.9.1.1
        uksort($params, 'strcmp');

        // Turn params array into an array of "key=value" strings
        $kvpairs = array();
        foreach ($params as $k => $v) {
          if ($excludeOauthParams && substr($k, 0, 5) == 'oauth') {
            continue;
          }
          if (is_array($v)) {
            // If two or more parameters share the same name,
            // they are sorted by their value. OAuth Spec: 9.1.1 (1)
            natsort($v);
            foreach ($v as $value_for_same_key) {
              array_push($kvpairs, ($k . '=' . $value_for_same_key));
            }
          } else {
            // For each parameter, the name is separated from the corresponding
            // value by an '=' character (ASCII code 61). OAuth Spec: 9.1.1 (2)
            array_push($kvpairs, ($k . '=' . $v));
          }
        }

        // Each name-value pair is separated by an '&' character, ASCII code 38.
        // OAuth Spec: 9.1.1 (2)
        $query_string = implode('&', $kvpairs);
      }

      return $query_string;
    }

    /**
     * Parse a xml string into an array.
     * @param string $xml_string an OAuth xml string response
     * @return array an array of parameters
     */
    private function oauth_parse_xml($xml_string) {
      $xml = simplexml_load_string($xml_string);
      $json = json_encode($xml);
      $array = json_decode($json, true);
        
      return $array;
    }

    /**
     * Build an OAuth header for API calls
     * @param array $params an array of query parameters
     * @return string encoded for insertion into HTTP header of API call
     */
    private function build_oauth_header($params, $realm='') {
      $header = 'Authorization: OAuth realm="' . $realm . '"';
      foreach ($params as $k => $v) {
        if (substr($k, 0, 5) == 'oauth') {
          $header .= ',' . rfc3986_encode($k) . '="' . rfc3986_encode($v) . '"';
        }
      }
      return $header;
    }

    /**
     * Encode input per RFC 3986
     * @param string|array $raw_input
     * @return string|array properly rfc3986 encoded raw_input
     * If an array is passed in, rfc3896 encode all elements of the array.
     * @link http://oauth.net/core/1.0/#encoding_parameters
     */
    private function rfc3986_encode($raw_input) {
      if (is_array($raw_input)) {
        return array_map('self::rfc3986_encode', $raw_input);
      } else if (is_scalar($raw_input)) {
        return str_replace('%7E', '~', rawurlencode($raw_input));
      } else {
        return '';
      }
    }

    private function rfc3986_decode($raw_input) {
      return rawurldecode($raw_input);
    }

}
