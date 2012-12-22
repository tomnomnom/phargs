<?php
namespace Test\Mock\Phargs\Io;

class Reader extends \Phargs\Io\Reader {
  public $buffer = '';
  protected $pointer = 0;

  public function setBuffer($buffer){
    $this->buffer = (string) $buffer;
  }

  public function read($length = null){
    $chars = str_split($this->buffer);
    $output = '';

    if (is_null($length)){
      // Read until EOL or EOF
      $start = $this->pointer;
      $stop = strlen($this->buffer);
      for ($i = $start; $i < $stop; $i++){
        $this->pointer++;
        $output .= $chars[$i];
        if ($chars[$i] == PHP_EOL) break;
      }
    } else {
      // Read up to $length
      $start = $this->pointer;
      $stop  = $this->pointer + $length;
      for ($i = $start; $i < $stop; $i++){
        $this->pointer++;
        $output .= $chars[$i];
      }
    }

    return $output;
  }

  public function readAll(){
    return $this->buffer;
  }
}
