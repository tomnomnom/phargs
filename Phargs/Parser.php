<?php
namespace Phargs;

class Parser {
  protected $rawArgv = [];
  protected $argv = [];
  protected $shortFlags = [];
  protected $longFlags = [];

  public function __construct(){
  }

  public function parse($argv){
    if (is_array($argv)){
      $this->argv = $argv;
    } else {
      $this->argv = explode(' ', $argv);
    }
    $this->rawArgv = $this->argv;
    
    while ($arg = array_shift($this->argv)){

      if ($this->isShortFlag($arg)) {
        $this->setShortFlag($arg);
      }

      if ($this->isCompoundShortFlags($arg)){
        $this->setCompoundShortFlags($arg); 
      }

      if ($this->isLongFlag($arg)){
        $this->setLongFlag($arg);
      }

    }
  }

  public function flagIsSet($flag){
    return ($this->shortFlagIsSet($flag) || $this->longFlagIsSet($flag));
  }
  protected function setLongFlag($flag){
    if (substr($flag, 0, 2) == '--'){
      $flag = substr($flag, 2);
    }
    $this->longFlags[$flag] = true;
  }

  protected function isLongFlag($candidate){
    if (strlen($candidate) < 4) return false;
    if ($candidate[0] != '-') return false;
    if ($candidate[1] != '-') return false;
    if (strpos($candidate, '=') !== false) return false;
    return true;
  }

  public function longFlagIsSet($flag){
    return isset($this->longFlags[$flag]); 
  }

  protected function setCompoundShortFlags($flags){
    $flags = str_split($flags); 
    if ($flags[0] == '-') array_shift($flags);
    foreach ($flags as $flag){
      $this->setShortFlag($flag);
    }
  }

  protected function isCompoundShortFlags($candidate){
    if (strlen($candidate) <= 2) return false;
    if ($candidate[0] != '-') return false;
    if ($candidate[1] == '-') return false;
    return true;
  }

  protected function setShortFlag($flag){
    if (strlen($flag) == 2){
      $flag = $flag[1];
    }
    $this->shortFlags[$flag] = true;
    return true;
  }

  protected function isShortFlag($candidate){
    if (strlen($candidate) != 2) return false;
    if ($candidate[0] != '-') return false;
    if ($candidate[1] == '-') return false;
    return true;
  }

  public function getRawArgv(){
    return $this->rawArgv;
  }

  public function shortFlagIsSet($flag){
    return isset($this->shortFlags[$flag]);
  }
}
