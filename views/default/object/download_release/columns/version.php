<?php

$item = elgg_extract('item', $vars);

if (!$item instanceof \hypeJunction\Downloads\Release) {
	return;
}

echo elgg_view('output/url', [
	'href' => $item->getURL(),
	'text' => $item->version,
]);
