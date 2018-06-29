<?php

$entity = elgg_extract('entity', $vars);

if (!$entity instanceof \hypeJunction\Downloads\Download) {
	return;
}

if (!$entity->changelog) {
	return;
}

$output = elgg_view('output/longtext', [
	'value' => $entity->changelog,
]);

echo elgg_view('post/module', [
	'title' => elgg_echo('downloads:changelog'),
	'body' =>  $output,
	'collapsed' => true,
]);