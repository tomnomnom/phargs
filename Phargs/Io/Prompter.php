<?php
namespace Phargs\Io;

class Prompter {
  protected $reader;
  protected $writer;

  public function __construct(Reader $reader, Writer $writer){
    $this->reader = $reader;
    $this->writer = $writer;
  }

  public function prompt($msg){
    $this->writer->write($msg);
    $entered = $this->reader->read();

    return rtrim($entered, PHP_EOL);
  } 
}
