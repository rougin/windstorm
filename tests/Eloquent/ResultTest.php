<?php

namespace Rougin\Windstorm\Eloquent;

use Illuminate\Support\Collection;
use Rougin\Windstorm\Fixture\UserModel;

/**
 * Result Test
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ResultTest extends TestCase
{
    public function testExecuteMethod()
    {
        $expected = array('id' => (integer) 1);

        $expected['name'] = 'Windstorm';

        $expected['created_at'] = '2018-10-15 23:06:28';

        $expected['updated_at'] = null;

        $execute = new Result;

        $query = $this->query->select(array('*'));

        $query = $query->from('users');

        $response = $execute->execute($query);

        $result = $response->first()->toArray();

        $this->assertEquals($expected, $result);
    }
}
