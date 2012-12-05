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
    $p->parse('-h -p -V');

    $this->assertTrue($p->shortFlagIsSet('h'), "Short flag [h] should be set");
    $this->assertTrue($p->shortFlagIsSet('p'), "Short flag [p] should be set");
    $this->assertTrue($p->shortFlagIsSet('V'), "Short flag [V] should be set");
  }

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

}
