<?php

namespace WikiResearch;

use nategood\Httpful;

/*
  usage: 
  $this->query();
  $this->fetch();
  $this->getFacets();
  $this->calculate();
*/

class Estimator {
    public function query($input) { 
        $plaintext = 'search?query='.$input.'&view=detailed&resultsperpage=10';
        $this->queryString = urlencode($plaintext);
    }

    public function fetch($uri) {
        //fetch an XML page using Httpful
        //define $this->response
        $this->response = \Httpful\Request::get($uri)
                  ->expectsXml()
                  ->send();
    }

    public function loadXmlFromFile() {

    }
    
    public function getFacets() {
        //$this->facets = array ('books'=>$count, 'articles'=>$count)
    }

    public function calculate() {
        //calculate $this->score
        //based on ranking algorithy defined... where? config.php?
    }
}
?>