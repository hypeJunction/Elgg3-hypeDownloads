<?php

namespace hypeJunction\Downloads;

use Elgg\Event;

class EntityMenu {

	public function __invoke(Event $event): void {

		$entity = $event->getEntityParam();

		$menu = $event->getValue();

		if ($entity instanceof Release) {
			$menu->add(\ElggMenuItem::factory([
				'name' => 'download',
				'icon' => 'download',
				'text' => \elgg_echo('download'),
				'href' => \elgg_get_download_url($entity),
			]));
		}
	}
}