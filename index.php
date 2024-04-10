<?php


require "vendor/autoload.php";

$container = new Container;

$repository = $container->get(Repository::class);

$data = $repository->getAll();

var_dump($data);