<?php

namespace hypeJunction\Downloads;

use Elgg\Hook;

class SocialMenu {

	/**
	 * Setup entity menu
	 *
	 * @param Hook $hook Hook
	 *
	 * @return \ElggMenuItem[]
	 */
	public function __invoke(Hook $hook) {

		$entity = $hook->getEntityParam();

		$menu = $hook->getValue();
		if ($entity instanceof Download) {
			$release = $entity->getLastRelease();

			if ($release) {
				$count = $entity->getDownloadsCount();

				// We are not checking the download permission here, as it will be enforced by controller
				$menu[] = \ElggMenuItem::factory([
					'name' => 'download:count',
					'title' => elgg_echo('downloads:count'),
					'icon' => 'download',
					'href' => elgg_get_download_url($release),
					'text' => '',
					'badge' => $count,
				]);
			}
		}

		return $menu;
	}
}