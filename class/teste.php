<?php


require_once 'Cargo.php';

$a = Cargo::getNomeCargoById(1);

echo '<pre>';
var_dump($a);