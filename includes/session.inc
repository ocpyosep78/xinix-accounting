<?php
/**********************************************************************
	Copyright (C) FrontAccounting, LLC.
	Released under the terms of the GNU General Public License, GPL,
	as published by the Free Software Foundation, either version 3
	of the License, or (at your option) any later version.
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
	See the License here <http://www.gnu.org/licenses/gpl-3.0.html>.
***********************************************************************/
function output_html($text)
{
	global $before_box, $Ajax, $messages;
	// Fatal errors are not send to error_handler,
	// so we must check the output
	if ($text && preg_match('/\bFatal error(<.*?>)?:(.*)/i', $text, $m)) {
		$Ajax->aCommands = array();  // Don't update page via ajax on errors
		$text = preg_replace('/\bFatal error(<.*?>)?:(.*)/i','', $text);
		$messages[] = array(E_ERROR, $m[2], null, null);
	}
	$Ajax->run();
	return  in_ajax() ? fmt_errors() : ($before_box.fmt_errors().$text);
}
//----------------------------------------------------------------------------------------

function kill_login()
{
	session_unset();
	session_destroy();
}
//----------------------------------------------------------------------------------------

function login_fail()
{
	global $path_to_root;
	
	header("HTTP/1.1 401 Authorization Required");
	echo "<center><br><br><font size='5' color='red'><b>" . _("Incorrect Password") . "<b></font><br><br>";
	echo "<b>" . _("The user and password combination is not valid for the system.") . "<b><br><br>";

	echo _("If you are not an authorized user, please contact your system administrator to obtain an account to enable you to use the system.");
	echo "<br><a href='$path_to_root/index.php'>" . _("Try again") . "</a>";
	echo "</center>";

	kill_login();
	die();
}

//----------------------------------------------------------------------------------------

function check_page_security($page_security)
{
	if (!$_SESSION["wa_current_user"]->check_user_access())
	{
		// notification after upgrade from pre-2.2 version
		$msg = $_SESSION["wa_current_user"]->old_db ?
			 _("Security settings have not been defined for your user account.")
				. "<br>" . _("Please contact your system administrator.")	
			: _("Please remove \$security_groups and \$security_headings arrays from config.php file!");

		display_error($msg);
		end_page();
		kill_login();
		exit;
	}

	if (!$_SESSION["wa_current_user"]->can_access_page($page_security))
	{

		echo "<center><br><br><br><b>";
		echo _("The security settings on your account do not permit you to access this function");
		echo "</b>";
		echo "<br><br><br><br></center>";
		end_page();
		exit;
	}
}
/*
	Helper function for setting page security level depeding on 
	GET start variable and/or some value stored in session variable.
	Before the call $page_security should be set to default page_security value.
*/
function set_page_security($value=null, $trans = array(), $gtrans = array())
{
	global $page_security;

	// first check is this is not start page call
	foreach($gtrans as $key => $area)
		if (isset($_GET[$key])) {
			$page_security = $area;
			return;
		}

	// then check session value
	if (isset($trans[$value])) {
		$page_security = $trans[$value];
		return;
	}
}

//-----------------------------------------------------------------------------
//	Removing magic quotes from nested arrays/variables
//
function strip_quotes($data)
{
	if(get_magic_quotes_gpc()) {
		if(is_array($data)) {
			foreach($data as $k => $v) {
				$data[$k] = strip_quotes($data[$k]);
			}
		} else
			return stripslashes($data);
	}
	return $data;
}

//============================================================================
//
//
function login_timeout()
{
	// skip timeout on logout page
	if ($_SESSION["wa_current_user"]->logged) {
		$tout = $_SESSION["wa_current_user"]->timeout;
		if ($tout && (time() > $_SESSION["wa_current_user"]->last_act + $tout))
		{
			$_SESSION["wa_current_user"]->logged = false;
		}
		$_SESSION["wa_current_user"]->last_act = time();
	}
}
//============================================================================
if (!isset($path_to_root))
{
	$path_to_root = ".";
}

// Prevent register_globals vulnerability
if (isset($_GET['path_to_root']) || isset($_POST['path_to_root']))
	die("Restricted access");

