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

$string['title'] = 'LinkedIn profile';
$string['description'] = 'Add your LinkedIn profile';

// LinkedIn profile strings
$string['Current'] = 'Current';
$string['Past'] = 'Past';
$string['Education'] = 'Education';
$string['Connections'] = 'Connections';
$string['connections'] = 'connections';
$string['Summaryof'] = 'Summary of %s';
$string['Specialties'] = 'Specialties';
$string['Experienceof'] = 'Experience of %s';
$string['Languagesof'] = 'Languages of %s';
$string['Skillsof'] = 'Skills & Expertise of %s';
$string['Educationof'] = 'Education of %s';
$string['Groupsof'] = 'Groups of %s';
$string['month.1'] = 'January';
$string['month.2'] = 'February';
$string['month.3'] = 'March';
$string['month.4'] = 'April';
$string['month.5'] = 'May';
$string['month.6'] = 'June';
$string['month.7'] = 'July';
$string['month.8'] = 'August';
$string['month.9'] = 'September';
$string['month.10'] = 'October';
$string['month.11'] = 'November';
$string['month.12'] = 'December';
$string['present'] = 'Present';

$string['Email'] = 'Email';
$string['Linkedin'] = 'LinkedIn';
$string['Twitter'] = 'Twitter';
$string['Websites'] = 'Websites';
$string['Phone'] = 'Phone';
$string['Address'] = 'Address';

// Blocktype settings strings
$string['connecttolinkedin'] = 'Connect to LinkedIn';
$string['notconnectedtolinkedin'] = 'Not connected to LinkedIn API';
$string['accesstokensaved'] = 'Access token saved successfully';
$string['accesstokenrefreshed'] = 'Access token refreshed and saved successfully';
$string['curlerror'] = 'Curl error %s: %s';
$string['httpcode'] = 'HTTP code %s';

$string['revokeconnection'] = 'Revoke connection to LinkedIn';
$string['connectionrevoked'] = 'Connection revoked successfully';

$string['datatoshow'] = 'Select data to show';
$string['basicprofile'] = 'LinkedIn basic profile';
$string['fullprofile'] = 'LinkedIn full profile';
$string['contactinfo'] = 'LinkedIn contact information';
$string['viewprofile'] = 'View profile';

// Blocktype administration strings
$string['applicationdesc'] = 'You must create %san application%s, if you wish to access and use LinkedIn API.';
$string['applicationinfo'] = 'Application info';
$string['applicationname'] = 'Application name';
$string['applicationnamedesc'] = 'You must provide unique application name, e.g. the name of this site.';
$string['websiteurl'] = 'Website URL';
$string['websiteurldesc'] = 'You must provide the URL of this website.';
$string['applicationuse'] = 'Application use';
$string['applicationusedesc'] = 'You must select an appropriate category, e.g. "Other".';
$string['livestatus'] = 'Live status';
$string['livestatusdesc'] = 'You should select "Live". While in development, network updates are only seen by application developers.';
$string['oauthkeys'] = 'OAuth keys';
$string['apikey'] = 'API key';
$string['apikeydesc'] = 'When you create an application in LinkedIn, you\'ll get an API key. Paste it here.';
$string['secretkey'] = 'Secret key';
$string['secretkeydesc'] = 'When you create an application, you\'ll also get a Secret key. Paste it here and don\'t share it with anyone.';
$string['redirecturl'] = 'OAuth 2.0 Redirect URL';
$string['redirecturldesc'] = 'Absolute URL allowed for OAuth 2.0 redirections. It is strongly encouraged that HTTPS is used.';
