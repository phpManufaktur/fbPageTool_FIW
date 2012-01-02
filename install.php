<?php

/**
 * SampleAdminTool
 * 
 * @author Ralf Hertsch (ralf.hertsch@phpmanufaktur.de)
 * @link http://phpmanufaktur.de
 * @copyright 2011
 * @license GNU GPL (http://www.gnu.org/licenses/gpl.html)
 * @version $Id$
 * 
 * FOR VERSION- AND RELEASE NOTES PLEASE LOOK AT INFO.TXT!
 */

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

global $database;
global $admin;

$SQL =  "CREATE TABLE IF NOT EXISTS ".TABLE_PREFIX."mod_fb_page_tool (".
        "fb_pt_id INT(11) NOT NULL DEFAULT '1', ".
        "fb_pt_app_id VARCHAR(255) NOT NULL DEFAULT '', ".
        "fb_pt_app_secret VARCHAR(255) NOT NULL DEFAULT '', ".
        "fb_pt_page_path TEXT NOT NULL DEFAULT '', ".
        "fb_pt_page_text TEXT NOT NULL DEFAULT '', ". 
        "PRIMARY KEY (fb_pt_id))";

$database->query($SQL);

if ($database->is_error()) {
    $admin->print_error('[CREATE TABLE] '.$database->get_error());
}
