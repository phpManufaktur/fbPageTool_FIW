<?php

/**
 * fbPageTool_FIW
 *
 * @author Ralf Hertsch <ralf.hertsch@phpmanufaktur.de>
 * @author FIW 2011/2012 - HTW Berlin
 * @link http://phpmanufaktur.de
 * @copyright 2011 - 2012
 * @license MIT License (MIT) http://www.opensource.org/licenses/MIT
 */

// include class.secure.php to protect this file and the whole CMS!
if (defined('WB_PATH')) {
  if (defined('LEPTON_VERSION'))
    include(WB_PATH.'/framework/class.secure.php');
}
else {
  $oneback = "../";
  $root = $oneback;
  $level = 1;
  while (($level < 10) && (!file_exists($root.'/framework/class.secure.php'))) {
    $root .= $oneback;
    $level += 1;
  }
  if (file_exists($root.'/framework/class.secure.php')) {
    include($root.'/framework/class.secure.php');
  }
  else {
    trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
  }
}
// end include class.secure.php

$module_directory     = 'fb_page_tool';
$module_name          = 'fbPageTool';
$module_function      = 'tool';
$module_version       = '0.10';
$module_status        = 'Beta';
$module_platform      = '2.8';
$module_author        = 'Ralf Hertsch, Berlin (Germany)';
$module_license       = 'GNU General Public License';
$module_description   = 'Edit Facebook langing pages';
$module_home          = 'http://phpmanufaktur.de';
$module_guid          = '02E6E80E-9CEF-4329-955F-00BAAE23599D';

?>