<?php

namespace WikiResearch;

use \atk4\dsql\Query;

class Harvester {
    public function __construct () {
        $this->c = \atk4\dsql\Connection::connect(DSN,USER,PASS);
        $this->initializeQuery();
    }

    function getNext() {
        $this->initializeQuery();
        $next = $this->q->table('wd_choreographers')
              ->field('name,id')
              ->where('eds_exported',null)
              ->order('name','asc')
              ->get();
        //        return $this->q->render();
        return $next[0];
    }

    function updateTable($id,$xml) {
        $this->initializeQuery();
        $this->q->table('wd_choreographers')
	  ->where('id',$id)
	  ->set('eds_exported','Y')
	  ->set('eds_xml',$xml)
	  ->update();
    }

    public function recordResults($id,$query,$facets) {
      foreach ($facets as $type=>$ct) {
	$this->initializeQuery();
	$response = $this->q->table('query_results')
	  ->set('choreo_id',$id)
	  ->set('query',$query)
	  ->set('source_type',$type)
	  ->set('count',$ct)
	  ->insert();
      }
      return $response;
    }

    public function initializeQuery() {
        $this->q = $this->c->dsql(); //new Query();
    }
}
