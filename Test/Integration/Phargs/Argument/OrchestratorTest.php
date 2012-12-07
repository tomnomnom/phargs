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

  public function testFlag(){
    $o = $this->newOrchestrator(['./command', '-h']);
    $o->expectFlag('-h');

    $this->assertTrue($o->flagIsSet('-h'), "Flag [-h] should be set");
  }

  public function testFlagAlias(){
    $o = $this->newOrchestrator(['./command', '--help']);
    $o->expectFlag('-h');
    $o->addFlagAlias('-h', '--help');

    $this->assertTrue($o->flagIsSet('-h'), "Flag [-h] should be set");
    $this->assertTrue($o->flagIsSet('--help'), "Flag [--help] should be set");
  }

  public function testParam(){
    $o = $this->newOrchestrator(['./command', '--number=5']);
    $o->expectParam('--number');

    $this->assertTrue($o->paramIsSet('--number'), "Param [--number] should be set");
    $this->assertEquals('5', $o->getParamValue('--number'), "Param [--number] value should be [5]");
  }

  public function testParamAlias(){
    $o = $this->newOrchestrator(['./command', '--number=5']);
    $o->expectParam('-n');
    $o->addParamAlias('-n', '--number');

    $this->assertTrue($o->paramIsSet('-n'), "Param [-n] should be set");
    $this->assertEquals('5', $o->getParamValue('-n'), "Param [-n] value should be [5]");

    $this->assertTrue($o->paramIsSet('--number'), "Param [--number] should be set");
    $this->assertEquals('5', $o->getParamValue('--number'), "Param [--number] value should be [5]");
  }
}
