<?php

namespace Drupal\Tests\startup_core\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Test Kernel test.
 *
 * @group startup
 */
class StartupCoreKernelTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = [];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setup();
  }

  /**
   * Test should work.
   */
  public function testShouldEqual() {
    $this->assertEquals('Test', 'Test');
  }

}