include_once($path_to_root . "/includes/current_user.inc");
include_once($path_to_root . "/frontaccounting.php");
include_once($path_to_root . "/admin/db/security_db.inc");
include_once($path_to_root . "/includes/lang/language.php");
include_once($path_to_root . "/config_db.php");
include_once($path_to_root . "/includes/ajax.inc");
include_once($path_to_root . "/includes/ui/ui_msgs.inc");

include_once($path_to_root . '/xinix/bootstrap.php');

/*
	Uncomment the setting below when using FA on shared hosting
	to avoid unexpeced session timeouts.
	Make sure this directory exists and is writable!
*/
//ini_set('session.save_path', dirname(__FILE__).'/../tmp/');

ini_set('session.gc_maxlifetime', 36000); // 10hrs

session_name('FA'.md5(dirname(__FILE__)));
session_start();

// this is to fix the "back-do-you-want-to-refresh" issue - thanx PHPFreaks
header("Cache-control: private");

get_text_init();

// Page Initialisation
if (!isset($_SESSION['language']) || !method_exists($_SESSION['language'], 'set_language')) 
{
	$l = array_search_value($dflt_lang, $installed_languages,  'code');
	$_SESSION['language'] = new language($l['name'], $l['code'], $l['encoding'],
	 isset($l['rtl']) ? 'rtl' : 'ltr');
}

$_SESSION['language']->set_language($_SESSION['language']->code);

// include $Hooks object if locale file exists
if (file_exists($path_to_root . "/lang/".$_SESSION['language']->code."/locale.inc"))
{
	include_once($path_to_root . "/lang/".$_SESSION['language']->code."/locale.inc");
	$Hooks = new Hooks();
}

include_once($path_to_root . "/includes/access_levels.inc");
include_once($path_to_root . "/config.php");
include_once($path_to_root . "/includes/main.inc");

// Ajax communication object
$Ajax = new Ajax();

// js/php validation rules container
$Validate = array();
// bindings for editors
$Editors = array();
// page help. Currently help for function keys.
$Pagehelp = array();

$SysPrefs = new sys_prefs();

$Refs = new references();

// intercept all output to destroy it in case of ajax call
register_shutdown_function('end_flush');
ob_start('output_html',0);

// colect all error msgs
set_error_handler('error_handler' /*, errtypes */);

// reekoheek bilang ga penting!!!
//if (!isset($_SESSION["wa_current_user"]))
//	$_SESSION["wa_current_user"] = new current_user();

// logout.php is the only page we should have always 
// accessable regardless of access level and current login status.

if (strstr($_SERVER['PHP_SELF'], 'logout.php') == false){

	login_timeout();

	if (empty($_SESSION["wa_current_user"]) || !$_SESSION["wa_current_user"]->logged_in())
	{
        
		// Show login screen
		if (!isset($_POST["user_name_entry_field"]) or $_POST["user_name_entry_field"] == "")
		{
			// strip ajax marker from uri, to force synchronous page reload
			$_SESSION['timeout'] = array( 'uri'=>preg_replace('/JsHttpRequest=(?:(\d+)-)?([^&]+)/s',
					'', @$_SERVER['REQUEST_URI']), 
				'post' => $_POST);

			include($path_to_root . "/access/login.php");
			if (in_ajax())
				$Ajax->activate('_page_body');
			exit;
		} else {

            $_SESSION["wa_current_user"] = new current_user();

			$succeed = isset($db_connections[$_POST["company_login_name"]]) &&
				$_SESSION["wa_current_user"]->login($_POST["company_login_name"],
				$_POST["user_name_entry_field"], md5($_POST["password"]));
			// select full vs fallback ui mode on login
			$_SESSION["wa_current_user"]->ui_mode = $_POST['ui_mode'];
			if (!$succeed)
			{
			// Incorrect password
				login_fail();
			}
			$lang = &$_SESSION['language'];
			$lang->set_language($_SESSION['language']->code);
            header('Location: '.$GLOBALS['app_config']['base_url']);
		}
	} else {
		set_global_connection();
    }

	if (!$_SESSION["wa_current_user"]->old_db)
		include_once($path_to_root . '/company/'.user_company().'/installed_extensions.php');

	if (!isset($_SESSION["App"])) {
		$_SESSION["App"] = new front_accounting();
		$_SESSION["App"]->init();
	}

}

// POST vars cleanup needed for direct reuse.
// We quote all values later with db_escape() before db update.
	$_POST = strip_quotes($_POST);

?>