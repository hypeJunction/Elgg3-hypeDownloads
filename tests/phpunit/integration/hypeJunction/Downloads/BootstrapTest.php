<?php

namespace hypeJunction\Downloads;

use Elgg\IntegrationTestCase;

/**
 * Verifies that Bootstrap registers expected event handlers when hypedownloads is active.
 */
class BootstrapTest extends IntegrationTestCase {

	public function up(): void {}
	public function down(): void {}

	public function getPluginID(): string {
		return 'hypedownloads';
	}

	public function testContainerLogicHandlerRegistered(): void {
		$this->assertTrue(
			_elgg_services()->events->hasHandler('container_logic_check', 'object', SetupContainerLogic::class),
			'container_logic_check/object handler must be registered'
		);
	}

	public function testEntityMenuHandlerRegistered(): void {
		$this->assertTrue(
			_elgg_services()->events->hasHandler('register', 'menu:entity', EntityMenu::class),
			'register/menu:entity handler must be registered'
		);
	}

	public function testSocialMenuHandlerRegistered(): void {
		$this->assertTrue(
			_elgg_services()->events->hasHandler('register', 'menu:social', SocialMenu::class),
			'register/menu:social handler must be registered'
		);
	}

	public function testSyncReleaseAccessHandlerRegistered(): void {
		$this->assertTrue(
			_elgg_services()->events->hasHandler('update:after', 'object', SyncReleaseAccess::class),
			'update:after/object handler must be registered'
		);
	}
}
