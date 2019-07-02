<?php

namespace WikiResearch;

use nategood\Httpful;
use Sabre\Xml\Reader;
use voku\helper\UTF8;

/*
  usage: 
  $this->query();
  $this->fetch($uri);
  $this->loadXmlObject();
  $this->getFacets();
  $this->calculate();
*/

class Estimator {
    public function query($input) { 
        $plaintext = 'search?query='.$input.'&view=detailed&resultsperpage=10';
        $this->queryString = urlencode($plaintext);
    }

    public function getFilename($input) {
      $filename = UTF8::to_ascii($input);
      $filename = preg_replace('/[^A-Za-z0-9]+/','_',strtolower(chop($filename)));
      $filename = preg_replace('/^_/','',$filename);
      $filename = preg_replace('/_$/','',$filename);
      $filename .= '.xml';
      return $filename;
    }

    public function fetch($uri) {
        //fetch an XML page using Httpful
        //define $this->response
        $this->response = \Httpful\Request::get($uri)
                  ->expectsXml()
                  ->send();
	$this->raw_xml = $this->response->raw_body;
    }

    public function loadXmlObject () {
        $xml_string = $this->response;
        // Gets rid of all namespace definitions
        $xml_string = preg_replace('/xmlns[^=]*="[^"]*"/i', '', $xml_string);
        // Gets rid of all namespace references
        $xml_string = preg_replace('/[a-zA-Z]+:([a-zA-Z]+[=>])/', '$1', $xml_string);
        $this->xml = simplexml_load_string($xml_string);
    }

    public function getFacets() {
        $xpath = ('//*[text()="SourceType"]/..//AvailableFacetValue');
        $node = $this->xml->xpath($xpath);
        $this->facets = array();
        foreach ($node as $f) {
            $k = (string) $f->Value;
            $v = (string) $f->Count;
            $this->facets[$k] = $v;
        } 
    }

    public function calculate() {
        //calculate $this->score
        //based on ranking algorithy defined... where? config.php?
    }
}
?>