<?php


require "vendor/autoload.php";

$database = new Database;

$repository = new Repository($database);

$data = $repository->getAll();

var_dump($data);