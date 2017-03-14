<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2016-12-19
 * Time: 16:44
 */
return [
	//blade templates and cache folder
	'blade' => [
		'template' =>  realpath(base_path('resources/templates')),
		'template_cache' =>  realpath(base_path('resources/templates/cache')),
	],
	//outputs groups
	'outputs' => ['admin', 'api','datatables'],
	//output group
	//template name => output settings
	'admin' => [
		'model' => ['path' => app_path('Models/Busi'), 'name_pattern' => '{model}.php'],
		//'route' => ['path' => base_path('routes/admin'), 'name_pattern' => '{model}.php', 'name_format' => 'strtolower'],
		//'controller' => ['path' => app_path('Http/Controllers/Admin'), 'name_pattern' => '{model}Controller.php'],
		//'view' => ['path' => base_path('resources/views'), 'name_pattern' => '{model}.blade.php', 'name_format' => 'strtolower'],
	],
	'api' => [
		'route' => ['path' => base_path('routes/api'), 'name_pattern' => '{model}.php', 'name_format' => 'strtolower'],
		'controller' => ['path' => app_path('Http/Controllers/Api'), 'name_pattern' => '{model}Controller.php'],
	],
	'datatables' => [
		'route' => ['path' => base_path('routes/admin'), 'name_pattern' => '{model}.php', 'name_format' => 'strtolower'],
		'controller' => ['path' => app_path('Http/Controllers/Admin'), 'name_pattern' => '{model}Controller.php'],
		'view_index' => ['path' => base_path('resources/views/default/admin/{model}'), 'name_pattern' => 'index.blade.php', 'name_format' => 'snake_case2'],
		'js' => ['path' => base_path('public/assets/admin'), 'name_pattern' => '{model}.js', 'name_format' => 'snake_case'],
	],
	'customer' => [
		'route' => ['path' => base_path('routes/customer'), 'name_pattern' => '{model}.php', 'name_format' => 'strtolower'],
		'controller' => ['path' => app_path('Http/Controllers/Customer'), 'name_pattern' => '{model}Controller.php'],
		'view_index' => ['path' => base_path('resources/views/default/customer/{model}'), 'name_pattern' => 'index.blade.php', 'name_format' => 'snake_case2'],
		'js' => ['path' => base_path('public/assets/customer'), 'name_pattern' => '{model}.js', 'name_format' => 'snake_case'],
	],
];