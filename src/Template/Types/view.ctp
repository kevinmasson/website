<?php

$this->assign('title', __('Portfolio {0}', __($typeName)));

?>
<?= $this->Element('page_header', ['mainTitle' => __('Portfolio'), 'subtitle' => __($typeName)]) ?>
<?php
echo $this->element("grid_creations", [
	"creations" => $creations
]);
