<?php
namespace Test\Unit\Phargs;

class OutputTest extends \PHPUnit_Framework_TestCase {
  protected function newOutputMock(){
    return new \Test\Mock\Phargs\Output();
  }

  public function testOutSimple(){
    $o = $this->newOutputMock();
    
    $o->out("Output");
    $this->assertEquals("Output", $o->last, "Last message should match original");
  }
}
