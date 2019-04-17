<?php

namespace WikiResearch;

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

    public function fetch() {
        //fetch an XML page using Httpful
        //define $this->response
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