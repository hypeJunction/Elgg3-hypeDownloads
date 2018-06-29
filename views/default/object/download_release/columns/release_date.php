<?php

$item = elgg_extract('item', $vars);

if (!$item instanceof \hypeJunction\Downloads\Release) {
	return;
}

echo elgg_view_friendly_time($item->time_created);