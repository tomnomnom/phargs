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

  public function testRequiredFlagsHappy(){
    $o = $this->newOrchestrator(['./command', '-h', '-p']);
    $o->expectFlag('-h', 'Test flag', true);
    $o->expectFlag('-p', 'Test flag', true);

    $this->assertTrue($o->flagIsSet('-h'), "Flag [-h] should be set");
    $this->assertTrue($o->flagIsSet('-p'), "Flag [-p] should be set");

    $this->assertTrue($o->requirementsAreMet(), "All Orchestrator requirements should be met");
  }

  public function testRequiredFlagsSad(){
    $o = $this->newOrchestrator(['./command', '-r', '-p']);
    $o->expectFlag('-r', 'Test flag', false);
    $o->expectFlag('-h', 'Test flag', true);
    $o->expectFlag('-p', 'Test flag', true);

    $this->assertTrue($o->flagIsSet('-r'), "Flag [-r] should be set");
    $this->assertFalse($o->flagIsSet('-h'), "Flag [-h] should not be set");
    $this->assertTrue($o->flagIsSet('-p'), "Flag [-p] should be set");

    $this->assertFalse($o->requirementsAreMet(), "Orchestrator requirements should not be met");
  }

  public function testRequiredParamsHappy(){
    $o = $this->newOrchestrator(['./command', '--number=5', '--count=1000']);
    $o->expectParam('--number', 'Test param', true);
    $o->expectParam('--count', 'Test param', true);

    $this->assertTrue($o->paramIsSet('--number'), "Param [--number] should be set");
    $this->assertEquals('5', $o->getParamValue('--number'), "Param [--number] value should be [5]");

    $this->assertTrue($o->paramIsSet('--count'), "Param [--count] should be set");
    $this->assertEquals('1000', $o->getParamValue('--count'), "Param [--count] value should be [1000]");

    $this->assertTrue($o->requirementsAreMet(), "All Orchestrator requirements should be met");
  }

  public function testRequiredParamsSad(){
    $o = $this->newOrchestrator(['./command', '--number=5', '--cheese=chedder']);
    $o->expectParam('--cheese', 'Test param', false);
    $o->expectParam('--number', 'Test param', true);
    $o->expectParam('--count', 'Test param', true);

    $this->assertTrue($o->paramIsSet('--cheese'), "Param [--cheese] should be set");
    $this->assertEquals('chedder', $o->getParamValue('--cheese'), "Param [--cheese] value should be [chedder]");

    $this->assertTrue($o->paramIsSet('--number'), "Param [--number] should be set");
    $this->assertEquals('5', $o->getParamValue('--number'), "Param [--number] value should be [5]");

    $this->assertFalse($o->paramIsSet('--count'), "Param [--count] should not be set");

    $this->assertFalse($o->requirementsAreMet(), "Orchestrator requirements should not be met");
  }

  public function testGetExpectedFlags(){
    $o = $this->newOrchestrator(); 
    $o->expectFlag('-h');
    $o->expectFlag('-p');

    $this->assertEquals(2, sizeOf($o->getExpectedFlags()), "There should be [2] expected flags");
  }

  public function testGetExpectedParams(){
    $o = $this->newOrchestrator(); 
    $o->expectParam('-h');
    $o->expectParam('-p');

    $this->assertEquals(2, sizeOf($o->getExpectedParams()), "There should be [2] expected params");
  }
}
