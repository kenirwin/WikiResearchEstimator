<?php
namespace WikiResearch\Test;

require dirname( dirname(__FILE__) ) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
use PHPUnit\Framework\TestCase;
use WikiResearch\Estimator;

require dirname( dirname(__FILE__) ) . DIRECTORY_SEPARATOR . 'config.php';

class EstimatorTest extends TestCase {
    public function setUp (): void {
        $this->est = new Estimator();  
    }
    public function testCreatesQueryString () {
        $input = 'terminal velocity';
        $this->est->query($input);
        $expected = 'search%3Fquery%3Dterminal+velocity%26view%3Ddetailed%26resultsperpage%3D10';
        $this->assertEquals($expected, $this->est->queryString);
    }
}
?>