<?php

namespace hypeJunction\Downloads;

use Elgg\Event;
use hypeJunction\Fields\MetaField;

class SetupDownloadForm {

	public function __invoke(Event $event) {

		$fields = $event->getValue();
		/* @var $fields \hypeJunction\Fields\Collection */

		$fields->add('releases', new ReleasesField([
			'type' => 'downloads/releases',
			'is_profile_field' => false,
		]));

		$fields->add('license', new MetaField([
			'type' => 'text',
			'section' => 'sidebar',
		]));

		$fields->get('title')->required = false;

		$fields->get('description')->required = false;
		$fields->get('description')->{'data-parsley-required'} = false;

		return $fields;
	}
}