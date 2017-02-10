<?php
$this->assign('title', __('Gestion des médias'));
?>
<div class="card-columns">
<?php foreach ($medias as $media): ?>
   <div class="card">
      <?= $this->Html->cimage($media, 'file', ['alt' => $media->description, 'class' => "medias card-img img-fluid"]); ?>
   </div>
<?php endforeach; ?>
</div>

<nav aria-label="Page navigation">
<ul class="pagination">
	 <?= $this->Paginator->prev('< ' . __('previous')) ?>
	 <?= $this->Paginator->numbers() ?>
	 <?= $this->Paginator->next(__('next') . ' >') ?>
</ul>
</nav>
<div class="container">
     <div class="row">
	     <div class="col-md-9">
		 <?= $this->Form->create($mediaForm, ["type" => "file"]) ?>
		 <?= $this->Form->input('file', ['label' => __('Fichier image'), 'type' => 'file', 'required' => true]); ?>
		 <?= $this->Form->input('description', ['label' => __('Description')]); ?>

		 <?= $this->Form->button(__('Ajouter')) ?>
		 <?= $this->Form->end() ?>
	     </div>
     </div>
</div>	
<?php
$this->append("script");
?>
<script type="text/javascript" language="javascript">
$(document).on("click","img.medias",function(){
  item_url = $(this).attr("src");
  var args = top.tinymce.activeEditor.windowManager.getParams();
  console.log(args);
  win = (args.window);
  input = (args.input);
   win.document.getElementById(input).value = item_url;
  top.tinymce.activeEditor.windowManager.close();
});
</script>
<?php
$this->end();
?>
