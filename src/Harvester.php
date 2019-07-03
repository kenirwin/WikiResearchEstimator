<?php

namespace WikiResearch;

use \atk4\dsql\Query;

class Harvester {
    public function __construct () {
        $this->c = \atk4\dsql\Connection::connect(DSN,USER,PASS);
        $this->initializeQuery();
    }
    
    public function getBatch() {
      $this->initializeQuery();
      try { 
      $current = $this->q->table('query_batches')
	->field('id')
	->order('id','desc')
	->getOne();
      return $current;
      } catch (Exception $e) {
	print $e->getMessage();
      }
    }

    function getNext($batch) {
      $sub_q = $this->c->dsql();
      $sub_q->table('xml_results')
	->field('choreo_id')
	->where('batch_id',$batch);

      $this->initializeQuery();
      try { 
	$this->q->table('wd_choreographers')
	  ->field('name,id')
	  ->where('id','not in',$sub_q)
	  ->order('name','asc');
	$this->q->render();

	$next = $this->q->get();
        return $next[0];
      } catch (Exception $e) {
	print $e->getMessage();
      }
    }

    /*
    function updateTable($id,$xml) {
        $this->initializeQuery();
        $this->q->table('wd_choreographers')
	  ->where('id',$id)
	  ->set('eds_exported','Y')
	  ->set('eds_xml',$xml)
	  ->update();
    }
    */

    public function saveXML($choreo_id,$batch_id,$query,$xml) {
      $this->initializeQuery();
      	$response = $this->q->table('xml_results')
	  ->set('choreo_id',$choreo_id)
	  ->set('batch_id',$batch_id)
	  ->set('query',$query)
	  ->set('xml_results',$xml)
	  ->insert();
    }

    public function recordResults($id,$batch,$query,$facets) {
      foreach ($facets as $type=>$ct) {
	$this->initializeQuery();
	$response = $this->q->table('query_results')
	  ->set('choreo_id',$id)
	  ->set('batch_id',$batch)
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
