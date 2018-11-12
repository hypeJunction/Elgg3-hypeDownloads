<?php

namespace hypeJunction\Downloads;

use Elgg\Hook;

class EntityMenu {

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

		if ($entity instanceof Release) {
			// We are not checking the download permission here, as it will be enforced by controller
			$menu[] = \ElggMenuItem::factory([
				'name' => 'download',
				'icon' => 'download',
				'text' => elgg_echo('download'),
				'href' => elgg_get_download_url($entity),
			]);
		}

		return $menu;
	}
}