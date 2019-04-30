<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

namespace WikiResearch\Test;

include 'setVerboseErrorHandler.php';
require dirname( dirname(__FILE__) ) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
use PHPUnit\Framework\TestCase;
use WikiResearch\Harvester;

define ('DSN','sqlite::memory:');
define ('USER',null);
define ('PASS',null);

//require dirname( dirname(__FILE__) ) . DIRECTORY_SEPARATOR . 'config.php';

class HarvesterTest extends TestCase {
  public function testMath() {
    $x = 1+1;
    $this->expectEquals(2,$x);
  }
  /*
  public function setUp () {
    setVerboseErrorHandler();  
      $this->db = new Harvester();
      $this->createTable();
      $this->populateTable();
    }

    public function testConnectByAtk () {
        $this->assertInternalType(
            'object',
            $this->db->c,
            'this->db->c should be an object'
        );
        $this->assertEquals(
            'atk4\dsql\Connection',
            get_class($this->db->c),
            'this->db->c should be a dsql Connection'
        );
        $this->assertEquals(
            'WikiResearch\Harvester',
            get_class($this->db),
            'this->db should be a WikiResearch\Harvester'
        );
    }
    public function testDatabaseHasThreeRows()
    {
        $data = $this->db->q->table('wd_choreographers')->get();
        $this->assertEquals(
            3,
            sizeof($data)
        );
    }
    public function testGetNext() {
        $next = $this->db->getNext();
        $this->assertEquals(
            'A G Cecilia (Cissi) Olsson',
            $next
        );
    }
    public function testUpdateTable() {
        $id = 1; 
        $this->db->updateTable($id);
        $this->db->initializeQuery();
        $r = $this->db->q->table('wd_choreographers')
            ->field('eds_exported')
           ->where('id',$id)
            ->get();
        $this->assertEquals(
            'Y',
            $r[0]['eds_exported']
        );
    }
  */
    private function initializeQuery() {
        $this->db->q = $this->db->dsql(); //new Query();
    }

    public function createTable() {
        $query = "
        CREATE TABLE `wd_choreographers` (
           `id` int(11) NOT NULL,
            `name` varchar(34) DEFAULT NULL,
            `image` varchar(21) DEFAULT NULL,
            `description` varchar(234) DEFAULT NULL,
            `country_of_citizenship` varchar(40) DEFAULT NULL,
            `date_of_birth` varchar(12) DEFAULT NULL,
            `date_of_death` varchar(12) DEFAULT NULL,
            `place_of_birth` varchar(35) DEFAULT NULL,
            `place_of_death` varchar(27) DEFAULT NULL,
            `wikidata_item` varchar(9) DEFAULT NULL,
            `site_links` int(11) DEFAULT NULL,
            `eds_exported` char(1) DEFAULT NULL,
            PRIMARY KEY (`id`)
        )";
        $this->db->q->Expr($query)->execute($this->db->c);
    }

    protected function populateTable() {
        $queries = [
            "INSERT INTO `wd_choreographers` (`id`, `name`, `image`, `description`, `country_of_citizenship`, `date_of_birth`, `date_of_death`, `place_of_birth`, `place_of_death`, `wikidata_item`, `site_links`, `eds_exported`) VALUES
            (1,'A G Cecilia (Cissi) Olsson',NULL,'Swedish dancer and choreographer (1906–1989) ♀','Sweden','2433','32619','Jakob','Danderyd','Q42780970',1,NULL),
            (2,'Ada Einmo Jürgensen',NULL,'Norwegian choreographer','Norway','18794',NULL,'Mo i Rana',NULL,'Q11956883',1,NULL),
            (3,'Ada Méndez',NULL,'Argentinian actor','Argentina',NULL,NULL,'Buenos Aires',NULL,'Q16526858',4,NULL)"
        ];
        foreach ($queries as $query) {
            $this->db->initializeQuery();
            $r = $this->db->q->Expr($query)->execute($this->db->c);
        }
    }
}
