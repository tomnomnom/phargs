<?php
namespace Phargs\Io\Writer;

class Stdout extends \Phargs\Io\Writer {
  protected $colors = array(
    'black'  => 0,
    'red'    => 1,
    'green'  => 2,
    'yellow' => 3,
    'blue'   => 4,
    'purple' => 5,
    'cyan'   => 6,
    'white'  => 7,
  );
  protected $styles = array(
    'regular'   => 0,
    'bold'      => 1,
    'underline' => 4
  );

  public function write($msg){
    return fputs(STDOUT, $msg);
  }

  public function error($msg){
    return fputs(STDERR, $msg);
  }

  public function stylize($string, $fg = null, $bg = null, $style = null){
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
}
