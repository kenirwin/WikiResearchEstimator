<?php

namespace WikiResearch;

use \atk4\dsql\Query;

class Harvester {
    public function __construct () {
        $this->c = \atk4\dsql\Connection::connect(DSN,USER,PASS);
        $this->initializeQuery();
    }

    function getNext() {
        
    }

    function recordGotten($id) {

    }

    public function initializeQuery() {
        $this->q = $this->c->dsql(); //new Query();
    }
}
