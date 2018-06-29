<?php

namespace hypeJunction\Downloads;

use Elgg\Hook;

class SetupContainerLogic {

	/**
	 * Setup container logic
	 *
	 * @param Hook $hook Hook
	 *
	 * @return bool
	 */
	public function __invoke(Hook $hook) {

		$container = $hook->getParam('container');
		$subtype = $hook->getParam('subtype');

		if ($subtype == Release::SUBTYPE && !$container instanceof Download) {
			return false;
		}
	}
}