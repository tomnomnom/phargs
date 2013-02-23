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

  public function testArgumentPrompter(){
    $f = $this->newFactory();
    $p = $f->prompter();
    $this->assertInstanceOf('\\Phargs\\Io\\Prompter', $p, "Returned object should be instance of [\\Phargs\\Io\\Prompter]");
  }

  public function testTableFormatter(){
    $f = $this->newFactory();

    $t = $f->table();
    $this->assertInstanceOf('\\Phargs\\Formatter\\Table', $t, "Returned object should be instance of [\\Phargs\\Formatter\\Table]");
  }

  public function testTsvFormatter(){
    $f = $this->newFactory();

    $t = $f->tsv();
    $this->assertInstanceOf('\\Phargs\\Formatter\\Tsv', $t, "Returned object should be instance of [\\Phargs\\Formatter\\Tsv]");
  }
}
