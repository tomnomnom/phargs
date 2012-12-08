<?php
namespace Phargs;

class Factory {
  public function __construct(){
  
  }

  public function screen(){
    return new \Phargs\Screen();
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
