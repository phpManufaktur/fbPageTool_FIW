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

// include the language file
if(!file_exists(WB_PATH .'/modules/'.basename(dirname(__FILE__)).'/languages/' .LANGUAGE .'.php')) {
    require_once(WB_PATH .'/modules/'.basename(dirname(__FILE__)).'/languages/EN.php'); // EN is default!
}
else {
    // if possible load the requested language
    require_once(WB_PATH .'/modules/'.basename(dirname(__FILE__)).'/languages/' .LANGUAGE .'.php');
}

// load Dwoo template engine
if (!class_exists('Dwoo')) require_once WB_PATH.'/modules/dwoo/include.php';
// set the cache path for the template engine
$cache_path = WB_PATH.'/temp/cache';
// check if the cache directory exists, create it if necessary
if (!file_exists($cache_path)) @mkdir($cache_path, 0755, true);
// set the path for compiled templates
$compiled_path = WB_PATH.'/temp/compiled';
// check if the directory exists, create it if necessary
if (!file_exists($compiled_path)) @mkdir($compiled_path, 0755, true);
// set the global variable for the parser
global $parser;
// init the parser instance if needed - set compile and cache path
if (!is_object($parser)) $parser = new Dwoo($compiled_path, $cache_path);

// include default WYSIWYG editor of LEPTON CMS
require_once(WB_PATH.'/modules/'.WYSIWYG_EDITOR.'/include.php');

/**
 * Sample class for an Admin-Tool
 * 
 * This class handles a simple database record with textfield for a subject and
 * a html field for any text and show this fields with additional informations
 * in the backend as admin-tool.
 * 
 * The constructor set default variables and read the record from database, the
 * public function action() handles all requests and return the desired result.
 * 
 * @author Ralf Hertsch (ralf.hertsch@phpmanufaktur.de)
 *
 */
class sample_admintool {
    
    // needed REQUESTs for the action handler and for access to the fields 
    const REQUEST_ACTION = 'act';    // action handler
    const REQUEST_SUBJECT = 'sub';   // subject field 
    const REQUEST_TEXT = 'txt';      // text field
    
    // needed constants for the different actions
    const ACTION_DEFAULT = 'def';    // action: default
    const ACTION_CHECK = 'chk';      // action: check the dialog for changes
    
    private $toolLink = '';          // backend link to the sample_admintool
    private $templatePath = '';      // path to the used templates
    private $error = '';             // holds error messages
    private $message = '';           // holds general messages
    
    // data fields for facebook
    private $fieldID = -1;           // field: id (record)
    private $fieldAppID = '';        // field: Facebook AppID
    private $fieldSecret = '';       // field: Facebook Secret
    private $fieldPath = '';         // field: path to the index.php
    private $fieldText = '';         // field: text for the Facebook App
    
    /**
     * Constructor for class sample_admintool
     * 
     * Set default timezone, read the database record and init needed variables
     */
    public function __construct() {
        // set timezone depending by the language
        date_default_timezone_set($this->lang('time_zone'));
        // read the database record for sample_admintool
        $this->getRecord();
        // set the backend link to sample_admintool
        $this->setToolLink(ADMIN_URL . '/admintools/tool.php?tool=' . basename(dirname(__FILE__)));
        // set the template path
        $this->setTemplatePath(WB_PATH . '/modules/' . basename(dirname(__FILE__)) . '/templates/');
    } // __construct()
    
    /**
     * @return the $message
     */
    protected function getMessage() {
        return $this->message;
    }

	/**
     * @param field_type $message
     */
    protected function setMessage($message) {
        $this->message = $message;
    }
    
    /**
     * Return boolean TRUE if a message is set
     * 
     * @return boolean
     */
    protected function isMessage() {
        return (bool) !empty($this->message);
    } // isMessage()

	/**
     * Return the with $key desired language string
     * 
     * @param string $key
     */
    protected function lang($key) {
        return $GLOBALS['LANG'][$key];
    } // language()
    
    /**
     * @return the $templatePath
     */
    protected function getTemplatePath() {
        return $this->templatePath;
    }

	/**
     * @param field_type $templatePath
     */
    protected function setTemplatePath($templatePath) {
        $this->templatePath = $templatePath;
    }

	/**
     * @return the $toolLink
     */
    protected function getToolLink() {
        return $this->toolLink;
    }

