<?php
namespace Phargs\Argument;

class Orchestrator {
  protected $parsed = false;
  protected $parser;
  protected $rawArgv = array();
  protected $argv = array();
  protected $params = array();
  protected $flags = array();
  
  public function __construct(Parser $parser, Array $argv){
    $this->parser  = $parser; 
    $this->argv    = $argv;
    $this->rawArgv = $argv;
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

  public function expectFlag($flag, $description = '', $required = false){
    $this->flags[$flag] = (object) array(
      'description' => $description,
      'required'    => (bool) $required,
      'aliases'     => array()
    );
    $this->parser->addFlag($flag);
    return true;
  }

  public function addFlagAlias($flag, $alias){
    if ($this->parser->addFlagAlias($flag, $alias)){
      $this->flags[$flag]->aliases[] = $alias;
      return true;
    }
    return false;
  }

  public function flagIsSet($flag){
    $this->ensureParsed();
    return $this->parser->flagIsSet($flag);    
  }

  public function expectParam($param, $description = '', $required = false){
    $this->params[$param] = (object) array(
      'description' => $description,
      'required'    => (bool) $required,
      'aliases'     => array()
    );
    $this->parser->addParam($param);
    return true;
  }

  public function addParamAlias($param, $alias){
    if ($this->parser->addParamAlias($param, $alias)){
      $this->params[$param]->aliases[] = $alias;
      return true;
    }
    return false;
  }

  public function paramIsSet($param){
    $this->ensureParsed();
    return $this->parser->paramIsSet($param);
  }

  public function getParamValue($param){
    $this->ensureParsed();
    return $this->parser->getParamValue($param);
  }

  public function requirementsAreMet(){
    foreach ($this->flags as $flag => $props){
      if (!$props->required) continue;
      if (!$this->parser->flagIsSet($flag)){
        return false;
      }
    }

    foreach ($this->params as $param => $props){
      if (!$props->required) continue;
      if (!$this->parser->paramIsSet($param)){
        return false;
      }
    }
    return true;
  }

  public function getRawArgv(){
    return $this->rawArgv;
  }

  public function getExpectedFlags(){
    return $this->flags;
  }

  public function getExpectedParams(){
    return $this->params;
  }

}
