<?php
/**
 * Author: Michaël VEROUX
 * Date: 25/07/15
 * Time: 16:25
 */

namespace Mv\FreeSmsApiBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class MvFreeSmsApiExtension
 * @package Mv\FreeSmsApiBundle\DependencyInjection
 * @author Michaël VEROUX
 */
class MvFreeSmsApiExtension extends Extension
{

    /**
     * Loads a specific configuration.
     *
     * @param array $config An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     *
     * @api
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $config);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $this->registerUsersConfiguration($config['users'], $container);
    }

    /**
     * @param array $config
     * @param ContainerBuilder $container
     * @author Michaël VEROUX
     */
    protected function registerUsersConfiguration(array $config, ContainerBuilder $container)
    {
        $definition = new DefinitionDecorator('mv_free_sms_api.sender.user');

        foreach($config as $name => $params) {
            $container->setDefinition(sprintf('mv_free_sms_api.sender.%s', $name), $definition);
            $definition->replaceArgument(0, $name);
            $definition->replaceArgument(1, $params['free_user_id']);
            $definition->replaceArgument(2, $params['free_user_api_key']);
        }
    }
}