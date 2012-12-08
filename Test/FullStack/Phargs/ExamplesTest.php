<?php
namespace Test\FullStack\Phargs;

class ExamplesTest extends \PHPUnit_Framework_TestCase {
  
  protected function execExample($example, $argString){
    exec("php ".__DIR__.'/../../../Examples/'.$example.'.php '.$argString, $output, $exitCode);
    return array($output, $exitCode);
  }

  public function testFlags(){
    list($output, $exitCode) = $this->execExample('Flags', '-h');
    $this->assertEquals(array('Help flag is set'), $output, "Output should have matched expected");
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");

    list($output, $exitCode) = $this->execExample('Flags', '-p');
    $this->assertEquals(array('Help flag is not set'), $output, "Output should have matched expected");
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");
     
    list($output, $exitCode) = $this->execExample('Flags', '');
    $this->assertEquals(array('Help flag is not set'), $output, "Output should have matched expected");
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");
  }

  public function testFlagAliases(){
    list($output, $exitCode) = $this->execExample('FlagAliases', '-h');
    $this->assertEquals(array('Help flag is set'), $output, "Output should have matched expected");
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");

    list($output, $exitCode) = $this->execExample('FlagAliases', '--help');
    $this->assertEquals(array('Help flag is set'), $output, "Output should have matched expected");
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");

    list($output, $exitCode) = $this->execExample('FlagAliases', '-p');
    $this->assertEquals(array('Help flag is not set'), $output, "Output should have matched expected");
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");
  }

  public function testCompoundFlags(){
    list($output, $exitCode) = $this->execExample('CompoundFlags', '-Hnr');
    $this->assertEquals(
      array('-H flag is set', '-n flag is set', '-r flag is set'), 
      $output, "Output should have matched expected"
    );
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");

    list($output, $exitCode) = $this->execExample('CompoundFlags', '-Hr -n');
    $this->assertEquals(
      array('-H flag is set', '-n flag is set', '-r flag is set'), 
      $output, "Output should have matched expected"
    );
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");

    list($output, $exitCode) = $this->execExample('CompoundFlags', '-Hn');
    $this->assertEquals(
      array('-H flag is set', '-n flag is set'), 
      $output, "Output should have matched expected"
    );
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");

    list($output, $exitCode) = $this->execExample('CompoundFlags', '-Hni');
    $this->assertEquals(array(), $output, "Output should have matched expected");
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");
  }

}
