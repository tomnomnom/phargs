<?php
namespace Phargs;

spl_autoload_register(function($class){
  $class = ltrim($class, '\\');
  $class = str_replace('\\', '/', $class);
  require __DIR__."/../{$class}.php";
});

set_exception_handler(function($e){
  $type = get_class($e);
  echo "Uncaught {$type} [{$e->getCode()}]: {$e->getMessage()}\n";
  echo $e->getTraceAsString();
  exit(1);
});
