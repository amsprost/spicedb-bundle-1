<?php declare(strict_types=1);

namespace LinkORB\AuthzedBundle\DependencyInjection;

use LinkORB\Authzed\SpiceDB;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class AuthzedExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configDir = new FileLocator(__DIR__ . '/../../config');
        // Load the bundle's service declarations
        $loader = new YamlFileLoader($container, $configDir);
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $options = $this->processConfiguration($configuration, $configs);

        $spiceDB = $container->getDefinition(SpiceDB::class);
        $spiceDB->setArgument('$baseUri', $options['uri']);
        $spiceDB->setArgument('$apiKey', $options['key']);
    }
}
