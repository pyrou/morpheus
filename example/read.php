<?php

require 'vendor/autoload.php';

use Morpheus;

$im = imagecreatefrompng("output.png");

echo base64_decode(Morpheus\Data::read($im));
