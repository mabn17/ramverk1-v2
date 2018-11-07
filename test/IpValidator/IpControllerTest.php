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
        $controller = new IpController();
        $controller->initialize();

        $this->assertEquals($controller->data, []);
        $this->assertInstanceOf("\Anax\Controller\IpController", $controller);
    }
}
