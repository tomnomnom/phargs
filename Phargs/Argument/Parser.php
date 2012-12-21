<?php
namespace Phargs\Argument;

class Parser {
  protected $argv = array();

  protected $flags = array();
  protected $flagAliases = array();

  protected $params = array();
  protected $paramAliases = array();

  protected $residualArgs = array();

  public function __construct(){

  }

  public function parse($argv){
    if (is_array($argv)){
      $this->argv = $argv;
    } else {
      // Doesn't support quoted strings etc, but is mainly for testing
      $this->argv = explode(' ', $argv);
    }
    
    while ($arg = array_shift($this->argv)){
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
      // If the first candidate is a flag and not a param we can
      // assume the rest are potential flags
      $flagCandidates = str_split(subStr($arg, 1));
      $firstFlagCandidate = subStr($arg, 0, 2);
      if ($this->isFlag($firstFlagCandidate) && !$this->isParam($firstFlagCandidate)){

        foreach ($flagCandidates as $flagCandidate){
          if (!$this->isFlag("-{$flagCandidate}")) continue;
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

      // Anything still left is just a regular arg
      $this->residualArgs[] = $arg;
    }
  }

  protected function startsWithDash($candidate){
    return (subStr($candidate, 0, 1) == '-');
  }

  public function addParam($param){
    $this->params[$param] = (object) array(
      'isSet'   => false,
      'value'   => null,
    ); 
    return true;
  }

  public function addParamAlias($param, $alias){
    if (!$this->isParam($param)) return false;
    $this->paramAliases[$alias] = $param;
    return true;
  }

  protected function resolveParamAlias($alias){
    if (!isset($this->paramAliases[$alias])) return $alias;
    return $this->paramAliases[$alias];
  }

  public function isParam($param){
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

  public function addFlag($flag){
    $this->flags[$flag] = (object) array(
      'isSet'   => false,
    );
    return true;
  }

  public function addFlagAlias($flag, $alias){
    if (!$this->isFlag($flag)) return false;
    $this->flagAliases[$alias] = $flag; 
    return true;
  }

  protected function resolveFlagAlias($alias){
    if (!isset($this->flagAliases[$alias])){
      // Not an alias; so just return the original flag
      return $alias;
    }
    return $this->flagAliases[$alias];
  }

  public function isFlag($flag){
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

  public function getResidualArgs($offset = 0, $count = null){
    if ($offset == 0 && $count == null){
      // Shortcut to avoid slicing
      return $this->residualArgs;
    }
    return array_slice($this->residualArgs, $offset, $count);
  }

  public function getResidualArg($index){
    if (!isset($this->residualArgs[$index])) return false;
    return $this->residualArgs[$index];
  }
}
