<?php
namespace Test\Unit\Phargs\Io;

class PrompterTest extends \PHPUnit_Framework_TestCase {
  protected function newReaderMock(){
    return new \Test\Mock\Phargs\Io\Reader();
  } 

  protected function newWriterMock(){
    return new \Test\Mock\Phargs\Io\Writer();
  }
  
  protected function newPrompter($reader, $writer){
    return new \Phargs\Io\Prompter($reader, $writer);
  }

  protected function newTestObjs(){
    $r = $this->newReaderMock();
    $w = $this->newWriterMock();
    $p = $this->newPrompter($r, $w);
    
    return array($p, $r, $w);
  }

  public function testConstruct(){
    list($p, $r, $w) = $this->newTestObjs();

    $this->assertInstanceOf('\\Phargs\\Io\\Prompter', $p);
    $this->assertInstanceOf('\\Phargs\\Io\\Reader', $r);
    $this->assertInstanceOf('\\Phargs\\Io\\Writer', $w);
  }

  public function testPromptBasic(){
    list($p, $r, $w) = $this->newTestObjs();
    
    $r->setBuffer('Tom');
    $name = $p->prompt('Name: ');

    $this->assertEquals('Tom', $name, "Value should have matched [Tom]");
    $this->assertEquals('Name: ', $w->lastMsg, "Last written message should have matched [Name: ]");
  }

  public function testPromptStripNewline(){
    list($p, $r, $w) = $this->newTestObjs();
    
    $r->setBuffer('Tom '.PHP_EOL);
    $name = $p->prompt('Name: ');

    $this->assertEquals('Tom ', $name, "Value should have matched [Tom]");
    $this->assertEquals('Name: ', $w->lastMsg, "Last written message should have matched [Name: ]");
  }
}
