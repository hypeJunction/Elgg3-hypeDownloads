<?php

namespace hypeJunction\Downloads;

/**
 * @group Plugins
 * @group StaticConfig
 *
 * @group Downloads
 */
class StaticConfigTest extends \Elgg\Plugins\StaticConfigTest {

	public function testRouteRegistrations() {
		$this->markTestSkipped('Loads some views from hypePost');

		parent::testRouteRegistrations();
	}
}