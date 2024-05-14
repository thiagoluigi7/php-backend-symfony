<?php

namespace App\Tests\Repository;

use App\Entity\Person;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PersonRepositoryTest extends KernelTestCase
{
    private ?EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testSearchByNis(): void
    {
        $person = $this->getTestPerson();

        $foundPerson = $this->getRepository()->findOneByNis($person->getNis());

        $this->assertSame($person->getId(), $foundPerson->getId());
    }

    public function testNisGeneration(): void
    {
        $testPerson = $this->getTestPerson();

        $personToCreate = new Person();
        $personToCreate->setName('Teste2');
        $personToCreate->setNis($testPerson->getNis());

        $newPerson = $this->getRepository()->create($personToCreate);

        $this->assertNotSame($testPerson->getNis(), $newPerson->getNis());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }

    private function getRepository()
    {
        return $this->entityManager->getRepository(Person::class);
    }

    private function getTestPerson(): Person
    {
        $person = $this->getRepository()->findAll()[0] ?? null;

        if (!$person) {
            $personToCreate = new Person();
            $personToCreate->setName('Teste');
            $createdPerson = $this->getRepository()->create($personToCreate);
            return $createdPerson;
        }

        return $person;
    }
}
