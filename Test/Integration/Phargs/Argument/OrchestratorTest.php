<?php
namespace Test\Integration\Phargs\Argument;

class OrchestratorTest extends \PHPUnit_Framework_TestCase {
  protected function newOrchestrator(Array $argv = []){
    return new \Phargs\Argument\Orchestrator(
      new \Phargs\Argument\Parser(), $argv
    );
  }

  public function testStripCommand(){
    $o = $this->newOrchestrator(['./command', 'help', 'merge']);  

    $this->assertEquals('./command', $o->getCommandName(), "Command name should be [./command]");
    $this->assertEquals(2, $o->getArgCount(), "Arg count should be [2]");
  }
}
