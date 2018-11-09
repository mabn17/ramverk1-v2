<?php

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class IpControllerTest extends TestCase
{
    /**
     * Test the route "index".
     */
    public function testIndexAction()
    {
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . '/config/di');

        $controller = new IpController();
        $controller->setDI($di);

        $controller->initialize();

        $this->assertEquals($controller->data, []);
        $this->assertInstanceOf("\Anax\Controller\IpController", $controller);
        $this->assertEquals($controller->initialize(), null);

        $res = $controller->indexAction();
    }

    public function testUpdateActionPost()
    {
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . '/config/di');
        $controller = new IpController();
        $controller->setDI($di);
        $request = $di->get("request");
        $res = $controller->updateActionPost();

        $this->assertEquals($di->get("response")->redirect("validate"), $res);
    }
}
