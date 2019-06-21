<?php

return [
	'entities' => [
		'download' => [
			'type' => 'object',
			'subtype' => 'download',
			'class' => \hypeJunction\Downloads\Download::class,
			'searchable' => true,
		],
		'download_release' => [
			'type' => 'object',
			'subtype' => 'download_release',
			'class' => \hypeJunction\Downloads\Release::class,
			'searchable' => true,
		],
	],
	'routes' => [
		'add:object:download' => [
			'path' => '/downloads/add/{guid}',
			'resource' => 'post/add',
			'defaults' => [
				'type' => 'object',
				'subtype' => 'download',
			],
		],
		'edit:object:download' => [
			'path' => '/downloads/edit/{guid}',
			'resource' => 'post/edit',
		],
		'view:object:download' => [
			'path' => '/downloads/view/{guid}/{title?}',
			'resource' => 'post/view',
		],
		'view:object:download_release' => [
			'path' => '/downloads/releases/view/{guid}',
			'resource' => 'post/view',
		],
		'collection:object:download:all' => [
			'path' => '/downloads/all',
			'resource' => 'collection/all',
		],
		'collection:object:download:owner' => [
			'path' => '/downloads/owner/{username?}',
			'resource' => 'collection/owner',
		],
		'collection:object:download:friends' => [
			'path' => '/downloads/friends/{username?}',
			'resource' => 'collection/friends',
		],
		'collection:object:download:group' => [
			'path' => '/downloads/group/{guid}',
			'resource' => 'collection/group',
		],
		'collection:object:download_release' => [
			'path' => '/downloads/releases/{guid}',
			'resource' => 'collection/group',
		],
		'download:object:download_release' => [
			'path' => '/downloads/download/{guid}',
			'controller' => \hypeJunction\Downloads\DownloadController::class,
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
		],
	],
	'widgets' => [
		'downloads' => [
			'context' => ['profile', 'dashboard', 'groups'],
		],
	],
];
