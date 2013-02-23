<?php
namespace Test\FullStack\Phargs;

class ExamplesTest extends \PHPUnit_Framework_TestCase {
  
  protected function execExample($example, $argString = ''){
    exec("php ".__DIR__.'/../../../Examples/'.$example.'.php '.$argString, $output, $exitCode);
    return array($output, $exitCode);
  }

  protected function execExampleStdin($example, $stdin = '', $argString = ''){
    $stdin = escapeshellarg($stdin);
    exec("echo {$stdin} | php ".__DIR__.'/../../../Examples/'.$example.'.php '.$argString, $output, $exitCode);
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
    $this->assertEquals(
      array('-H flag is set', '-n flag is set'), 
      $output, "Output should have matched expected"
    );
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");
  }

  public function testParams(){
    list($output, $exitCode) = $this->execExample('Params', '--count 5');
    $this->assertEquals(
      array('--count param is set', '--count value is: 5'), 
      $output, "Output should have matched expected"
    );
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");

    list($output, $exitCode) = $this->execExample('Params', '--count=6');
    $this->assertEquals(
      array('--count param is set', '--count value is: 6'), 
      $output, "Output should have matched expected"
    );
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");

    list($output, $exitCode) = $this->execExample('Params', '--help');
    $this->assertEquals(
      array('--count param is not set'), 
      $output, "Output should have matched expected"
    );
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");
  }

  public function testRequiredParams(){
    list($output, $exitCode) = $this->execExample('RequiredParams', '--count=4 --number=5');
    $this->assertEquals(
      array('All arg requirements are met'), 
      $output, "Output should have matched expected"
    );
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");

    list($output, $exitCode) = $this->execExample('RequiredParams', '--count=4');
    $this->assertEquals(
      array('Not all arg requirements are met'), 
      $output, "Output should have matched expected"
    );
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");
  }

  public function testParamAliases(){
    list($output, $exitCode) = $this->execExample('ParamAliases', '--count 5');
    $this->assertEquals(
      array('--count param is set', '--count value is: 5'), 
      $output, "Output should have matched expected"
    );
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");

    list($output, $exitCode) = $this->execExample('ParamAliases', '-c 6');
    $this->assertEquals(
      array('--count param is set', '--count value is: 6'), 
      $output, "Output should have matched expected"
    );
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");

    list($output, $exitCode) = $this->execExample('ParamAliases', '-c7');
    $this->assertEquals(
      array('--count param is set', '--count value is: 7'), 
      $output, "Output should have matched expected"
    );
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");

    list($output, $exitCode) = $this->execExample('ParamAliases', '--help');
    $this->assertEquals(
      array('--count param is not set'), 
      $output, "Output should have matched expected"
    );
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");
  }

  public function testResidualArgs(){
    list($output, $exitCode) = $this->execExample('ResidualArgs', 'help merge');
    $this->assertEquals(
      array(
        'Residual arg #0: help',
        'All residual args: help, merge',
        'First two residual args: help, merge'
      ),
      $output, "Output should have matched expected"
    );
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");

    list($output, $exitCode) = $this->execExample('ResidualArgs', '-h help --count=5 merge');
    $this->assertEquals(
      array(
        'Residual arg #0: help',
        'All residual args: help, merge',
        'First two residual args: help, merge'
      ),
      $output, "Output should have matched expected"
    );
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");

    list($output, $exitCode) = $this->execExample('ResidualArgs', 'help merge this thing');
    $this->assertEquals(
      array(
        'Residual arg #0: help',
        'All residual args: help, merge, this, thing',
        'First two residual args: help, merge'
      ),
      $output, "Output should have matched expected"
    );
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");
  }

  public function testScreenBasic(){
    list($output, $exitCode) = $this->execExample('ScreenBasic');
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");

    $this->assertContains('Hello, World!', $output, "Output should have contained [Hello, World!]");
    $this->assertContains('Hello, World!', $output, "Output should have contained [Error message]");
    $this->assertContains('When in Rome', $output, "Output should have contained [When in rome]");
    $this->assertContains('array (', $output, "Output should have contained [array (]");
  }

  public function testPrompterBasic(){
    list($output, $exitCode) = $this->execExampleStdin('PrompterBasic', 'Tom');
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");

    $this->assertContains("What is your name? Hello, Tom!", $output, "Output should have matched expected");
  }

  public function testPrompterRequired(){
    list($output, $exitCode) = $this->execExampleStdin('PrompterRequired', PHP_EOL.PHP_EOL.'Tom');
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");

    $this->assertContains("What is your name? No name entered!", $output, "Output should have matched expected");
    $this->assertContains("What is your name? Hello, Tom!", $output, "Output should have matched expected");
  }

  public function testTable(){
    list($output, $exitCode) = $this->execExample('Table');
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");

    $this->assertContains('| id | name  |', $output, "Output should have contained [| id | name  |]");
    $this->assertContains('| 1  | Tom   |', $output, "Output should have contained [| 1  | Tom   |]");
    $this->assertContains('| 2  | Dick  |', $output, "Output should have contained [| 2  | Dick  |]");
    $this->assertContains('| 3  | Harry |', $output, "Output should have contained [| 3  | Harry |]");
  }

  public function testTsv(){
    list($output, $exitCode) = $this->execExample('Tsv');
    $this->assertEquals(0, $exitCode, "Exit code should have been [0]");

    $this->assertContains("id\tname", $output, "Output should have contained [id\tname]");
    $this->assertContains("1\tTom", $output, "Output should have contained [1\tTom]");
    $this->assertContains("2\tDick", $output, "Output should have contained [2\tDick]");
    $this->assertContains("3\tHarry", $output, "Output should have contained [3\tHarry]");
  }
}
