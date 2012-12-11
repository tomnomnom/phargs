<?php
namespace Phargs;

class Factory {
  public function __construct(){
  
  }

  public function screen(){
    return new \Phargs\Io\Screen(
      new \Phargs\Io\Writer\Stdout()
    );
  }

  public function args($argv = null){
    if (is_null($argv)){
      $argv = $GLOBALS['argv'];
    }
    return new \Phargs\Argument\Orchestrator(
      new \Phargs\Argument\Parser(), $argv
    );
  }
}
