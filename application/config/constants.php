<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');


defined('URL_PROJETC')       OR define('URL_PROJETC', "http://localhost/Erp/");
defined('URL_PROJETC_BACKUP')       OR define('URL_PROJETC_BACKUP', "http://localhost/Erp/");
defined('SO_SERVER')       OR define('SO_SERVER', "windows");
defined('LOCALE')       OR define('LOCALE', "es_CO.utf8");
defined('LOGO_VERTICAL')       OR define('LOGO_VERTICAL', URL_PROJETC."dist/img/logo-vertical.png");
/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

//datatable
defined('DATATABLES_CSS')      OR define('DATATABLES_CSS', 'datatables/dataTables.bootstrap.css'); 
defined('DATATABLES_JS')      OR define('DATATABLES_JS', 'datatables/jquery.dataTables.min.js'); 
defined('DATATABLES_JS_B')      OR define('DATATABLES_JS_B', 'datatables/dataTables.bootstrap.min.js');
$array = serialize(
        array(
            "datatables/dataTables.buttons.min.js",
            "datatables/buttons.html5.min.js",
            "datatables/buttons.bootstrap.min.js",
            "datatables/jszip.min.js",
            "datatables/pdfmake.min.js",
            "datatables/vfs_fonts.js"
            )
        );
//numeric
defined('AUTO_NUMERIC')    OR define('AUTO_NUMERIC','autonumeric/autoNumeric-min.js');

defined('BTN_DATATABLE_JS')    OR define('BTN_DATATABLE_JS',$array);
defined('BTN_DATATABLE_CSS')    OR define('BTN_DATATABLE_CSS','datatables/buttons.dataTables.min.css');

//datatable2
defined('DATATABLES_CSS2')      OR define('DATATABLES_CSS2', 'DataTable/dataTables.min.css'); 
defined('DATATABLES_JS2')      OR define('DATATABLES_JS2', 'DataTable/dataTables.min.js');

//swalert
defined('SWEETALERT_JS')    OR define('SWEETALERT_JS','sweetalert/sweetalert2.min.js');
defined('SWEETALERT_CSS')      OR define('SWEETALERT_CSS','sweetalert/sweetalert2.min.css');

//SELECT2
defined('SELECT2_JS')    OR define('SELECT2_JS','select2/select2.full.js');
defined('SELECT2_CSS')      OR define('SELECT2_CSS','select2/select2.min.css');

//iCheck
defined('ICHECK_CSS_RED')    OR define('ICHECK_CSS_RED', 'iCheck/minimal/red.css');
defined('ICHECK_CSS_FLAT')    OR define('ICHECK_CSS_FLAT', 'iCheck/flat/_all.css');
defined('ICHECK_CSS_BLUE')    OR define('ICHECK_CSS_BLUE', 'iCheck/minimal/blue.css');
defined('ICHECK_JS')      OR define('ICHECK_JS','iCheck/icheck.min.js');


defined('FULL_CALENDAR_CSS')    OR define('FULL_CALENDAR_CSS', 'fullcalendar/fullcalendar.min.css');
defined('FULL_CALENDAR_JS')    OR define('FULL_CALENDAR_JS', 'fullcalendar/fullcalendar.min.js');
defined('FULL_SCHELUDER_CSS')    OR define('FULL_SCHELUDER_CSS', 'fullcalendar/scheduler.min.css');
defined('FULL_SCHELUDER_JS')    OR define('FULL_SCHELUDER_JS', 'fullcalendar/scheduler.min.js');
defined('LOCALE')    OR define('LOCALE', 'fullcalendar/locale-all.js');
defined('MOMENT')    OR define('MOMENT', 'fullcalendar/moment.min.js');

defined('DATEPICKER_CSS')    OR define('DATEPICKER_CSS', 'bootstrap-datepicker/css/bootstrap-datepicker.min.css');
defined('DATEPICKER_MULTIPLE')    OR define('DATEPICKER_MULTIPLE', 'bootstrap-datepicker/css/multiple.css');
defined('DATEPICKER_JS')    OR define('DATEPICKER_JS', 'bootstrap-datepicker/js/bootstrap-datepicker.min.js');

//BARCODE
defined('BARCODE_JS')    OR define('BARCODE_JS', 'JsBarcode/dist/JsBarcode.all.js');
defined('BARCODE39_JS')    OR define('BARCODE39_JS', 'JsBarcode/dist/barcodes/JsBarcode.code39.min.js');

//FILETREE
defined('TREE_CSS')    OR define('TREE_CSS',"jqueryFileTree/jqueryFileTree.css");
defined('TREE_JS')    OR define('TREE_JS',"jqueryFileTree/jquery.easing.js");
defined('TREE_JS2')    OR define('TREE_JS2', "jqueryFileTree/jqueryFileTree.js");

//ALERTIFY

defined('ALERTIFY_CSS')    OR define('ALERTIFY_CSS','alertifyjs/css/alertify.min.css');
defined('ALERTIFY_CSS2')    OR define('ALERTIFY_CSS2','alertifyjs/css/themes/bootstrap.min.css');
defined('ALERTIFY_JS')     OR define('ALERTIFY_JS','alertifyjs/alertify.js');


//TIMEPICKER

defined('TIMEPICKER_JS') OR define('TIMEPICKER_JS','timepicker/bootstrap-timepicker.min.js');
defined('TIMEPICKER_CSS') OR define('TIMEPICKER_CSS','timepicker/bootstrap-timepicker.min.css');

//RANGO
defined('RANGOPICKER_CSS')      OR define('RANGOPICKER_CSS','daterangepicker/daterangepicker-bs3.css');
defined('RANGOPICKER_JS')      OR define('RANGOPICKER_JS','daterangepicker/daterangepicker.js');

defined('OTHER_RANGOPICKER_CSS')      OR define('OTHER_RANGOPICKER_CSS','bootstrap-daterangepicker/daterangepicker.css');
defined('OTHER_RANGOPICKER_JS')      OR define('OTHER_RANGOPICKER_JS','bootstrap-daterangepicker/daterangepicker.js');

defined('CKEDITOR_JS')      OR define('CKEDITOR_JS','ckeditor/ckeditor.js');

//FILER
defined('FILER_JS')      OR define('FILER_JS','jQuery.filer/js/jquery.filer.min.js');
defined('FILER_CSS')      OR define('FILER_CSS','jQuery.filer/css/jquery.filer.css');
//MORRIS
defined('MORRIS_JS')      OR define('MORRIS_JS','morris.js/morris.min.js');
defined('MORRIS_JS2')      OR define('MORRIS_JS2','raphael/raphael.min.js');
defined('MORRIS_CSS')      OR define('MORRIS_CSS','morris.js/morris.css');