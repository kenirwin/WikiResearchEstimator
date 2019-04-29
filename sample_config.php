<?php
/* copy this file to config.php and fill in the constant values */

define (EDS_USER, '');
define (EDS_PASSWORD, '');
define (EDS_GATEWAY, ''); // this is written with a widgets.ebscohost.com address in mind
define (THIS_HTTP_PATH, ''); //e.g. http://wherever.com/path/WikiResearchEstimator/

// database not called directly so testing can occur independent of it
function getConfig ($db='phpstu',$mode='readwrite', $charset='utf8') {
    define ('HOST', ''); //domain without http://
    define ('PORT',3306);
    define ('USER','');
    define ('PASS','');
    define ('DATABASE', '');
    define ('DSN', 'mysql:host='.HOST.';dbname='.DATABASE.';charset='.$charset);
}


?>
