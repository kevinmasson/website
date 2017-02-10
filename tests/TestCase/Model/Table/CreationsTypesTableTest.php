<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CreationsTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CreationsTypesTable Test Case
 */
class CreationsTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CreationsTypesTable
     */
    public $CreationsTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.creations_types',
        'app.creations',
        'app.types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CreationsTypes') ? [] : ['className' => 'App\Model\Table\CreationsTypesTable'];
        $this->CreationsTypes = TableRegistry::get('CreationsTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CreationsTypes);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
