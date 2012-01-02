<?php

/**
 * fbPageTool
 *
 * @author Ralf Hertsch (ralf.hertsch@phpmanufaktur.de)
 * @link http://phpmanufaktur.de
 * @copyright 2011
 * @license GNU GPL (http://www.gnu.org/licenses/gpl.html)
 * @version $Id: index.php 2 2012-01-01 08:00:38Z phpmanufaktur $
 *
 * FOR VERSION- AND RELEASE NOTES PLEASE LOOK AT INFO.TXT!
 */

// LEPTON CMS config.php needed - this file is called external!
require_once('../../../../config.php');

// include class.secure.php to protect this file and the whole CMS!
if (defined('WB_PATH')) {
	if (defined('LEPTON_VERSION')) include(WB_PATH.'/framework/class.secure.php');
} else {
	$oneback = "../";
	$root = $oneback;
	$level = 1;
	while (($level < 10) && (!file_exists($root.'/framework/class.secure.php'))) {
		$root .= $oneback;
		$level += 1;
	}
	if (file_exists($root.'/framework/class.secure.php')) {
		include($root.'/framework/class.secure.php');
	} else {
		trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
	}
}
// end include class.secure.php

// include the language file
if(!file_exists(WB_PATH .'/modules/fb_page_tool/languages/' .LANGUAGE .'.php')) {
    require_once(WB_PATH .'/modules/fb_page_tool/languages/EN.php'); // EN is default!
}
else {
    // if possible load the requested language
    require_once(WB_PATH .'/modules/fb_page_tool/languages/' .LANGUAGE .'.php');
}

/**
 * First we need the basic informations from the table mod_fb_page_tool
 */
global $database;

function strip_slashes($input) {
    if (!get_magic_quotes_gpc() || (!is_string($input))) return $input;
    return stripslashes($input);
}

$SQL = "SELECT * FROM ".TABLE_PREFIX."mod_fb_page_tool WHERE fb_pt_id = '1'";
if (false ===($query = $database->query($SQL))) {
    // on error save the prompt of the database in the error variable
    trigger_error(sprintf('[fbPageTool - %s] %s', __LINE__, $database->get_error()));
    exit();
}

if ($query->numRows() < 1) {
    exit('There is no Facebook landing page defined!');
}

// fetch the record from the query result
$record = $query->fetchRow(MYSQL_ASSOC); // MYSQL_ASSOC returns a record with field names as index

$appID = $record['fb_pt_app_id'];
$appSecret = $record['fb_pt_app_secret'];

$text = strip_slashes($record['fb_pt_page_text']);

echo  $text;
