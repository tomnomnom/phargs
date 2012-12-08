<?php
include __DIR__.'/Phargs/Init.php';

$f = new \Phargs\Factory();
$s = $f->screen();


$s->out('Hello,', 'green', 'purple');
$s->out(' World!', 'purple', 'green');
