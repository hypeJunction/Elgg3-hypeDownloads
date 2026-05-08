<?php

namespace hypeJunction\Downloads;

use Elgg\Event;

class SetupContainerLogic {

	public function __invoke(Event $event): ?bool {

		$container = $event->getParam('container');
		$subtype = $event->getParam('subtype');

		if ($subtype == Release::SUBTYPE && !$container instanceof Download) {
			return false;
		}

		return null;
	}
}