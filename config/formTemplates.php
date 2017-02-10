<?php
$config = [
	'Templates'=>[
		'shortForm' => [
			'formStart' => '<form class="" {{attrs}}>',
			'label' => '<label class="col-md-2 control-label" {{attrs}}>{{text}}</label>',
			'input' => '<div class="col-md-4"><input type="{{type}}" name="{{name}}" {{attrs}} /></div>',
			'select' => '<div class="col-md-4"><select name="{{name}}"{{attrs}}>{{content}}</select></div>',
			'inputContainer' => '<div class="form-group {{required}}" form-type="{{type}}">{{content}}</div>',
			'checkContainer' => ''
		],
		'longForm' => [
			'formStart' => '<form class="" {{attrs}}>',
			'label' => '<label class="col-md-2 control-label" {{attrs}}>{{text}}</label>',
			'input' => '<div class="col-md-6"><input type="{{type}}" name="{{name}}" {{attrs}} /></div>',
			'select' => '<div class="col-md-6"><select name="{{name}}"{{attrs}}>{{content}}</select></div>',
			'inputContainer' => '<div class="form-group {{required}}" form-type="{{type}}">{{content}}</div>',
			'checkContainer' => ''
		],
		'fullForm' => [
			'formStart' => '<form class="" {{attrs}}>',
			'label' => '<label class="col-md-2 control-label" {{attrs}}>{{text}}</label>',
			'input' => '<div class="col-md-10"><input type="{{type}}" name="{{name}}" {{attrs}} /></div>',
			'select' => '<div class="col-md-10"><select name="{{name}}"{{attrs}}>{{content}}</select></div>',
			'inputContainer' => '<div class="form-group {{required}}" form-type="{{type}}">{{content}}</div>',
			'checkContainer' => ''
		],
		'textual' => [
			'inputContainer' => '<div class="form-group row">{{content}}</div>',
			'label' => '<label class="col-xs-2 col-form-label" {{attrs}}>{{text}}</label>',
			'input' => '<div class="col-xs-10">
				<input class="form-control" type="{{type}}" name="{{name}}"{{attrs}}">
				</div>',
			'button' => '<button class="btn btn-primary" {{attrs}}>{{text}}</button>'
		],
		'default' => [
			'inputContainer' => '<div class="form-group">{{content}}</div>',
			'label' => '<label class="col-form-label" {{attrs}}>{{text}}</label>',
			'input' => '<div class="">
				<input class="form-control" type="{{type}}" name="{{name}}"{{attrs}}">
				</div>',
			'button' => '<button class="btn btn-primary" {{attrs}}>{{text}}</button>',
			'textarea' => '<textarea class="form-control" name="{{name}}"{{attrs}}>{{value}}</textarea>',
			'select' => '<select class="form-control" name="{{name}}"{{attrs}}>{{content}}</select>',
			'selectMultiple' => '<select class="form-control" name="{{name}}[]" multiple="multiple"{{attrs}}>{{content}}</select>',
		]

	]
];
