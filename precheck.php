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

// Checking Requirements

$PRECHECK['WB_VERSION'] = array(
        'VERSION' => '2.8', 'OPERATOR' => '>='
        );
$PRECHECK['LEPTON_VERSION'] = array(
        'VERSION' => '1.1', 'OPERATOR' => '>='
        );
$PRECHECK['PHP_VERSION'] = array(
        'VERSION' => '5.2.0', 'OPERATOR' => '>='
        );
$PRECHECK['WB_ADDONS'] = array(
        'dwoo' => array('VERSION' => '0.11', 'OPERATOR' => '>=')
        );

?>