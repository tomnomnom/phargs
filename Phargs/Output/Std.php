<?php
namespace Phargs\Output;

class Std extends \Phargs\Output {
  public function out($msg){
    return fputs(STDOUT, $msg);
  }

  public function err($msg){
    return fputs(STDERR, $msg);
  }
}
