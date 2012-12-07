<?php
namespace Test\Unit\Phargs\Argument;

class ParserTest extends \PHPUnit_Framework_TestCase {
  protected function newParser(){
    return new \Phargs\Argument\Parser();
  } 

  public function testShortFlagSimple(){
    $p = $this->newParser();
    $p->addFlag('-h');
    $p->addFlag('-p');
    $p->addFlag('-V');
    $p->parse('-h -p -V');

    $this->assertTrue($p->flagIsSet('-h'), "Flag [-h] should be set");
    $this->assertTrue($p->flagIsSet('-p'), "Flag [-p] should be set");
    $this->assertTrue($p->flagIsSet('-V'), "Flag [-V] should be set");
  }

  public function testLongFlagSimple(){
    $p = $this->newParser();
    $p->addFlag('--help');
    $p->addFlag('--version');
    $p->parse('--help --version');

    $this->assertTrue($p->flagIsSet('--help'), "Flag [--help] should be set");
    $this->assertTrue($p->flagIsSet('--version'), "Flag [--version] should be set");
  }

  public function testFlagsMixed(){
    $p = $this->newParser();
    $p->addFlag('--help');
    $p->addFlag('-v');
    $p->parse('--help -v');

    $this->assertTrue($p->flagIsSet('--help'), "Flag [--help] should be set");
    $this->assertTrue($p->flagIsSet('-v'), "Flag [-v] should be set");
  }

  public function testShortParamsSimple(){
    $p = $this->newParser();
    $p->addParam('-n');
    $p->addParam('-c');
    $p->parse('-n 1000 -c 5');

    $this->assertTrue($p->paramIsSet('-n'), "Param [-n] should be set");
    $this->assertEquals('1000', $p->getParamValue('-n'), "Param [-n] value should be [1000]");

    $this->assertTrue($p->paramIsSet('-c'), "Param [-c] should be set");
    $this->assertEquals('5', $p->getParamValue('-c'), "Param [-c] value should be [5]");
  }

  public function testShortParamsNoSpace(){
    $p = $this->newParser();
    $p->addParam('-n');
    $p->addParam('-c');
    $p->parse('-n1000 -c5');

    $this->assertTrue($p->paramIsSet('-n'), "Param [-n] should be set");
    $this->assertEquals('1000', $p->getParamValue('-n'), "Param [-n] value should be [1000]");

    $this->assertTrue($p->paramIsSet('-c'), "Param [-c] should be set");
    $this->assertEquals('5', $p->getParamValue('-c'), "Param [-c] value should be [5]");
  }

  public function testShortParamsMixed(){
    $p = $this->newParser();
    $p->addParam('-n');
    $p->addParam('-c');
    $p->parse('-n1000 -c 5');

    $this->assertTrue($p->paramIsSet('-n'), "Param [-n] should be set");
    $this->assertEquals('1000', $p->getParamValue('-n'), "Param [-n] value should be [1000]");

    $this->assertTrue($p->paramIsSet('-c'), "Param [-c] should be set");
    $this->assertEquals('5', $p->getParamValue('-c'), "Param [-c] value should be [5]");
  }

  public function testLongParamsSimple(){
    $p = $this->newParser();
    $p->addParam('--number');
    $p->addParam('--count');
    $p->parse('--number 1000 --count 5');

    $this->assertTrue($p->paramIsSet('--number'), "Param [--number] should be set");
    $this->assertEquals('1000', $p->getParamValue('--number'), "Param [--number] value should be [1000]");

    $this->assertTrue($p->paramIsSet('--count'), "Param [--count] should be set");
    $this->assertEquals('5', $p->getParamValue('--count'), "Param [--count] value should be [5]");
  }

  public function testLongParamsEquals(){
    $p = $this->newParser();
    $p->addParam('--number');
    $p->addParam('--count');
    $p->parse('--number=1000 --count=5');

    $this->assertTrue($p->paramIsSet('--number'), "Param [--number] should be set");
    $this->assertEquals('1000', $p->getParamValue('--number'), "Param [--number] value should be [1000]");

    $this->assertTrue($p->paramIsSet('--count'), "Param [--count] should be set");
    $this->assertEquals('5', $p->getParamValue('--count'), "Param [--count] value should be [5]");
  }

  public function testLongParamsMixed(){
    $p = $this->newParser();
    $p->addParam('--number');
    $p->addParam('--count');
    $p->parse('--number=1000 --count 5');

    $this->assertTrue($p->paramIsSet('--number'), "Param [--number] should be set");
    $this->assertEquals('1000', $p->getParamValue('--number'), "Param [--number] value should be [1000]");

    $this->assertTrue($p->paramIsSet('--count'), "Param [--count] should be set");
    $this->assertEquals('5', $p->getParamValue('--count'), "Param [--count] value should be [5]");
  }

