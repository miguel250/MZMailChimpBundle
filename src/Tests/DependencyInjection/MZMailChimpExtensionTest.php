<?php

/*
 * This file is part of the MZ\MailChimpBundle
 *
 * (c) Miguel Perez <miguel@mlpz.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MZ\MailChimpBundle\Tests\DependencyInjection;

use MZ\MailChimpBundle\DependencyInjection\MZMailChimpExtension;

/**
 * Test MZMailChimpExtension
 *
 * @author Miguel Perez <miguel@mlpz.mp>
 */
class MZMailChimpExtensionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test load failed
     * 
     * @covers MZ\MailChimpBundle\DependencyInjection\MZMailChimpExtension::load
     */
    public function testLoadFailed()
    {
        $container = $this->getMockBuilder('Symfony\\Component\\DependencyInjection\\ContainerBuilder')
                ->disableOriginalConstructor()
                ->getMock();

        $extension = $this->getMockBuilder('MZ\MailChimpBundle\DependencyInjection\MZMailChimpExtension')
                ->getMock();

        $extension->load(array(array()), $container);
    }

    /**
     * Test setParameters
     * 
     * @covers MZ\MailChimpBundle\DependencyInjection\MZMailChimpExtension::load
     */
    public function testLoadSetParameters()
    {
        $container = $this->getMockBuilder('Symfony\\Component\\DependencyInjection\\ContainerBuilder')
                ->disableOriginalConstructor()
                ->getMock();

        $parameterBag = $this->getMockBuilder('Symfony\Component\DependencyInjection\ParameterBag\\ParameterBag')
                ->disableOriginalConstructor()
                ->getMock();

        $parameterBag->expects($this->any())
                ->method('add');

        $container->expects($this->any())
                ->method('getParameterBag')
                ->will($this->returnValue($parameterBag));

        $extension = new MZMailChimpExtension();
        $configs = array(array('api_key' => 'foo'),
                array('default_list' => 'foo'),);
        $extension->load($configs, $container);
    }
}
