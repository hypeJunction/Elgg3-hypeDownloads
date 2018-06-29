<?php

$item = elgg_extract('item', $vars);

if (!$item instanceof \hypeJunction\Downloads\Release) {
	return;
}

$menu = elgg()->menus->getUnpreparedMenu('entity', [
	'entity' => $item,
]);

$items = $menu->getItems();

foreach ($items as $item) {
	if ($item->icon) {
		$item->setText('');
	}
}

echo elgg_view_menu('entity:table', [
	'items' => $items,
	'class' => 'elgg-menu-hz',
]);