<?php
namespace Test\Unit\Phargs\Formatter;

class TableTest extends \PHPUnit_Framework_TestCase {
  protected function newTable(Array $fields = array()){
    return new \Phargs\Formatter\Table($fields);
  }

  public function testConstruct(){
    $t = $this->newTable(array('id', 'name'));

    $this->assertInstanceOf('\\Phargs\\Formatter\\Table', $t, "Object should have been instance of [\\Phargs\\Formatter\\Table]");
    $this->assertEquals(2, $t->getFieldCount(), "Field count should have been [2]");
  }

  public function testAddRowHappy(){
    $t = $this->newTable(array('id', 'name'));
    
    $t->addRow(array(1, 'tom'));
    $t->addRow(array(2, 'dick'));

    $this->assertEquals(2, $t->getRowCount(), "Row count should have been [2]");
  }

  public function testAddRowSad(){
    $t = $this->newTable(array('id', 'name'));

    $t->addRow(array(1, 'tom'));
    $t->addRow(array(2)); // Not enough fields
    $t->addRow(array(3, 'harry', '42')); // Too many fields

    $this->assertEquals(1, $t->getRowCount(), "Row count should have been [1]");
  }

  public function testAddRows(){
    $t = $this->newTable(array('id', 'name'));

    $t->addRows(array(
      array(1, 'tom'),
      array(2, 'dick'),
      array(3, 'harry')
    ));

    $this->assertEquals(3, $t->getRowCount(), "Row count should have been [3]");
  }

  public function testFieldWidths(){
    $t = $this->newTable(array('id', 'name'));

    $t->addRow(array(1, 'tom'));
    $t->addRow(array(2, 'dick'));
    $t->addRow(array(3, 'harry'));

    $rows = explode(PHP_EOL, $t->getTableString());
    $this->assertEquals('+----+-------+', $rows[0], "Row should have matched expected");
    $this->assertEquals('| id | name  |', $rows[1], "Row should have matched expected");
    $this->assertEquals('+----+-------+', $rows[2], "Row should have matched expected");
    $this->assertEquals('| 1  | tom   |', $rows[3], "Row should have matched expected");
    $this->assertEquals('| 2  | dick  |', $rows[4], "Row should have matched expected");
    $this->assertEquals('| 3  | harry |', $rows[5], "Row should have matched expected");
    $this->assertEquals('+----+-------+', $rows[6], "Row should have matched expected");
  }

  public function testToString(){
    $t = $this->newTable(array('id', 'name'));

    $t->addRow(array(1, 'tom'));
    $t->addRow(array(2, 'dick'));
    $t->addRow(array(3, 'harry'));
    
    $this->assertEquals($t->getTableString(), (string) $t, "__toString output should match getTableString() output");
  }
}
