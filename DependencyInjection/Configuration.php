<?php
/**
 * Author: Michaël VEROUX
 * Date: 25/07/15
 * Time: 16:24
 */

namespace Mv\FreeSmsApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Mv\FreeSmsApiBundle\DependencyInjection
 * @author Michaël VEROUX
 */
class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mv_free_sms_api');

        $rootNode
            ->children()
                ->arrayNode('users')
                    ->useAttributeAsKey('name')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('free_user_id')
                                    ->isRequired()
                                    ->info('Mettre votre identifiant Free Mobile')
                                ->end()
                                ->scalarNode('free_user_api_key')
                                    ->isRequired()
                                    ->info('Mettre l\'api key que vous trouverez dans votre compte client Free Mobile')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
