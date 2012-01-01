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

$module_description   = 'Sample of a Admin-Tool for LEPTON CMS';

global $LANG;

$LANG = array(
        'btn_abort'
            => 'Cancel',
        'btn_ok' 
            => 'OK',
        'dialog_subject_hint'
            => 'Hint for the dialog subject',
        'dialog_subject_label'
            => 'Subject',
        'dialog_text_hint'
            => 'Hint for the dialog text',
        'dialog_text_label'
            => 'Text',
        'error_executing_template'
            => 'Error executing the template <b>%s</b>: %s',
        'form_header'
            => 'Sample dialog',
        'form_intro'
            => 'I\'m the sample introduction for the sample dialog!',
        'msg_insert_record'
            => 'Inserted a new record.',
        'msg_nothing_changed'
            => 'Nothing changed',
        'msg_record_empty'
            => 'The data record is empty!',
        'msg_update_record'
            => 'Update the record.',
        'time_zone' 
            => 'Europe/London',
	
        );
