<?php

use Cake\Routing\Router;
?>


<nav class="navbar navbar-full navbar-dark bg-primary" style="z-index: 2000;">  
<button class="navbar-toggler hidden-lg-up" 
	type="button" data-toggle="collapse" 
	data-target="#adminNavResponsive" 
	aria-controls="adminNavResponsive" aria-expanded="false" 
	aria-label="Toggle navigation">
</button>
<div class="collapse navbar-toggleable-md" id="adminNavResponsive">
<ul class="nav navbar-nav">
    	<li class="nav-item active">
    		<a class="nav-link" href="<?= Router::url(['_name' => 'admin_home']) ?>">Administration<span class="sr-only">(current)</span></a>
	</li>
    	<li class="nav-item">
	<a class="nav-link" href="<?= Router::url(['_name' => 'admin_creations']) ?>">Gestion portfolio
		</a>
	</li>

</ul>

<a class="btn btn-warning float-xs-right" href="<?= Router::url(['_name' => 'logout']) ?>">Déconnexion</a>
</div>
</nav>
