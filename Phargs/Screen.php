<?php
namespace Phargs;

class Screen {
  protected $colors = [
    'black'  => 0,
    'red'    => 1,
    'green'  => 2,
    'yellow' => 3,
    'blue'   => 4,
    'purple' => 5,
    'cyan'   => 6,
    'white'  => 7,
  ];
  protected $styles = [
    'regular'   => 0,
    'bold'      => 1,
    'underline' => 4
  ];

  public function __construct(){
    
  }

  public function out($msg){
    return fputs(STDOUT, $msg);
  }

  public function colorize($string, $fg = null, $bg = null, $style = 'regular'){
    if (!isset($this->colors[$fg])){
      $fg = null;
    }
    if (!isset($this->colors[$bg])){
      $bg = null;
    }
    if (!isset($this->styles[$style])){
      $style = 'regular';
    }

    $style = $this->styles[$style];

    if (!is_null($fg)){
      $fg = $this->colors[$fg];
      $fgEscape = "\033[{$style};3{$fg}m";
    } else {
      $fgEscape = "";
    }

    if (!is_null($bg)){
      $bg = $this->colors[$bg];
      $bgEscape = "\033[4{$bg}m";
    } else {
      $bgEscape = "";
    }

    $resetEscape = "\033[0m";

    return $fgEscape.$bgEscape.$string.$resetEscape;
  }

  protected function getColorEscape($color){
    if (!isset($this->colors[$color])) return false;
    $color = $this->colors[$color];
    return "\033[0;3{$color}m";
  }

  public function err($msg){
    return fputs(STDERR, $msg);
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

  public function varExport(){
    foreach (func_get_args() as $arg){
      $this->outln(var_export($arg, true));
    }
  }

  public function log($msg){
    return $this->outln(date('c').': '.$msg);
  }
}
