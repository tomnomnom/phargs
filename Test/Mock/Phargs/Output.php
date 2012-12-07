<?php
namespace Test\Mock\Phargs;

class Output extends \Phargs\Output {
  public $last = '';
  public $all  = '';

  public function out($msg){
    $this->last = $msg;
    $this->all .= $msg;
    return true;
  }
}
