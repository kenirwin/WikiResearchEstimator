<?php
$first = get_declared_classes();

require_once '../vendor/autoload.php';
require_once '../config.php';

use WikiResearch\Estimator;
$last = get_declared_classes();

//var_dump(array_diff($first, $last));
print_r($first);
print_r($last);
?>