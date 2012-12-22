<?php
namespace Phargs\Io;

abstract class Reader {
  abstract public function read($length = null);
  abstract public function readAll();
}