	/**
     * @param field_type $toolLink
     */
    protected function setToolLink($toolLink) {
        $this->toolLink = $toolLink;
    }

	/**
     * @return the $error
     */
    protected function getError() {
        return $this->error;
    }

    /**
     * @param field_type $error
     */
    protected function setError($error) {
        $this->error = $error;
    }
    
    protected function isError() {
        return (bool) !empty($this->error);
    } // isError()
    
	/**
     * @return the $fieldID
     */
    protected function getFieldID() {
        return $this->fieldID;
    }
    
    /**
     * @param field_type $fieldID
     */
    protected function setFieldID($fieldID) {
        $this->fieldID = $fieldID;
    }

	/**
     * @return the $fieldAppID
     */
    protected function getFieldAppID() {
        return $this->fieldAppID;
    }
    
    /**
     * @param field_type $fieldSubject
     */
    protected function setFieldAppID($fieldAppID) {
        $this->fieldSubject = $fieldAppID;
    }
    
	/**
     * @return the $fieldSecret
     */
    protected function getFieldSecret() {
        return $this->fieldSecret;
    }

	/**
     * @param string $fieldSecret
     */
    protected function setFieldSecret($fieldSecret) {
        $this->fieldSecret = $fieldSecret;
    }

    /**
     * @return the $fieldPath
     */
    protected function getFieldPath() {
        return $this->fieldPath;
    }

	/**
     * @param string $fieldPath
     */
    protected function setFieldPath($fieldPath) {
        $this->fieldPath = $fieldPath;
    }

	/**
     * @return the $fieldText
     */
    protected function getFieldText() {
        return $this->fieldText;
    }
    
    /**
     * @param field_type $fieldText
     */
    protected function setFieldText($fieldText) {
        $this->fieldText = $fieldText;
    }
    	
	/**
	 * Read the record with the ID 1 from the database and set the 
	 * sample_admintools variables using
	 * 
	 * $this->setFieldID()
	 * $this->setFieldSubject()
	 * $this->setFieldText()
	 * 
	 * Set defaults if the record not exists and set fieldID to -1.
	 * 
	 * @return boolean TRUE on success and FALSE on error
	 */	
	protected function getRecord() {
	    // need handler to the LEPTON database
        global $database;
        
        // create Query string
        $SQL = "SELECT * FROM ".TABLE_PREFIX."mod_sample_admintool WHERE sample_id = '1'";
        if (false ===($query = $database->query($SQL))) {
            // on error save the prompt of the database in the error variable
            $this->setError(sprintf('[%s - %s] %s', __METHOD__, __LINE__, $database->get_error()));
            return false;
        }
        
        if ($query->numRows() < 1) {
            // record does not exists yet
            $this->setFieldID(-1); // set field ID to -1 to indicate that record does not exists
            $this->setFieldAppID(''); // set empty string
            $this->setFieldSecret(''); // set empty string
            $this->setFieldPath('/modules/fb_page_tool/fb/1/index.php'); // set default path to index.php
            $this->setFieldText(''); // set empty string
            return true;
        }
        
        // fetch the record from the query result
        $record = $query->fetchRow(MYSQL_ASSOC); // MYSQL_ASSOC returns a record with field names as index
        
        $this->setFieldID($record['fb_pt_id']); // set field ID
        $this->setFieldAppID($record['fb_pt_app_id']); // set field AppID
        $this->setFieldSecret($record['fb_pt_app_secret']); //set field secret
        $this->setFieldPath($record['fb_pt_page_path']); // set field path
        $this->setFieldText($record['fb_pt_page_text']); // set field text
        return true;
    } // getRecord()
    
