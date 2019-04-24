<?php
require_once '../vendor/autoload.php';
require_once '../config.php';

use WikiResearch\Estimator;
?>
<form>
<input type="text" name="qs"><input type="submit">
</form>
<?php        
     if (array_key_exists('qs',$_REQUEST)) {
         try {
             $eds = new Estimator();
             $str = $_REQUEST['qs'];
             $eds->query($str);

             $underscores = preg_replace('/ +/','_',strtolower(chop($str)));
             $uri = EDS_GATEWAY . $eds->queryString;
             print '<span class="output">'.PHP_EOL;
             print 'curl "'.$uri.'" > demo_results_'.$underscores.'.xml';
             print '</span>'.PHP_EOL;
             /*
               $eds->fetch($uri);
               $eds->loadXmlObject();
               $eds->getFacets();
               
               print_r($eds->facets)
             */
         } catch (Exception $e) {
             print '<pre>';
             var_dump($e);
         }
     }
     
     ?>