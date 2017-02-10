<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CreationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CreationsTable Test Case
 */
class CreationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CreationsTable
     */
    public $Creations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.creations',
        'app.types',
        'app.creations_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Creations') ? [] : ['className' => 'App\Model\Table\CreationsTable'];
        $this->Creations = TableRegistry::get('Creations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Creations);

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
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
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
