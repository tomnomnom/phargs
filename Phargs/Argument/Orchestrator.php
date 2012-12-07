<?php
namespace Phargs\Argument;

class Orchestrator {
  protected $parsed = false;
  protected $parser;
  protected $argv = [];
  protected $params = [];
  protected $flags  = [];
  
  public function __construct(Parser $parser, Array $argv){
    $this->parser = $parser; 
    $this->argv   = $argv;
  }

  protected function ensureParsed(){
    if (!$this->parsed){
      $this->commandName = array_shift($this->argv);
      $this->parser->parse($this->argv);
      $this->parsed = true;
    }
    return true;
  }

  public function getCommandName(){
    $this->ensureParsed();
    return $this->commandName;
  }

  public function getArgCount(){
    $this->ensureParsed();
    return sizeOf($this->argv);
  }
}
