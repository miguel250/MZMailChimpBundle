<?php

/*
 * This file is part of the MZ\MailChimpBundle
 *
 * (c) Miguel Perez <miguel@mlpz.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MZ\MailChimpBundle\DependencyInjection;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     * @return treeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mz_mail_chimp');

        $rootNode->children()
                ->scalarNode('api_key')
                ->isRequired()
                ->cannotBeEmpty()
                ->end()
                ->scalarNode('default_list')
                ->isRequired()
                ->cannotBeEmpty()
                ->end()
                ->booleanNode('ssl')
                ->defaultTrue()
                ->end()
                ->end();

        return $treeBuilder;
    }
}
