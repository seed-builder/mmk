<?php
return array(
	'enable' => config('app.debug'),

	'prefix' => 'api-docs',

	'paths' => [base_path('app'), base_path('routes')],
	'output' => storage_path('swagger/docs'),
	'exclude' => null,
	'default-base-path' => 'http://laradock:8080',
	'default-api-version' => null,
	'default-swagger-version' => null,
	'api-doc-template' => null, //
	'suffix' => '.{format}',

	'title' => 'Swagger UI'
);