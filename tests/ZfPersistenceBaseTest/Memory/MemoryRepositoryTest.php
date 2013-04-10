<?php
namespace ZfPersistenceBaseTest\Memory;

use ZfPersistenceBase\Entity;
use ZfPersistenceBase\Memory\MemoryRepository;

class MemoryRepositoryTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        $this->repository = new MemoryRepository();
        $this->_populate();
    }

    /** @test */
    public function canAdd()
    {
        $this->repository->add(new User());
        
        $this->assertEquals(4, $this->repository->size());
    }

    /** @test */
    public function canGetById()
    {
        $storedEntity = $this->repository->getById(1);
        
        $this->assertInstanceOf('ZfPersistenceBaseTest\Memory\User', $storedEntity);
        $this->assertEquals('John', $storedEntity->getName());
    }

    /** @test */
    public function canGetAll()
    {
        $entities = $this->repository->getAll();
        
        $this->assertInternalType('array', $entities);
        $this->assertEquals(3, count($entities));
    }

    /** @test */
    public function canGetSize()
    {
        $this->assertEquals(3, $this->repository->size());
    }

    /** @test */
    public function canRemove()
    {
        $entity = $this->repository->getById(1);
        
        $this->repository->remove($entity);
        
        $this->assertEquals(2, $this->repository->size());
        $this->assertNull($this->repository->getById(1));
    }

    private function _populate()
    {
        $this->addUser('John');
        $this->addUser('Jane');
        $this->addUser('Mike');
    }

    private function addUser($name)
    {
        $user = new User();
        $user->setName($name);
        $this->repository->add($user);
        return $user;
    }
}

class User implements Entity
{
    private $id;
    private $name;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}