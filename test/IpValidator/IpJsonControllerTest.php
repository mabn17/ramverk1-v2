<?php

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class IpJsonControllerTest extends TestCase
{
    /**
     * Test the route "index".
     */
    public function testIndexAction()
    {
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . '/config/di');

        $controller = new IpJsonController();
        $controller->setDI($di);
        $controller->initialize();

        $this->assertInstanceOf("\Anax\Controller\IpJsonController", $controller);
        $this->assertEquals($controller->initialize(), null);

        $res = $controller->indexAction();
    }

    /**
     * Test the route "/look"
     */
    public function testLookAction()
    {
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . '/config/di');

        $controller = new IpJsonController();
        $controller->setDI($di);
        $res = $controller->lookAction();

        $this->assertEquals($res[0]["Kmom01"], "Lägg in din valda ip adress efter validate/check?ip={ip adress}");
        $this->assertEquals($res[0]["Kmom02"], "Lägg in din valda ip adress efter ip-json/map?ip={ip adress}");
    }

    public function testCheckActionGet()
    {
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . '/config/di');

        $controller = new IpJsonController();
        $controller->setDI($di);
        $res = $controller->checkActionGet();

        $this->assertEquals("array", gettype($res));
    }

    public function testMapActionGet()
    {
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . '/config/di');

        $controller = new IpJsonController();
        $controller->setDI($di);
        $res = $controller->mapActionGet();

        $this->assertEquals("array", gettype($res));
    }

    public function testMapActionPost()
    {
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . '/config/di');

        $controller = new IpJsonController();
        $controller->setDI($di);
        $res = $controller->mapActionPost();

        $this->assertEquals("array", gettype($res));
    }
}
