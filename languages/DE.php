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

$module_description   = 'Ändern Sie den Inhalt Ihrer Facebook Landing Page!';

global $LANG;

$LANG = array(
        'btn_abort'
            => 'Abbruch',
        'btn_ok' 
            => 'OK',
        'dialog_hint_app_id'
            => 'Tragen Sie hier die Facebook AppID ein',
        'dialog_label_app_id'
            => 'Facebook App ID',
        'dialog_hint_app_secret'
            => 'Tragen Sie hier das Facebook App Secret ein',
        'dialog_label_app_secret'
            => 'Facebook App Secret',
        'dialog_hint_page_path'
            => 'Tragen Sie hier den LEPTON Pfad auf die Facebook index.php ein',
        'dialog_label_page_path'
            => 'Pfad auf FB index.php',
        'dialog_hint_page_text'
            => '',
        'dialog_label_page_text'
            => 'Text für die FB Seite',
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
