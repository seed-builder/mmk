<?php
return array(
	'enable' => env('APP_DEBUG', false), //config('app.debug'),

	'prefix' => 'api-docs',

	'paths' => [base_path('app'), base_path('routes')],
	'output' => storage_path('swagger/docs'),
	'exclude' => null,
	'default-base-path' => '/', //env('SWAGGER_BASE_PATH'),
	'default-api-version' => null,
	'default-swagger-version' => null,
	'api-doc-template' => null, //
	'suffix' => '.{format}',

	'title' => 'Swagger UI'
);