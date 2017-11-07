<?php

namespace App\Services\File;

use ArrayAccess;
use Countable;
use Iterator;

/**
 * Interface FileFinder
 * @package App\Services\File
 */
interface FileFinder extends Iterator, ArrayAccess, Countable
{
    
}