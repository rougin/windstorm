<?php

namespace Rougin\Windstorm\Doctrine;

/**
 * Result Test
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ResultTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * Sets up the result instance
     *
     * @return void
     */
    public function setUp()
    {
        $path = __DIR__ . '/../Fixture/Database.db';

        $this->pdo = new \PDO('sqlite:' . $path);

        $data = array();

        $item = array('id' => '1');
        $item['name'] = 'Windstorm';
        $item['created_at'] = '2018-10-15 23:06:28';
        $item['updated_at'] = null;

        $data[] = (array) $item;

        $item = array('id' => '2');
        $item['name'] = 'SQL Builder';
        $item['created_at'] = '2018-10-15 23:09:47';
        $item['updated_at'] = null;

        $data[] = (array) $item;

        $item = array('id' => '3');
        $item['name'] = 'Rougin Gutib';
        $item['created_at'] = '2018-10-15 23:14:45';
        $item['updated_at'] = null;

        $data[] = (array) $item;

        $this->data = (array) $data;
    }

    /**
     * Tests ResultInterface::affected.
     *
     * @return void
     */
    public function testAffectedMethod()
    {
        $result = new Result(100);

        $result = $result->affected();

        $expected = 100;

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ResultInterface::first.
     *
     * @return void
     */
    public function testFirstMethod()
    {
        $expected = $this->data[0];

        $result = new Result($this->data);

        $result = $result->first();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ResultInterface::first with PDO instance.
     *
     * @return void
     */
    public function testFirstMethodWithPdo()
    {
        $query = 'SELECT u.* FROM users u';

        $stmt = $this->pdo->prepare($query);

        $stmt->execute();

        $expected = $this->data[0];

        $result = new Result($stmt);

        $result = $result->first();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ResultInterface::items.
     *
     * @return void
     */
    public function testItemsMethod()
    {
        $result = new Result($expected = $this->data);

        $result = $result->items();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ResultInterface::items with PDO instance.
     *
     * @return void
     */
    public function testItemsMethodWithPdo()
    {
        $query = 'SELECT u.* FROM users u';

        $stmt = $this->pdo->prepare($query);

        $stmt->execute();

        $expected = (array) $this->data;

        $result = new Result($stmt);

        $result = $result->type(\PDO::FETCH_ASSOC);

        $result = (array) $result->items();

        $this->assertEquals($expected, $result);
    }
}
