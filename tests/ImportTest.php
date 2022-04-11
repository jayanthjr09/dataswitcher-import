<?php
use PHPUnit\Framework\TestCase;
use Src\Import;
use Xenus\Connection;

class ImportTest extends TestCase
{
    public function testimport()
    {

    	$connection = new Connection('mongodb://dsw_challenge_mongodb:27017', 'dataswitcher');
		$import = new Import($connection);

        $this->assertTrue($import->run());
    }

}