    /**
     * Set the database record to the values of the $record array
     * 
     * Expects at least two fields in $record:
     * 
     * $record['subject'] - the new value for the field sample_subject
     * $record['text'] - the new value for the field sample_text
     *
     * Set $this->message if record is changed or nothing to do.
     * Set $this->error on $database error
     * 
     * @param array $record
     * @return boolean TRUE on success FALSE if nothing to do or on error
     */    
    protected function setRecord($record = array()) {
        // need handler to LEPTON database
        global $database;
        
        // set $changes to zero, which means: nothing to do
        $changes = 0;
        if (isset($record['fb_pt_app_id'])) {
            // set the field variable and increase the $changes counter
            $this->setFieldAppID($record['fb_pt_app_id']);
            $changes++;
        }
        if (isset($record['fb_pt_app_secret'])) {
            // set the field variable and increase the $changes counter
            $this->setFieldSecret($record['fb_pt_app_secret']);
            $changes++;
        }
        if (isset($record['fb_pt_page_path'])) {
            // set the field variable and increase the $changes counter
            $this->setFieldPath($record['fb_pt_page_path']);
            $changes++;
        }        
        if (isset($record['fb_pt_page_text'])) {
            // set the field variable and increase the $changes counter
            $this->setFieldText($record['fb_pt_page_text']);
            $changes++;
        }
        
        if ($changes < 1) {
            // if record is empty return with a message
            $this->setMessage($this->lang('msg_record_empty'));
            return false;
        }
        
        
        if ($this->getFieldID() < 1) {
            // insert a new record
            $SQL =  "INSERT INTO ".TABLE_PREFIX."mod_fb_page_tool (fb_pt_id, fb_pt_app_id, fb_pt_app_secret, fb_pt_page_path, fb_pt_page_text) ".
                    "VALUES (1, '".$this->getFieldAppID()."', '".$this->getFieldSecret()."', '".$this->getFieldPath()."', '".$this->getFieldText()."')";
            // exec the SQL statement
            if (!$database->query($SQL)) {
                // on error save the database prompt and return false
                $this->setError(sprintf('[%s - %s] %s', __METHOD__, __LINE__, $database->get_error()));
                return false;                
            }
            // set message on success
            $this->setMessage($this->lang('msg_insert_record'));
            return true;
        }
        else {
            // update the existing record
            $SQL =  "UPDATE ".TABLE_PREFIX."mod_sample_admintool SET ".
                    "fb_pt_app_id='".$this->getFieldAppID()."', ".
                    "fb_pt_app_secret='".$this->getFieldSecret()."', ".
                    "fb_pt_page_path='".$this->getFieldPath()."', ".
                    "fb_pt_page_text='".$this->getFieldText().
                    "' WHERE sample_id='1'";
            // exec the SQL statement
            if (!$database->query($SQL)) {
                // on error save the database prompt and return false
                $this->setError(sprintf('[%s - %s] %s', __METHOD__, __LINE__, $database->get_error()));
                return false;
            }
            // set message on success
            $this->setMessage($this->lang('msg_update_record'));
            return true;
        }
    } // setRecord()
    
    /**
     * Submit the template $template with the data array $template_data to the 
     * Dwoo template engine and return the resulting output.
     * 
     * Set $this->error on any error and return the Dwoo error prompts
     * 
     * @param string $template - the filename of the template (no path)
     * @param array $template_data - array with the data for the template
     * 
     * @return string output or boolean false on error
     */
    protected function getTemplate($template, $template_data) {
        // need the parser
        global $parser;
        
        try {
            // add the template path to the template file and call the parser
            $result = $parser->get($this->getTemplatePath() . $template, $template_data);
        } catch (Exception $e) {
            // on error save the Dwoo prompt in this->error
            $this->setError(sprintf('[%s - %s] %s', __METHOD__, __LINE__,
                    $this->lang(sprintf('error_executing_template', $template, $e->getMessage()))));
            return false;
        }
        return $result;
    } // getTemplate()
    
    
    /**
     * Prevent XSS Cross Site Scripting
     *
     * @param reference array $request
     * @return array $request
     */
    protected function xssPrevent(&$request) {
        if (is_string($request)) {
            $request = html_entity_decode($request);
            $request = strip_tags($request);
            $request = trim($request);
            $request = stripslashes($request);
        }
        return $request;
    } // xssPrevent()
    
    /**
     * The action handler of the class sample_admintool
     * 
     * @return string output of the result
     */
    public function action() {
        // allow any HTML or strip all requests to simple text?
        $html_allowed = array(self::REQUEST_TEXT);
        foreach ($_REQUEST as $key => $value) {
            // loop through the requests
            if (!in_array($key, $html_allowed)) {
                // prevent XSS ...
                $_REQUEST[$key] = $this->xssPrevent($value);
            }
        }
        
        // get the desired action or the the action to default
        $action = isset($_REQUEST[self::REQUEST_ACTION]) ? $_REQUEST[self::REQUEST_ACTION] : self::ACTION_DEFAULT;
        
        switch ($action):
        case self::ACTION_CHECK:
            // check if the dialog has changed ...
            $result = $this->checkDialog();
            break;
        default:
            // in any other case simply show the dialog ...
            $result = $this->getDialog();
        endswitch;
        
        if ($this->isError()) {
            // on any error return the error prompting
            echo $this->getError();
        }
        else {
            // return the result
            echo $result;
        }
    } // action()
    
