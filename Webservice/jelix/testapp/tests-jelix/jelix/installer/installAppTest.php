<?php
require_once (dirname(__FILE__).'/../../../../lib/jelix/installer/jInstallerApplication.class.php');
require_once (dirname(__FILE__).'/../../../../lib/jelix/installer/jInstallerEntryPoint.class.php');
require_once (dirname(__FILE__).'/../../../../lib/jelix/installer/jInstallerModuleInfos.class.php');
require_once (dirname(__FILE__).'/../../../../lib/jelix/core/jConfigCompiler.class.php');


class testInstallApp extends jInstallerApplication {

}


class installAppTest extends PHPUnit_Framework_TestCase {

    function setUp() {
        jApp::saveContext();
    }

    function tearDown() {
        jApp::restoreContext();
    }


    function testEntryPointsList () {
        jApp::initPaths(dirname(__FILE__).'/app1/');
        
        $app = new testInstallApp('project_empty.xml');
        $this->assertEquals(array(), $app->getEntryPointsList());

        $app = new testInstallApp('project_empty2.xml');
        $this->assertEquals(array(), $app->getEntryPointsList());

        $app = new testInstallApp('project.xml');
        $list = $app->getEntryPointsList();
        $this->assertEquals(2, count($list));
        
        $ep = $app->getEntryPointInfo('index');
        $this->assertFalse($ep->isCliScript);
        $this->assertEquals('/index.php', $ep->scriptName);
        $this->assertEquals('index.php', $ep->file);
        $this->assertEquals('', $ep->type);
        $this->assertEquals('aaa', $ep->config->startModule);

        $ep = $app->getEntryPointInfo('foo');
        $this->assertFalse($ep->isCliScript);
        $this->assertEquals('/foo.php', $ep->scriptName);
        $this->assertEquals('foo.php', $ep->file);
        $this->assertEquals('', $ep->type);
        $this->assertEquals('foo', $ep->config->startModule);
    }
}