<?php

use Cake\Routing\Router;

?>

<div class="btn-group-vertical w-100" role="group" aria-label="Creations control">
<?= $this->Html->link(__('Ajouter une création'), ['_name' => 'admin_creations_new'], ['btn' => 'secondary']) ?>
<?= $this->Html->link(__('Ajouter un type'), ['_name' => 'admin_types_new'], ['btn' => 'secondary']) ?>
<?= $this->Html->link(__('Liste des créations'), ['_name' => 'admin_creations'], ['btn' => 'secondary']) ?>
<?= $this->Html->link(__('Liste des types'), ['_name' => 'admin_types'], ['btn' => 'secondary']) ?>
<?php if(!isset($noclose)): ?>
</div>
<?php endif; ?>
