<?php
namespace Phargs;

class Parser {
  protected $rawArgv = [];
  protected $argv = [];
  protected $flags = [];
  protected $params = [];


  protected $shortFlags = [];
  protected $longFlags = [];
  protected $longValues = [];
  protected $shortValues = [];

  public function __construct(){
  }

  public function parse($argv){
    if (is_array($argv)){
      $this->argv = $argv;
    } else {
      // Doesn't support quoted strings etc, but is mainly for testing
      $this->argv = explode(' ', $argv);
    }
    $this->rawArgv = $this->argv;
    
    while ($arg = array_shift($this->argv)){
      // Flags in 2 forms:
      //   -h
      //   --help
      if ($this->isFlag($arg)){
        $this->setFlag($arg);
        continue;
      }

      // Long params can either be in 2 forms:
      //   --long-param val
      //   --long-param=val
      $paramCandidate = explode('=', $arg, 2);
      if (sizeOf($paramCandidate) == 2){
        // It might be an 'equals style' param
        if ($this->isParam($paramCandidate[0])){
          $this->setParam($paramCandidate[0], $paramCandidate[1]);
          continue;
        }
      } else {
        // It might be a 'space style' param
        if ($this->isParam($arg)){
          $this->setParam($arg, array_shift($this->argv));
          continue;
        }
      }
    }
  }

  public function addParam($param, $description = '', $required = false){
    $this->params[$param] = (object) [
      'description' => $description,
      'required'    => (bool) $required,
      'isSet'       => false,
      'value'       => null
    ]; 
    return true;
  }

  protected function isParam($param){
    return isSet($this->params[$param]);
  }

  protected function setParam($param, $value){
    $this->params[$param]->isSet = true;
    $this->params[$param]->value = $value;
    return true;
  }

  public function paramIsSet($param){
    return (bool) $this->params[$param]->isSet;
  }

  public function getParamValue($param){
    return $this->params[$param]->value;
  }

  public function addFlag($flag, $description = '', $required = false){
    $this->flags[$flag] = (object) [
      'description' => $description,
      'required'    => (bool) $required,
      'isSet'       => false
    ];
    return true;
  }

  protected function isFlag($flag){
    return isSet($this->flags[$flag]);
  }

  protected function setFlag($flag){
    $this->flags[$flag]->isSet = true; 
    return true;
  }

  public function flagIsSet($flag){
    return (bool) $this->flags[$flag]->isSet; 
  }

  public function getRawArgv(){
    return $this->rawArgv;
  }
}
