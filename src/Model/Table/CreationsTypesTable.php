<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CreationsTypes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Creations
 * @property \Cake\ORM\Association\BelongsTo $Types
 *
 * @method \App\Model\Entity\CreationsType get($primaryKey, $options = [])
 * @method \App\Model\Entity\CreationsType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CreationsType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CreationsType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CreationsType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CreationsType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CreationsType findOrCreate($search, callable $callback = null)
 */
class CreationsTypesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('creations_types');
        $this->displayField('creation_id');
        $this->primaryKey(['creation_id', 'type_id']);

        $this->belongsTo('Creations', [
            'foreignKey' => 'creation_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Types', [
            'foreignKey' => 'type_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['creation_id'], 'Creations'));
        $rules->add($rules->existsIn(['type_id'], 'Types'));

        return $rules;
    }
}
