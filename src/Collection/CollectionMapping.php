<?php

namespace Src\Collection;

use Xenus\Collection;

class CollectionMapping extends Collection
{
    //protected $name = 'accounts';

    public function __construct($connection, $name)
    {
    	$this->name = $name;
    	parent::__construct($connection);
    }
}
