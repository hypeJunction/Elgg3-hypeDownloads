<?php

namespace hypeJunction\Downloads;

use Elgg\Event;

class SocialMenu {

	public function __invoke(Event $event): void {

		$entity = $event->getEntityParam();

		$menu = $event->getValue();
		if ($entity instanceof Download) {
			$release = $entity->getLastRelease();

			if ($release) {
				$count = $entity->getDownloadsCount();

				$menu->add(\ElggMenuItem::factory([
					'name' => 'download:count',
					'title' => \elgg_echo('downloads:count'),
					'icon' => 'download',
					'href' => \elgg_get_download_url($release),
					'text' => '',
					'badge' => $count,
				]));
			}
		}
	}
}