    /**
     * Return the dialog of sample_admintools with a input field for a subject
     * and a WYSIWYG editor for editing any text.
     * 
     * @return string dialog
     */
    protected function getDialog() {
        /**
         * Use the LEPTON default WYSIWYG editor with the settings defined by
         * the WYSIWYG Admin.
         * 
         * Because the show_wysiwyg_editor() function directly prompt the WYSIWYG
         * editor we must save the output of the function in a variable using
         * the PHP output buffer methods
         */
        // starting output buffer
        ob_start();
            // call the WYSIWYG editor, the function will prompt into the output buffer
            show_wysiwyg_editor(self::REQUEST_TEXT, self::REQUEST_TEXT, $this->getFieldText(), '100%', '300px');
            // using ob_get_contents() we get the prompt into the variable $editor
            $editor = ob_get_contents();
        // close output buffer and clean up    
        ob_end_clean();
        
        /**
         * All data needed by the template engine to fill out and execute the 
         * template are given to the engine by a structured array.
         */
        $data = array(
                // variables needed by the form
                'form' => array(
                        // name of the form
                        'name' => 'sample_form', 
                        // target link for the form
                        'action' => $this->toolLink, 
                        // the header of the form
                        'head' => $this->lang('form_header'), 
                        // tell the template if a message exists
                        'is_message' => $this->isMessage() ? 1 : 0,
                        // show the dialog intro or a message? 
                        'intro' => $this->isMessage() ? $this->getMessage() : $this->lang('form_intro'), 
                        'btn' => array(
                                // label of the OK button
                                'ok' => $this->lang('btn_ok'),
                                // label of the ABORT button
                                'abort' => $this->lang('btn_abort')
                                )
                        ),
                // variables needed for the action handler        
                'action' => array(
                        // field name for ACTION
                        'name' => self::REQUEST_ACTION,
                        // the form will call the action CHECK the dialog 
                        'value' => self::ACTION_CHECK
                        ),
                // variables of the "dialog" - at least the database fields        
                'dialog' => array(
                        // the subject field
                        'subject' => array(
                                // the label of the field
                                'label' => $this->lang('dialog_subject_label'),
                                // the name of the field
                                'name' => self::REQUEST_SUBJECT,
                                // the value of the field
                                'value' => $this->getFieldSubject(),
                                // a additional hint for the user
                                'hint' => $this->lang('dialog_subject_hint')
                                ),
                        'text' => array(
                                // the label of the field
                                'label' => $this->lang('dialog_text_label'),
                                // the $editor variable contains the complete WYSIWYG editor
                                'editor' => $editor,
                                // a additional hint for the user
                                'hint' => $this->lang('dialog_text_hint')
                                )
                        )
                );
        // get the template for the dialog and return the result
        return $this->getTemplate('backend.dialog.lte', $data);
    } // getDialog()
    
    /**
     * This function check the dialog for changes, calls the function setRecord()
     * if anything has changed and return the dialog of the class_admintool
     * 
     * @return string dialog or boolean false on error
     */
    protected function checkDialog() {
        $record = array();
        // add $record['subject'] if field is set and changed
        if (isset($_REQUEST[self::REQUEST_SUBJECT]) && ($_REQUEST[self::REQUEST_SUBJECT] != $this->fieldSubject)) $record['subject'] = $_REQUEST[self::REQUEST_SUBJECT];
        // add $record['text'] if field is set and changed
        if (isset($_REQUEST[self::REQUEST_TEXT]) && ($_REQUEST[self::REQUEST_TEXT] != $this->fieldText)) $record['text'] = $_REQUEST[self::REQUEST_TEXT];
        
        if (count($record) > 0) {
            // change the database record
            if (!$this->setRecord($record) && $this->isError()) return false;
            // return the dialog
            return $this->getDialog();
        }
        // nothing changed, so set message and return the dialog
        $this->setMessage($this->lang('msg_nothing_changed'));
        return $this->getDialog();
    } // checkDialog()
    
} // class sample_admintool


/**
 * Init the sample_admintool class and execute the action handler
 */
$tool = new sample_admintool();
$tool->action();
