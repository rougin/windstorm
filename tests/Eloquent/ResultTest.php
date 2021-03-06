<?php

namespace Rougin\Windstorm\Eloquent;

use Rougin\Windstorm\Fixture\Mutators\CreateUser;
use Rougin\Windstorm\Fixture\Mutators\DeleteUser;
use Rougin\Windstorm\Fixture\Mutators\ReturnUsers;
use Rougin\Windstorm\Fixture\Mutators\UpdateUser;
use Rougin\Windstorm\Fixture\UserModel;
use Rougin\Windstorm\QueryRepository;

/**
 * Result Test
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ResultTest extends TestCase
{
    /**
     * @var \Rougin\Windstorm\ResultInterface
     */
    protected $result;

    /**
     * @var \Rougin\Windstorm\QueryRepository
     */
    protected $repository;

    /**
     * Sets up the query builder instance.
     *
     * @return void
     */
    public function setUp()
    {
        $result = new Result;

        parent::setUp();

        $query = $this->query;

        $this->repository = new QueryRepository($query, $result);
    }

    public function testExecuteMethod()
    {
        $expected = 'Windstorm';

        $result = new Result;

        $query = $this->query->select(array('*'));

        $response = $result->execute($query->from('users'));

        $result = $response->first()->toArray();

        $this->assertSame($expected, $result['name']);
    }

    /**
     * Tests ResultInterface::result with create.
     *
     * @depends testExecuteMethod
     *
     * @return void
     */
    public function testExecuteMethodWithCreate()
    {
        $data = array('name' => 'Windstormeee');

        $data['created_at'] = date('Y-m-d H:i:s');

        $mutator = new CreateUser((array) $data);

        $result = $this->repository->set($mutator);

        $this->assertEquals(1, $result->affected());
    }

    /**
     * Tests ResultInterface::result with update.
     *
     * @depends testExecuteMethod
     *
     * @return void
     */
    public function testExecuteMethodWithUpdate()
    {
        $data = array('id' => 1, 'name' => 'Windstorm');

        $mutator = new UpdateUser(1, (array) $data);

        $result = $this->repository->set($mutator);

        $this->assertEquals(1, $result->affected());
    }

    /**
     * Tests ResultInterface::result with delete.
     *
     * @depends testExecuteMethod
     *
     * @return void
     */
    public function testExecuteMethodWithDelete()
    {
        $result = $this->repository->set(new DeleteUser(4));

        $this->assertEquals(1, $result->affected());
    }

    /**
     * Tests ResultInterface::items.
     *
     * @depends testExecuteMethod
     *
     * @return void
     */
    public function testItemsMethod()
    {
        $result = $this->repository->set(new ReturnUsers);

        $this->assertCount(3, $result->items());
    }
}
