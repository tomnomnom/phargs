<?php
namespace Phargs;

abstract class Output {
  public function __construct(){
    
  }

  abstract public function out($msg);

  public function err($msg){
    return $this->out($msg); 
  }

  public function errln($msg){
    return $this->err($msg.PHP_EOL);
  }

  public function outln($msg){
    return $this->out($msg.PHP_EOL);
  }
  
  public function printf(){
    return $this->out(
      call_user_func_array('sprintf', func_get_args)
    );
  }

  public function debug(){
    foreach (func_get_args() as $arg){
      $this->outln(var_export($arg, true));
    }
  }

  public function log($msg){
    return $this->outln(date('c').': '.$msg);
  }
}
