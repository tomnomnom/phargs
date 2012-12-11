<?php
namespace Test\Unit\Phargs\Io;

class ScreenTest extends \PHPUnit_Framework_TestCase {
  protected function newMockWriter(){
    return new \Test\Mock\Phargs\Io\Writer();
  }
  protected function newScreen(\Test\Mock\Phargs\Io\Writer $w){
    return new \Phargs\Io\Screen($w);
  }

  public function testOutBasic(){
    $w = $this->newMockWriter(); 
    $s = $this->newScreen($w);

    $s->out('hello, world!');
    $this->assertEquals('hello, world!', $w->lastMsg, "Last message should have been [hello, world!]");
  }

  public function testOutStyled(){
    $w = $this->newMockWriter(); 
    $s = $this->newScreen($w);

    $s->out('hello, world!', 'red', 'green', 'bold');
    $this->assertEquals('hello, world!', $w->lastMsg, "Last message should have been [hello, world!]");
    $this->assertEquals(array('hello, world!', 'red', 'green', 'bold'), $w->lastStyle, "Last style should have matched [hello, world!, red, green, bold]");
  }

  public function testOutlnBasic(){
    $w = $this->newMockWriter(); 
    $s = $this->newScreen($w);

    $s->outln('hello, world!');
    $this->assertEquals('hello, world!'.PHP_EOL, $w->lastMsg, "Last message should have been [hello, world!\\n]");
  }

  public function testOutlnStyled(){
    $w = $this->newMockWriter(); 
    $s = $this->newScreen($w);

    $s->outln('hello, world!', 'red', 'green', 'bold');
    $this->assertEquals('hello, world!'.PHP_EOL, $w->lastMsg, "Last message should have been [hello, world!\\n]");
    $this->assertEquals(array('hello, world!'.PHP_EOL, 'red', 'green', 'bold'), $w->lastStyle, "Last style should have matched [hello, world!\\n, red, green, bold]");
  }

  public function testErrBasic(){
    $w = $this->newMockWriter(); 
    $s = $this->newScreen($w);

    $s->err('error message');
    $this->assertEquals('error message', $w->lastErr, "Last message should have been [error message]");
  }

  public function testErrStyled(){
    $w = $this->newMockWriter(); 
    $s = $this->newScreen($w);

    $s->err('error message', 'red', 'green', 'bold');
    $this->assertEquals('error message', $w->lastErr, "Last message should have been [error message]");
    $this->assertEquals(array('error message', 'red', 'green', 'bold'), $w->lastStyle, "Last style should have matched [error message, red, green, bold]");
  }

  public function testErrlnBasic(){
    $w = $this->newMockWriter(); 
    $s = $this->newScreen($w);

    $s->errln('error message');
    $this->assertEquals('error message'.PHP_EOL, $w->lastErr, "Last message should have been [error message\\n]");
  }

  public function testErrlnStyled(){
    $w = $this->newMockWriter(); 
    $s = $this->newScreen($w);

    $s->errln('error message', 'red', 'green', 'bold');
    $this->assertEquals('error message'.PHP_EOL, $w->lastErr, "Last message should have been [error message\\n]");
    $this->assertEquals(array('error message'.PHP_EOL, 'red', 'green', 'bold'), $w->lastStyle, "Last style should have matched [error message\\n, red, green, bold]");
  }

  public function testLogBasic(){
    $w = $this->newMockWriter(); 
    $s = $this->newScreen($w);

    $s->log('log message');
    $this->assertContains('log message'.PHP_EOL, $w->lastMsg, "Last message should have contained [log message\\n]");
  }

  public function testLogStyled(){
    $w = $this->newMockWriter(); 
    $s = $this->newScreen($w);

    $s->log('log message', 'red', 'green', 'bold');
    $this->assertContains('log message'.PHP_EOL, $w->lastMsg, "Last message should have contained [log message\\n]");
    $this->assertEquals(array('red', 'green', 'bold'), array_slice($w->lastStyle, 1), "Last style should have contained [red, green, bold]");
  }

  public function testPrintf(){
    $w = $this->newMockWriter(); 
    $s = $this->newScreen($w);
    
    $s->printf('hello, %s!', 'world');
    $this->assertEquals('hello, world!', $w->lastMsg, "Last message should have been [hello, world!]");
  }

  public function testVarExport(){
    $w = $this->newMockWriter(); 
    $s = $this->newScreen($w);
    
    $testVar = 'goo';
    $s->varExport($testVar);
    $this->assertContains('goo', $w->lastMsg, "Last message should have contained [goo]");

    $testVar = '5';
    $s->varExport($testVar);
    $this->assertContains('5', $w->lastMsg, "Last message should have contained [5]");

    $testVar = array(1,2,3);
    $s->varExport($testVar);
    $this->assertContains('array', $w->lastMsg, "Last message should have contained [array]");
  }

}
