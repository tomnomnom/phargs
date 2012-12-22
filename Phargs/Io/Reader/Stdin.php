<?php
namespace Phargs\Io\Reader;

class Stdin extends \Phargs\Io\Reader {
  public function read($length = null){
    // docs aren't clear about the default value for length :/
    if (is_null($length)){
      return fgets(STDIN);
    }
    return fgets(STDIN, $length);
  }

  public function readAll(){
    return file_get_contents('php://input');
  }
}
