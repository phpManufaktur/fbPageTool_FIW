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

$module_description   = 'Beispiel eines Admin-Tool für LEPTON CMS';

global $LANG;

$LANG = array(
        'btn_abort'
            => 'Abbruch',
        'btn_ok' 
            => 'OK',
        'dialog_subject_hint'
            => 'Hinweis für den Betreff',
        'dialog_subject_label'
            => 'Betreff',
        'dialog_text_hint'
            => 'Hinweis für den Text',
        'dialog_text_label'
            => 'Text',
        'error_executing_template'
            => 'Fehler bei der Ausführung des Templates <b>%s</b>: %s',
        'form_header'
            => 'Beispiel Dialog',
        'form_intro'
            => 'Ich bin die Einführung für den Beispiel Dialog',
        'msg_insert_record'
            => 'Es wurde ein neuer Datensatz eingefügt.',
        'msg_nothing_changed'
            => 'Es wurde nichts geändert',
        'msg_record_empty'
            => 'Der Datensatz ist leer!',
        'msg_update_record'
            => 'Der Datensatz wurde aktualisiert',
        'time_zone' 
            => 'Europe/Berlin',
	
        );