  public function testShortFlagCompound(){
    $p = $this->newParser();
    $p->addFlag('-h');
    $p->addFlag('-p');
    $p->addFlag('-V');
    $p->parse('-hpV');

    $this->assertTrue($p->flagIsSet('-h'), "Flag [-h] should be set from compound flags");
    $this->assertTrue($p->flagIsSet('-p'), "Flag [-p] should be set from compound flags");
    $this->assertTrue($p->flagIsSet('-V'), "Flag [-V] should be set from compound flags");
  }

  public function testAllParamsMixed(){
    $p = $this->newParser();
    $p->addParam('--number');
    $p->addParam('--count');
    $p->addParam('-n');
    $p->addParam('-c');
    $p->parse('--number 1000 --count=5 -nfoo -c bar');

    $this->assertTrue($p->paramIsSet('--number'), "Param [--number] should be set");
    $this->assertEquals('1000', $p->getParamValue('--number'), "Param [--number] value should be [1000]");

    $this->assertTrue($p->paramIsSet('--count'), "Param [--count] should be set");
    $this->assertEquals('5', $p->getParamValue('--count'), "Param [--count] value should be [5]");

    $this->assertTrue($p->paramIsSet('-n'), "Param [-n] should be set");
    $this->assertEquals('foo', $p->getParamValue('-n'), "Param [-n] value should be [foo]");

    $this->assertTrue($p->paramIsSet('-c'), "Param [-c] should be set");
    $this->assertEquals('bar', $p->getParamValue('-c'), "Param [-c] value should be [bar]");
  }

  public function testAllParamsAndFlagsMixed(){
    $p = $this->newParser();
    $p->addParam('--number');
    $p->addParam('--count');
    $p->addParam('-n');
    $p->addParam('-c');
    $p->addFlag('--help');
    $p->addFlag('-v');
    $p->parse('--number 1000 --count=5 -nfoo -c bar --help -v');

    $this->assertTrue($p->paramIsSet('--number'), "Param [--number] should be set");
    $this->assertEquals('1000', $p->getParamValue('--number'), "Param [--number] value should be [1000]");

    $this->assertTrue($p->paramIsSet('--count'), "Param [--count] should be set");
    $this->assertEquals('5', $p->getParamValue('--count'), "Param [--count] value should be [5]");

    $this->assertTrue($p->paramIsSet('-n'), "Param [-n] should be set");
    $this->assertEquals('foo', $p->getParamValue('-n'), "Param [-n] value should be [foo]");

    $this->assertTrue($p->paramIsSet('-c'), "Param [-c] should be set");
    $this->assertEquals('bar', $p->getParamValue('-c'), "Param [-c] value should be [bar]");

    $this->assertTrue($p->flagIsSet('--help'), "Flag [--help] should be set");
    $this->assertTrue($p->flagIsSet('-v'), "Flag [-v] should be set");
  }

  public function testFlagAlias(){
    $p = $this->newParser();
    $p->addFlag('-h');
    $p->addFlagAlias('-h', '--help');
    $p->parse('--help');

    $this->assertTrue($p->flagIsSet('--help'), "Flag [--help] should be set");
    $this->assertTrue($p->flagIsSet('-h'), "Flag [-h] should be set");
  }

  public function testParamAlias(){
    $p = $this->newParser(); 
    $p->addParam('-n');
    $p->addParamAlias('-n', '--number');
    $p->addParam('--count');
    $p->addParamAlias('--count', '-c');
    $p->parse('-n 5 --count=1000');

    $this->assertTrue($p->paramIsSet('-n'), "Param [-n] should be set");
    $this->assertEquals('5', $p->getParamValue('-n'), "Param [-n] value should be [5]");
    $this->assertTrue($p->paramIsSet('--number'), "Param [--number] should be set");
    $this->assertEquals('5', $p->getParamValue('--number'), "Param [--number] value should be [5]");

    $this->assertTrue($p->paramIsSet('--count'), "Param [--count] should be set");
    $this->assertEquals('1000', $p->getParamValue('--count'), "Param [--count] value should be [1000]");
    $this->assertTrue($p->paramIsSet('-c'), "Param [-c] should be set");
    $this->assertEquals('1000', $p->getParamValue('-c'), "Param [-c] value should be [1000]");
  }

  public function testArgumentsSimple(){
    $p = $this->newParser(); 
    $p->parse('help merge');

    $this->assertEquals(['help', 'merge'], $p->getArgs(), "Args should match original");
  }

  public function testArgumentsMixed(){
    $p = $this->newParser(); 
    $p->addFlag('-p');
    $p->parse('help -p merge');

    $this->assertEquals(['help', 'merge'], $p->getArgs(), "Args should match original");
  }

  public function testArgumentsMixedByIndex(){
    $p = $this->newParser(); 
    $p->addFlag('-p');
    $p->addParam('--number');
    $p->parse('--number=5 help -p merge');

    $this->assertEquals('help', $p->getArg(0), "Arg [0] should match [help]");
    $this->assertEquals('merge', $p->getArg(1), "Arg [1] should match [merge]");
  }

}
