<?php
namespace Test\Unit\Phargs\Formatter;

class TsvTest extends \PHPUnit_Framework_TestCase {
  protected function newTsv(Array $fields = array()){
    return new \Phargs\Formatter\Tsv($fields);
  }

  public function testConstruct(){
    $t = $this->newTsv(array('id', 'name'));

    $this->assertInstanceOf('\\Phargs\\Formatter\\Tsv', $t, "Object should have been instance of [\\Phargs\\Formatter\\Tsv]");
    $this->assertEquals(2, $t->getFieldCount(), "Field count should have been [2]");
  }

  public function testAddRowHappy(){
    $t = $this->newTsv(array('id', 'name'));
    
    $t->addRow(array(1, 'tom'));
    $t->addRow(array(2, 'dick'));

    $this->assertEquals(2, $t->getRowCount(), "Row count should have been [2]");
  }

  public function testAddRowSad(){
    $t = $this->newTsv(array('id', 'name'));

    $t->addRow(array(1, 'tom'));
    $t->addRow(array(2)); // Not enough fields
    $t->addRow(array(3, 'harry', '42')); // Too many fields

    $this->assertEquals(1, $t->getRowCount(), "Row count should have been [1]");
  }

  public function testAddRows(){
    $t = $this->newTsv(array('id', 'name'));

    $t->addRows(array(
      array(1, 'tom'),
      array(2, 'dick'),
      array(3, 'harry')
    ));

    $this->assertEquals(3, $t->getRowCount(), "Row count should have been [3]");
  }

  public function testFieldWidths(){
    $t = $this->newTsv(array('id', 'name'));

    $t->addRow(array(1, 'tom'));
    $t->addRow(array(2, 'dick'));
    $t->addRow(array(3, 'harry'));

    $rows = explode(PHP_EOL, $t->getTsvString());
    $this->assertEquals("id\tname", $rows[0], "Row should have matched expected");
    $this->assertEquals("1\ttom", $rows[1], "Row should have matched expected");
    $this->assertEquals("2\tdick", $rows[2], "Row should have matched expected");
    $this->assertEquals("3\tharry", $rows[3], "Row should have matched expected");
  }

  public function testToString(){
    $t = $this->newTsv(array('id', 'name'));

    $t->addRow(array(1, 'tom'));
    $t->addRow(array(2, 'dick'));
    $t->addRow(array(3, 'harry'));
    
    $this->assertEquals($t->getTsvString(), (string) $t, "__toString output should match getTsvString() output");
  }
}
