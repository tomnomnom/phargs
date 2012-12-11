<?php
namespace Test\Mock\Phargs\Io;

class Writer extends \Phargs\Io\Writer {
  public $lastMsg = '';
  public $allMsgs = '';
  public $lastErr = '';
  public $allErrs = '';
  public $lastStyle = array();

  public function write($msg){
    $this->lastMsg = $msg;
    $this->allMsgs .= $msg;
  }

  public function err($msg){
    $this->lastErr = $msg;
    $this->allErrs .= $msg;
  }

  public function stylize($msg, $fgColor = null, $bgColor = null, $style = null){
    $this->lastStyle = array($msg, $fgColor, $bgColor, $style);
    return $msg;
  }
}
