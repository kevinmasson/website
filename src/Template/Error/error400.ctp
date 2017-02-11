<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;
use Cake\Routing\Router;

$this->layout = 'default';
$this->assign('title', __('Page introuvable, 404'));
$this->assign('noindex', true);

if (Configure::read('debug')):
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error400.ctp');

    $this->start('file');
?>

<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?php Debugger::dump($error->params) ?>
<?php endif; ?>
<?= $this->element('auto_table_warning') ?>
<?php
    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
endif;
?>
<div class="row">
	<div class="col-md-7">
<?= $this->Html->image('missing.gif', ['class' => 'img-fluid']); ?>
<?= $fail; ?>
	</div>
	<div class="col-md-5">
  <h1 class="my-4">Woops !</h1>
  <p class="lead">Il semblerait que la page que vous avez demander n'existe pas ou n'existe plus...</p>
  <hr class="my-4">
  <p>Faites plus attention la prochaine fois ;).</p>
  <p class="lead">
  <a class="btn btn-primary btn-lg" href="<?= Router::url(['_name' => 'home']); ?>" role="button">Retourner à l'accueil</a>
   </p>
	</div>
</div>
