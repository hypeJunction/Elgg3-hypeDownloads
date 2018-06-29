<?php

namespace hypeJunction\Downloads;

/**
 * @property string $version
 */
class Release extends \ElggFile {

	const SUBTYPE = 'download_release';

	/**
	 * {@inheritdoc}
	 */
	public function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = self::SUBTYPE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDisplayName() {
		$download = $this->getContainerEntity();
		if ($download) {
			return implode(' ', array_filter([$download->getDisplayName(), $this->version]));
		}

		return parent::getDisplayName();
	}
}
