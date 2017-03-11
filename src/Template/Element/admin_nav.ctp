<?php

use Cake\Routing\Router;
?>
<nav class="my4 text-right">
<a href="<?= Router::url(['_name' => 'admin_home']) ?>">Administration</a>,
<a href="<?= Router::url(['_name' => 'logout']) ?>">Déconnexion</a>,
<a href="<?= Router::url(['_name' => 'admin_creations']) ?>">Gestion portfolio</a>
</nav>
