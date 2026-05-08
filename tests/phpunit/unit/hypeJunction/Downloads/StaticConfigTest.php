<?php

namespace hypeJunction\Downloads;

use PHPUnit\Framework\TestCase;

/**
 * @group Plugins
 * @group StaticConfig
 * @group Downloads
 */
class StaticConfigTest extends TestCase {

	public function testElggPluginPhpReturnsArray(): void {
		$config = require dirname(__DIR__, 5) . '/elgg-plugin.php';
		$this->assertIsArray($config, 'elgg-plugin.php must return an array');
	}

	public function testBootstrapKeyIsSet(): void {
		$config = require dirname(__DIR__, 5) . '/elgg-plugin.php';
		$this->assertArrayHasKey('bootstrap', $config, 'elgg-plugin.php must declare a bootstrap class');
		$this->assertEquals(\hypeJunction\Downloads\Bootstrap::class, $config['bootstrap']);
	}
}
