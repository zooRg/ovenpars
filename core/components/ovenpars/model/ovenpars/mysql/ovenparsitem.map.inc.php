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
			'parent'      => '',
			'name'        => '',
			'image'       => '',
			'price'       => '',
			'description' => '',
			'active'      => '',
		],
	'fieldMeta' =>
		[
			'parent'      =>
				[
					'dbtype'    => 'varchar',
					'precision' => '100',
					'phptype'   => 'string',
					'null'      => false,
					'default'   => '',
				],
			'name'        =>
				[
					'dbtype'    => 'varchar',
					'precision' => '100',
					'phptype'   => 'string',
					'null'      => false,
					'default'   => '',
				],
			'image'       =>
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
			'description' =>
				[
					'dbtype'  => 'text',
					'phptype' => 'string',
					'null'    => true,
					'default' => '',
				],
			'active'      =>
				[
					'dbtype'    => 'tinyint',
					'precision' => '1',
					'phptype'   => 'boolean',
					'null'      => false,
					'default'   => 1,
				],
		],
	'indexes'   =>
		[
			'parent'   =>
				[
					'alias'   => 'parent',
					'primary' => false,
					'unique'  => false,
					'type'    => 'BTREE',
					'columns' =>
						[
							'parent' =>
								[
									'length'    => '',
									'collation' => 'A',
									'null'      => false,
								],
						],
				],
			'name'   =>
				[
					'alias'   => 'name',
					'primary' => false,
					'unique'  => true,
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
