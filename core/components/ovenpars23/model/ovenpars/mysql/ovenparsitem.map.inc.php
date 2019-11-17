<?php
$xpdo_meta_map['ovenparsItem'] = [
	'package'   => 'ovenpars',
	'version'   => '1.1',
	'table'     => 'ovenpars_items',
	'extends'   => 'xPDOSimpleObject',
	'tableMeta' =>
		[
			'engine' => 'InnoDB',
		],
	'fields'    =>
		[
			'name'        => '',
			'description' => '',
			'active'      => 1,
		],
	'fieldMeta' =>
		[
			'name'        =>
				[
					'dbtype'    => 'varchar',
					'precision' => '100',
					'phptype'   => 'string',
					'null'      => false,
					'default'   => '',
				],
			'image' =>
				[
					'dbtype'  => 'text',
					'phptype' => 'string',
					'null'    => true,
					'default' => '',
				],
			'description' =>
				[
					'dbtype'  => 'text',
					'phptype' => 'string',
					'null'    => true,
					'default' => '',
				],
			'price'       =>
				[
					'dbtype'  => 'text',
					'phptype' => 'string',
					'null'    => true,
					'default' => '',
				],
		],
	'indexes'   =>
		[
			'name'   =>
				[
					'alias'   => 'name',
					'primary' => false,
					'unique'  => false,
					'type'    => 'BTREE',
					'columns' =>
						[
							'name' =>
								[
									'length'    => '',
									'collation' => 'A',
									'null'      => false,
								],
						],
				],
			'active' =>
				[
					'alias'   => 'active',
					'primary' => false,
					'unique'  => false,
					'type'    => 'BTREE',
					'columns' =>
						[
							'active' =>
								[
									'length'    => '',
									'collation' => 'A',
									'null'      => false,
								],
						],
				],
		],
];
