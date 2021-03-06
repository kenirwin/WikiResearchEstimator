<?php
namespace WikiResearch\Test;

require dirname( dirname(__FILE__) ) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
use PHPUnit\Framework\TestCase;
use WikiResearch\Harvester;

define ('DSN','sqlite::memory:');
define ('USER',null);
define ('PASS',null);

require dirname( dirname(__FILE__) ) . DIRECTORY_SEPARATOR . 'config.php';

class HarvesterTest extends TestCase {
  protected function setUp(): void 
  {
    $this->db = new Harvester();
    $this->createTable();
    $this->populateTable();
    $this->x = 1+1;
    $this->xml = file_get_contents('tests/demo_results_terminal_velocity.xml'); 
  }

  public function testMath() {
    $this->assertEquals(2,$this->x);
  }

    public function testConnectByAtk () {
      $cType = get_class($this->db->c);
      $this->assertTrue(
			is_object($this->db->c),
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
      $batch = 1; 
        $next = $this->db->getNext($batch);
        $this->assertEquals(
            'A G Cecilia (Cissi) Olsson',
            $next['name']
        );
        $this->assertEquals(
            1,
            $next['id']
        );

    }

    /*
    public function testUpdateTable() {
        $id = 1; 
        $this->db->updateTable($id,$this->xml);
        $this->db->initializeQuery();
        $r = $this->db->q->table('wd_choreographers')
	  ->field('eds_exported,eds_xml')
	  ->where('id',$id)
	  ->get();
        $this->assertEquals(
            'Y',
            $r[0]['eds_exported']
        );
	$this->assertRegExp('/^<SearchResponseMessageGet/',$r[0]['eds_xml']);
	$this->assertRegExp('/<\/SearchResponseMessageGet>$/',$r[0]['eds_xml']);
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
            `eds_xml` longtext DEFAULT NULL,
            PRIMARY KEY (`id`)
        )";
        $this->db->q->Expr($query)->execute($this->db->c);

	$query = "CREATE TABLE `xml_results` (
`id` int(11) NOT NULL,
`batch_id` int(11) NOT NULL,
`choreo_id` int(11) NOT NULL,
`query` varchar(255) NOT NULL,
`xml_results` blob NOT NULL,
PRIMARY KEY (`id`)
)";
	$this->db->initializeQuery();
        $this->db->q->Expr($query)->execute($this->db->c);

$query = "CREATE TABLE `query_results` (
  `id` int(11) NOT NULL,
  `choreo_id` int(11) NOT NULL,
  `query` varchar(255) NOT NULL,
  `source_type` varchar(255) NOT NULL,
  `count` int(11) NOT NULL
)";

	$this->db->initializeQuery();
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

