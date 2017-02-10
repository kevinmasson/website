<?php
use Cake\Routing\Router;

$this->append('css'); 

?>
	<style>
.mce-fullscreen{
z-index : 9999 !important;
}
</style>
<?php 
$this->end();
$this->append('script');
?>
<script>
tinymce.init({
selector: '.wisiwyg',
	theme: 'modern',
	plugins: [
		'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker imagetools',
		'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
		'save table contextmenu directionality emoticons template paste textcolor'
	],
	content_css: '/css/bootstrap.min.css',
	toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',
	relative_urls : false,
	file_browser_callback_types: 'image',
	file_browser_callback: function(field_name, url, type, win) {
		tinymce.activeEditor.windowManager.open({
		url: '<?php echo Router::url(['_name' => 'admin_medias']); ?>',
			width: screen.width / 2 ,
			height: screen.height / 1.5 
	}, {
	custom_param: 1,
		window : win,
		input : field_name
	});
	}});


</script>
<?php
$this->end();
?>

