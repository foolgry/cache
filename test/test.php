<?php

require dirname(__DIR__) .'/vendor/autoload.php';

//$a = [];
//var_dump(array_pop($a));
$println = function ($o) {
    print_r($o);
    echo PHP_EOL;
};

gcache()->aa = 1;
$println(gcache()->aa);//1

gcache()->set('a','2');
gcache()->incr('a');

$println(gcache()->a);//3

$cache = gcache();
$cache->incr('a');

$println($cache->get('a'));//4

