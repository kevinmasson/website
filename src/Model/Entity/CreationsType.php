<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CreationsType Entity
 *
 * @property int $creation_id
 * @property int $type_id
 *
 * @property \App\Model\Entity\Creation $creation
 * @property \App\Model\Entity\Type $type
 */
class CreationsType extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'creation_id' => false,
        'type_id' => false
    ];
}
