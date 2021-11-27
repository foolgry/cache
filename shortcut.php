<?php

use foolgry\gcache;

function gcache(): gcache
{
    return gcache::instance();
}