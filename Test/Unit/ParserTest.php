<?php
namespace Test\Unit\Phargs;

class ParserTest extends \PHPUnit_Framework_TestCase {
  protected function newParser(){
    return new \Phargs\Parser();
  } 

  public function testConstructArray(){
    $p = $this->newParser();
    $p->parse([1,2,3]);
    $this->assertEquals([1,2,3], $p->getRawArgv(), "Raw argv should match original array");
  }

  public function testConstructString(){
    $p = $this->newParser();
    $p->parse('1 2 3');
    $this->assertEquals([1,2,3], $p->getRawArgv(), "Raw argv should match original string split on space");
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

  /*
  public function testCompoundShortFlags(){
    $p = $this->newParser();
    $p->parse('-hpV');

    $this->assertTrue($p->shortFlagIsSet('h'), "Short flag [h] should be set");
    $this->assertTrue($p->shortFlagIsSet('p'), "Short flag [p] should be set");
    $this->assertTrue($p->shortFlagIsSet('V'), "Short flag [V] should be set");
  }

  public function testLongFlags(){
    $p = $this->newParser();
    $p->parse('--help --version');

    $this->assertTrue($p->longFlagIsSet('help'),    "Long flag [help] should be set");
    $this->assertTrue($p->longFlagIsSet('version'), "Long flag [version] should be set");
  }

  public function testMixedFlags(){
    $p = $this->newParser();
    $p->parse('--help -v -Hnr');

    $this->assertTrue($p->flagIsSet('help'), "Long flag [help] should be set");
    $this->assertTrue($p->flagIsSet('v'),    "Short flag [v] should be set");
    $this->assertTrue($p->flagIsSet('H'),    "Short flag [H] should be set");
    $this->assertTrue($p->flagIsSet('n'),    "Short flag [n] should be set");
    $this->assertTrue($p->flagIsSet('r'),    "Short flag [r] should be set");
  }

  public function testLongValuesEquals(){
    $p = $this->newParser();
    $p->parse('--prefix=/usr/bin --with-mysql=/who/cares');

    $this->assertTrue($p->longValueIsSet('prefix'), "Long value [prefix] should have been set");
    $this->assertEquals('/usr/bin', $p->getLongValue('prefix'), "Long value [prefix] should have been [/usr/bin]");

    $this->assertTrue($p->longValueIsSet('with-mysql'), "Long value [with-mysql] should have been set");
    $this->assertEquals('/who/cares', $p->getLongValue('with-mysql'), "Long value [with-mysql] should have been [/who/cares]");
  }

  public function testLongValuesSpace(){
    $p = $this->newParser();
    $p->parse('--prefix /usr/bin --with-mysql /who/cares');

    $this->assertTrue($p->longValueIsSet('prefix'), "Long value [prefix] should have been set");
    $this->assertEquals('/usr/bin', $p->getLongValue('prefix'), "Long value [prefix] should have been [/usr/bin]");

    $this->assertTrue($p->longValueIsSet('with-mysql'), "Long value [with-mysql] should have been set");
    $this->assertEquals('/who/cares', $p->getLongValue('with-mysql'), "Long value [with-mysql] should have been [/who/cares]");
  }

  public function testShortValues(){
    $p = $this->newParser();
    $p->parse('-u username -p passwd');

    $this->assertTrue($p->shortValueIsSet('u'), "Short value [u] should have been set");
    $this->assertEquals('username', $p->getShortValue('u'), "Short value [u] should have been [username]");

    $this->assertTrue($p->shortValueIsSet('p'), "Short value [p] should have been set");
    $this->assertEquals('passwd', $p->getShortValue('p'), "Short value [p] should have been [passwd]");
  }

  public function testShortFlagsAndShortValues(){
    $p = $this->newParser(); 
    $p->parse('-v -b -u username -p passwd');

    $this->assertTrue($p->flagIsSet('v'), "Short flag [v] should be set");
    $this->assertTrue($p->flagIsSet('b'), "Short flag [b] should be set");

    $this->assertTrue($p->shortValueIsSet('u'), "Short value [u] should have been set");
    $this->assertEquals('username', $p->getShortValue('u'), "Short value [u] should have been [username]");

    $this->assertTrue($p->shortValueIsSet('p'), "Short value [p] should have been set");
    $this->assertEquals('passwd', $p->getShortValue('p'), "Short value [p] should have been [passwd]");
  }

  public function testLongFlagsAndLongValues(){
    $p = $this->newParser(); 
    $p->parse('--version --help --prefix=/usr/bin --with-mysql /who/cares');

    $this->assertTrue($p->longFlagIsSet('help'),    "Long flag [help] should be set");
    $this->assertTrue($p->longFlagIsSet('version'), "Long flag [version] should be set");

    $this->assertTrue($p->longValueIsSet('prefix'), "Long value [prefix] should have been set");
    $this->assertEquals('/usr/bin', $p->getLongValue('prefix'), "Long value [prefix] should have been [/usr/bin]");

    $this->assertTrue($p->longValueIsSet('with-mysql'), "Long value [with-mysql] should have been set");
    $this->assertEquals('/who/cares', $p->getLongValue('with-mysql'), "Long value [with-mysql] should have been [/who/cares]");
  }

  public function testAllMixed(){

    $p = $this->newParser(); 
    $p->parse('--version --help --prefix=/usr/bin -u username --with-mysql /who/cares -v -b -Hnr');

    $this->assertTrue($p->longFlagIsSet('help'),    "Long flag [help] should be set");
    $this->assertTrue($p->longFlagIsSet('version'), "Long flag [version] should be set");

    $this->assertTrue($p->longValueIsSet('prefix'), "Long value [prefix] should have been set");
    $this->assertEquals('/usr/bin', $p->getLongValue('prefix'), "Long value [prefix] should have been [/usr/bin]");

    $this->assertTrue($p->shortValueIsSet('u'), "Short value [u] should have been set");
    $this->assertEquals('username', $p->getShortValue('u'), "Short value [u] should have been [username]");

    $this->assertTrue($p->longValueIsSet('with-mysql'), "Long value [with-mysql] should have been set");
    $this->assertEquals('/who/cares', $p->getLongValue('with-mysql'), "Long value [with-mysql] should have been [/who/cares]");

    $this->assertTrue($p->flagIsSet('v'), "Short flag [v] should be set");
    $this->assertTrue($p->flagIsSet('b'), "Short flag [b] should be set");
    $this->assertTrue($p->flagIsSet('H'), "Short flag [H] should be set");
    $this->assertTrue($p->flagIsSet('n'), "Short flag [n] should be set");
    $this->assertTrue($p->flagIsSet('r'), "Short flag [r] should be set");
  
  }
  */

}
