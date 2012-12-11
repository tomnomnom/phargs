<?php
namespace Test\Integration\Phargs;

class FactoryTest extends \PHPUnit_Framework_TestCase {
  protected function newFactory(){
    return new \Phargs\Factory();
  }

  public function testConstruct(){
    $f = $this->newFactory();
    
    $this->assertInstanceOf('\\Phargs\\Factory', $f, "Returned factory should be instance of [\\Phargs\\Factory]");
  }

  public function testScreen(){
    $f = $this->newFactory();
    $s = $f->screen();
    $this->assertInstanceOf('\\Phargs\\Io\\Screen', $s, "Returned object should be instance of [\\Phargs\\Io\\Screen]");
  }

  public function testArgumentOrchestrator(){
    $f = $this->newFactory();
    $a = $f->args();
    $this->assertInstanceOf('\\Phargs\\Argument\\Orchestrator', $a, "Returned object should be instance of [\\Phargs\\Argument\\Orchestrator]");
  }
}
