<?php
namespace Phargs;

class Parser {
  protected $rawArgv = [];
  protected $argv = [];
  protected $shortFlags = [];
  protected $longFlags = [];
  protected $longValues = [];

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

      if ($this->isLongValue($arg)){
        $this->setLongValue($arg); 
        continue;
      }

      if ($this->isShortFlag($arg)) {
        $this->setShortFlag($arg);
        continue;
      }

      if ($this->isCompoundShortFlags($arg)){
        $this->setCompoundShortFlags($arg); 
        continue;
      }

      if ($this->isLongFlag($arg)){
        $this->setLongFlag($arg);
        continue;
      }

    }
  }

  public function longValueIsSet($value){
    return isset($this->longValues[$value]); 
  }

  public function getLongValue($value){
    if (!$this->longValueIsSet($value)) return null;
    return $this->longValues[$value];
  }

  protected function setLongValue($value){
    if (substr($value, 0, 2) == '--'){
      $value = substr($value, 2);
    }
    if (strpos($value, '=') !== false){
      list($key, $value) = explode('=', $value, 2);
      $this->longValues[$key] = $value;
      return true;
    }
    $this->longValues[$value] = array_shift($this->argv);
    return true;
  }

  protected function isLongValue($candidate){
    if (strlen($candidate) < 4) return false;
    if ($candidate[0] != '-') return false;
    if ($candidate[1] != '-') return false;

    if (strpos($candidate, '=') !== false) return true;
    if ($this->nextArgIsValue()) return true;

    return false;
  }

  protected function nextArgIsValue(){
    if (!isset($this->argv[0])) return false;
    if ($this->isFlag($this->argv[0])) return false;
    return true;
  }

  protected function isFlag($candidate){
    return ($this->isShortFlag($candidate) || $this->isLongFlag($candidate));
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
