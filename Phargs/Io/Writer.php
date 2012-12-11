<?php
namespace Phargs\Io;

abstract class Writer {
  abstract public function write($msg);

  public function err($msg){
    return $this->write($msg);
  }

  public function stylize($msg, $fgColor = null, $bgColor = null, $style = null){
    return $msg;
  }
}
