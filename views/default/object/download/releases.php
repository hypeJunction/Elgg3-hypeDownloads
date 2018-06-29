<?php

$entity = elgg_extract('entity', $vars);

if (!$entity instanceof \hypeJunction\Downloads\Download) {
	return;
}

$params = $vars;
$params['full_view'] = false;
$params['limit'] = 0;
$params['pagination'] = false;
$params['list_type'] = 'table';

$releases = $entity->getReleases($params);

echo elgg_view('post/module', [
	'title' => $releases->getDisplayName(),
	'body' =>  $releases->render($params),
	'collapsed' => false,
	'class' => 'has-list',
]);
