<?php
namespace Phargs\Argument;

class Parser {
  protected $rawArgv = [];
  protected $argv = [];

  protected $flags = [];
  protected $flagAliases = [];

  protected $params = [];
  protected $paramAliases = [];

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
      // Don't even bother checking stuff if it doesn't start with a dash
      if (!$this->startsWithDash($arg)){
        continue; 
      }

      // Flags in 2 forms:
      //   -h
      //   --help
      if ($this->isFlag($arg)){
        $this->setFlag($arg);
        continue;
      }

      // Params can be in 4 forms:
      //   --long-param=val
      //   --long-param val
      //   -p val
      //   -pval (handled later)
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

      // At this stage it could be compound flags
      //   e.g. -Hnri
      // We should only assume this if all chars are valid flags
      $flagCandidates = str_split(subStr($arg, 1));
      $potentialCandidates = sizeOf($flagCandidates);
      $validCandidates = 0;
      foreach ($flagCandidates as $flagCandidate){
        if ($this->isFlag("-{$flagCandidate}")){
          $validCandidates++;
        }
      }
      if ($validCandidates == $potentialCandidates){
        foreach ($flagCandidates as $flagCandidate){
          $this->setFlag("-{$flagCandidate}"); 
        }
        continue;
      }

      // If it wasn't compound flags it may be the 
      // remaining type of param:
      //   e.g. -pval
      $paramCandidate = subStr($arg, 0, 2);
      if ($this->isParam($paramCandidate)){
        $value = subStr($arg, 2);
        $this->setParam($paramCandidate, $value);
        continue;
      }
    }
  }

  protected function startsWithDash($candidate){
    return (subStr($candidate, 0, 1) == '-');
  }

  public function addParam($param, $description = '', $required = false){
    $this->params[$param] = (object) [
      'description' => $description,
      'required'    => (bool) $required,
      'isSet'       => false,
      'value'       => null,
      'aliases'     => []
    ]; 
    return true;
  }

  public function addParamAlias($param, $alias){
    if (!$this->isParam($param)) return false;
    $this->paramAliases[$alias] = $param;
    $this->params[$param]->aliases[] = $alias;
    return true;
  }

  protected function resolveParamAlias($alias){
    if (!isset($this->paramAliases[$alias])) return $alias;
    return $this->paramAliases[$alias];
  }

  protected function isParam($param){
    $param = $this->resolveParamAlias($param);
    return isSet($this->params[$param]);
  }

  protected function setParam($param, $value){
    $param = $this->resolveParamAlias($param);
    $this->params[$param]->isSet = true;
    $this->params[$param]->value = $value;
    return true;
  }

  public function paramIsSet($param){
    $param = $this->resolveParamAlias($param);
    return (bool) $this->params[$param]->isSet;
  }

  public function getParamValue($param){
    $param = $this->resolveParamAlias($param);
    return $this->params[$param]->value;
  }

  public function addFlag($flag, $description = '', $required = false){
    $this->flags[$flag] = (object) [
      'description' => $description,
      'required'    => (bool) $required,
      'isSet'       => false,
      'aliases'     => []
    ];
    return true;
  }

  public function addFlagAlias($flag, $alias){
    if (!$this->isFlag($flag)) return false;
    $this->flagAliases[$alias] = $flag; 
    $this->flags[$flag]->aliases[] = $alias;
    return true;
  }

  public function resolveFlagAlias($alias){
    if (!isset($this->flagAliases[$alias])){
      // Not an alias; so just return the original flag
      return $alias;
    }
    return $this->flagAliases[$alias];
  }

  protected function isFlag($flag){
    $flag = $this->resolveFlagAlias($flag);
    return isSet($this->flags[$flag]);
  }

  protected function setFlag($flag){
    $flag = $this->resolveFlagAlias($flag);
    $this->flags[$flag]->isSet = true; 
    return true;
  }

  public function flagIsSet($flag){
    $flag = $this->resolveFlagAlias($flag);
    return (bool) $this->flags[$flag]->isSet; 
  }

  public function getRawArgv(){
    return $this->rawArgv;
  }
}
