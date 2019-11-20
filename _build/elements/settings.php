<?php

return [
	'url'         => [
		'namespace'   => 'ovenpars',
		'area'        => 'ovenpars_main',
		'xtype'       => 'textfield',
		'value'       => 'http://delopechnoe.ru/shop/pechi-otopitelnye',
		'description' => 'setting_url_desc',
		'name'        => 'setting_url',
		'key'         => 'url',
	],
	'container'   => [
		'namespace'   => 'ovenpars',
		'area'        => 'ovenpars_main',
		'xtype'       => 'textfield',
		'value'       => '#goods_cont',
		'description' => 'container_desc',
		'key'         => 'container',
	],
	'item'        => [
		'namespace'   => 'ovenpars',
		'area'        => 'ovenpars_main',
		'xtype'       => 'textfield',
		'value'       => '.list-item',
		'description' => 'item_desc',
		'key'         => 'item',
	],
	'section_id'  => [
		'namespace' => 'ovenpars',
		'area'      => 'ovenpars_import',
		'xtype'     => 'textfield',
		'value'     => '1',
		'key'       => 'section_id',
	],
	'template_id' => [
		'namespace' => 'ovenpars',
		'area'      => 'ovenpars_import',
		'xtype'     => 'textfield',
		'value'     => '1',
		'key'       => 'template_id',
	],
	'price_tv'    => [
		'namespace' => 'ovenpars',
		'area'      => 'ovenpars_import',
		'xtype'     => 'textfield',
		'value'     => 'price',
		'key'       => 'price_tv',
	],
	'desc_tv'     => [
		'namespace' => 'ovenpars',
		'area'      => 'ovenpars_import',
		'xtype'     => 'textfield',
		'value'     => 'characteristics',
		'key'       => 'desc_tv',
	],
	'image_tv'    => [
		'namespace' => 'ovenpars',
		'area'      => 'ovenpars_import',
		'xtype'     => 'textfield',
		'value'     => 'image',
		'key'       => 'image_tv',
	],
];