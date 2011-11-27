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

use MZ\MailChimpBundle\DependencyInjection\Configuration;

/**
 * Test Configuration
 *
 * @author Miguel Perez <miguel@mlpz.mp>
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test get config tree
     *
     * @covers MZ\MailChimpBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testThatCanGetConfigTreeBuilder()
    {
        $configuration = new Configuration();
        $this->assertInstanceOf('Symfony\Component\Config\Definition\Builder\TreeBuilder', $configuration->getConfigTreeBuilder());
    }
}
