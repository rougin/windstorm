<?php

namespace Rougin\Windstorm;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Rougin\Windstorm\Doctrine\Query;
use Rougin\Windstorm\Doctrine\Result;
use Rougin\Windstorm\Fixture\Entities\User;
use Rougin\Windstorm\Fixture\Mutators\ReturnUser;
use Rougin\Windstorm\Fixture\Mutators\ReturnUsers;
use Rougin\Windstorm\Fixture\Mutators\ReturnUsersWithPosts;
use Rougin\Windstorm\Fixture\Mutators\UpdateUser;
use Rougin\Windstorm\Fixture\UserRepository;

/**
 * Query Repository Test
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class QueryRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Rougin\Windstorm\QueryInterface
     */
    protected $query;

    /**
     * @var \Rougin\Windstorm\QueryRepository
     */
    protected $repo;

    /**
     * @var \Rougin\Windstorm\Fixture\UserRepository
     */
    protected $user;

    /**
     * Sets up the query builder instance.
     *
     * @return void
     */
    public function setUp()
    {
        $paths = array($root = (string) __DIR__);

        $config = Setup::createAnnotationMetadataConfiguration($paths, true);

        $database = array('path' => (string) $root . '/Fixture/Database.db');

        $database['driver'] = 'pdo_sqlite';

        $manager = EntityManager::create($database, $config);

        $builder = new QueryBuilder($manager->getConnection());

        $result = new Result($manager->getConnection());

        $this->query = $query = new Query($builder);

        $this->repo = new QueryRepository($query, $result);

        $this->user = new UserRepository($query, $result);
    }

    /**
     * Tests QueryRepository::affected.
     *
     * @return void
     */
    public function testAffectedMethod()
    {
        $data = array('updated_at' => date('Y-m-d H:i:s'));

        $result = $this->user->set(new UpdateUser(1, $data));

        $this->assertEquals(1, $result->affected());
    }

    /**
     * Tests QueryRepository::first.
     *
     * @return void
     */
    public function testFirstMethod()
    {
        $expected = new User(1, 'Windstorm');

        $result = $this->user->set(new ReturnUser(1));

        $result = $result->first();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryRepository::first without mapping.
     *
     * @return void
     */
    public function testFirstMethodWithoutMapping()
    {
        $expected = array('id' => '1');
        $expected['name'] = 'Windstorm';
        $expected['created_at'] = '2018-10-15 23:06:28';

        $result = $this->repo->set(new ReturnUser(1));

        $result = $result->first();

        unset($result['updated_at']);

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryRepository::first with a mixed instance.
     * TODO: Failed build on PHP below v7.0.0.
     *
     * @return void
     */
    // public function testFirstMethodWithMixedQuery()
    // {
    //     $expected = array('u_id' => '1');
    //     $expected['u_name'] = 'Windstorm';
    //     $expected['u_posts'] = array();

    //     $post = array('p_id' => '1');
    //     $post['p_title'] = 'Seven Tips To Avoid Failure In Windstorm';
    //     $post['p_body'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vitae ipsum id arcu fermentum facilisis. Aliquam mollis vestibulum neque. Mauris dictum finibus felis, a accumsan massa. Cras id sapien rhoncus, efficitur neque eu, mattis massa. Donec enim nibh, dapibus id luctus et, lobortis sit amet tortor. Nullam pulvinar vel tellus at semper. Proin volutpat vel lacus eget accumsan. In hac habitasse platea dictumst. Quisque fringilla velit ac est suscipit, at egestas tortor mollis. Nullam velit erat, fermentum eu nibh ut, sagittis euismod est. Curabitur at dictum sapien, a fringilla velit. Quisque ac euismod leo. Aenean at aliquam tellus. Curabitur hendrerit felis at elit malesuada, eu faucibus nisl bibendum.';
    //     $post['p_user_id'] = '1';
    //     array_push($expected['u_posts'], $post);

    //     $post = array('p_id' => '4');
    //     $post['p_title'] = 'This Is Why Windstorm Is So Famous';
    //     $post['p_body'] = 'Sed in cursus lectus, et pulvinar magna. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut in tortor nibh. Fusce quis tincidunt turpis. Vestibulum ut risus lacinia, mollis mauris quis, posuere neque. Nunc eget neque ac lacus maximus volutpat. Cras interdum arcu sit amet interdum vestibulum. Sed dignissim metus eu eros pellentesque tincidunt. Mauris quis consequat lorem. Praesent vel enim imperdiet, aliquam risus ac, luctus ex. Proin a dictum velit. Mauris blandit aliquam mauris non sollicitudin. Phasellus congue interdum viverra.';
    //     $post['p_user_id'] = '1';
    //     array_push($expected['u_posts'], $post);

    //     $mutator = new ReturnUsersWithPosts;

    //     $result = $this->repo->set($mutator)->first();

    //     $this->assertEquals($expected, $result);
    // }

    /**
     * Tests QueryRepository::items.
     *
     * @return void
     */
    public function testItemsMethod()
    {
        $result = $this->user->set(new ReturnUsers);

        $this->assertCount(3, $result->items());
    }

    /**
     * Tests QueryRepository::items without a mapping instance.
     *
     * @return void
     */
    public function testItemsMethodWithoutMapping()
    {
        $result = $this->repo->set(new ReturnUsers);

        $this->assertCount(3, $result->items());
    }

    /**
     * Tests QueryRepository::query.
     *
     * @return void
     */
    public function testQueryMethod()
    {
        $this->assertEquals($this->query, $this->repo->query());
    }
}
