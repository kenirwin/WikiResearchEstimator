<?php
namespace WikiResearch\Test;

require dirname( dirname(__FILE__) ) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
use PHPUnit\Framework\TestCase;
use WikiResearch\Estimator;

require dirname( dirname(__FILE__) ) . DIRECTORY_SEPARATOR . 'config.php';

class EstimatorTest extends TestCase {
    public function setUp (): void {
        $this->est = new Estimator();  
        $this->testfile = THIS_HTTP_PATH.'tests/demo_results_terminal_velocity.xml';
    }
    public function testCreatesQueryString () {
        $input = 'terminal velocity';
        $this->est->query($input);
        $expected = 'search%3Fquery%3Dterminal+velocity%26view%3Ddetailed%26resultsperpage%3D10';
        $this->assertEquals($expected, $this->est->queryString);
    }

    public function testInstantiatesHttpful() {
        $this->est->fetch($this->testfile);
        $this->assertEquals('Httpful\Response',get_class($this->est->response));
    }

    public function testLoadsXml () {
        $this->est->fetch($this->testfile);
        $this->est->loadXmlObject();
        $this->assertEquals('SimpleXMLElement', get_class($this->est->xml));
    }

    public function testGetsFacetsFromXML () {
        $this->est->fetch($this->testfile);
        $this->est->loadXmlObject();
        $this->est->getFacets();
        $this->assertIsArray($this->est->facets);
        $this->assertEquals(229, $this->est->facets['Books']);
        $this->assertEquals(2, $this->est->facets['eBooks']);
        $this->assertFalse(array_key_exists('Cuneiform Tablets',$this->est->facets));;
    }

}
?>