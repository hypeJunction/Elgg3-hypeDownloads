<?php

$item = elgg_extract('item', $vars);

if (!$item instanceof \hypeJunction\Downloads\Release) {
	return;
}

echo elgg_view_entity_icon($item, 'tiny');