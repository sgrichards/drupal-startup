<?php

namespace Droath\ModuleSync\Tests;

use Droath\ModuleSync\ModuleSync;
use Droath\ModuleSync\SyncConfig;
use Drupal\Core\Extension\Extension;
use PHPUnit\Framework\TestCase;

/**
 * Define module sync unit test.
 */
class ModuleSyncTest extends TestCase {

  protected $moduleSync;
  protected $syncConfig;
  protected $moduleHandler;
  protected $moduleInstaller;

  public function setUp() {
    $this->syncConfig = new SyncConfig(__DIR__ . '/fixtures');

    $this->moduleHandler = $this
      ->getMockBuilder('\Drupal\Core\Extension\ModuleHandlerInterface')
      ->setMethods([
        'moduleExists',
        'getModuleList'
      ])
      ->getMock();

    $this->moduleInstaller = $this
      ->getMockBuilder('\Drupal\Core\Extension\ModuleInstallerInterface')
      ->setMethods([
        'install',
        'uninstall'
      ])
      ->getMock();

    $this->moduleSync = new ModuleSync(
      $this->syncConfig,
      $this->moduleHandler,
      $this->moduleInstaller
    );
  }

  public function testListInstalls() {
    $installs = $this->moduleSync
      ->setScope('local')
      ->listInstalls();

    $this->moduleHandler->expects($this->any())
      ->method('moduleExists')
      ->willReturn(false);

    $this->assertCount(3, $installs);
    $this->assertTrue(in_array('devel', $installs));
  }

  public function testListUninstalls() {
    $extension = $this
      ->getMockBuilder('\Drupal\Core\Extension\Extension')
      ->setMethods(['getType'])
      ->getMock();

    $extension->expects($this->any())
      ->method('getType')
      ->willReturn('module');

    $this->moduleHandler->expects($this->any())
      ->method('getModuleList')
      ->willReturn([
        'field' => $extension,
        'views' => $extension,
        'views_ui' => $extension,
    ]);

    $uninstalled = $this->moduleSync
      ->setScope('local')
      ->listUninstalls();

    $this->assertTrue(in_array('views_ui', $uninstalled));
  }

  public function testExecute() {
    $extension = $this
      ->getMockBuilder('\Drupal\Core\Extension\Extension')
      ->setMethods(['getType'])
      ->getMock();

    $extension->expects($this->any())
      ->method('getType')
      ->willReturn('module');

    $this->moduleHandler->expects($this->any())
      ->method('getModuleList')
      ->willReturn([
        'field' => $extension,
        'views' => $extension,
        'views_ui' => $extension,
    ]);

    $this->moduleInstaller->expects($this->once())
      ->method('install')
      ->with($this->identicalTo(['devel', 'field', 'views']))
      ->willReturn(true);

    $this->moduleInstaller->expects($this->once())
      ->method('uninstall')
      ->with($this->identicalTo(['views_ui']))
      ->willReturn(true);

    $this->moduleSync
      ->setScope('local')
      ->confirmInstall()
      ->confirmUninstall();

     $status = $this->moduleSync->execute();
     $this->assertInternalType('array', $status);
  }

  public function testGetConfig() {
    $this->assertInstanceOf('\Droath\ModuleSync\SyncConfig', $this->moduleSync->getConfig());
  }

}
