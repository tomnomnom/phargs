<?php
namespace Phargs\Io;

class Screen {
  protected $writer = null;

  public function __construct(\Phargs\Io\Writer $writer){
    $this->writer = $writer;  
  }

  public function out($msg, $fg = null, $bg = null, $style = null){
    if ($fg || $bg){
      $msg = $this->writer->stylize($msg, $fg, $bg, $style);
    }
    $this->writer->write($msg);
  }

  public function outln($msg, $fg = null, $bg = null, $style = null){
    return $this->out($msg.PHP_EOL, $fg, $bg, $style);
  }

  public function err($msg, $fg = null, $bg = null, $style = null){
    if ($fg || $bg){
      $msg = $this->writer->stylize($msg, $fg, $bg, $style);
    }
    return $this->writer->err($msg);
  }

  public function errln($msg, $fg = null, $bg = null, $style = null){
    return $this->err($msg.PHP_EOL, $fg, $bg, $style);
  }

  public function printf(){
    return $this->out(
      call_user_func_array('sprintf', func_get_args())
    );
  }

  public function varExport($var){
    return $this->outln(var_export($var, true));
  }

  public function log($msg, $fg = null, $bg = null, $style = null){
    return $this->outln(date('c').': '.$msg, $fg, $bg, $style);
  }
}
