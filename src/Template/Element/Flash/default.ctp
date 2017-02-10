<?php
$class = 'alert alert-dismissible fade in';
if (!empty($params['class'])) {
    if($params['class'] === 'error') $params['class'] = 'danger';
    $class .= ' alert-' . $params['class'];
}
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="<?= h($class) ?>" role="aler">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
<?= $message ?>
</div>
