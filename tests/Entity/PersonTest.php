<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Person;

class PersonTest extends TestCase
{
    public function testNisGeneration(): void
    {
        $person = new Person();

        $nis = (int)$person->generateNis();

        $this->assertTrue($nis > 10000000000 && $nis < 99999999999);
    }
}
