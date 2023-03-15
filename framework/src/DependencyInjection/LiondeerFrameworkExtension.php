<?php

namespace Liondeer\Framework\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class LiondeerFrameworkExtension extends Extension implements ExtensionInterface
{
    public function load(array $configs,ContainerBuilder $container){
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

//        $configuration = new Configuration();
//        $config = $this->processConfiguration($configuration, $configs);
//        foreach ($config as $key => $value) {
//            $container->setParameter('liondeer_framework.' . $key, $value);
//        }
        $this->addAnnotatedClassesToCompile([
            'Liondeer\\Framework\\Controller\\'
        ]);
    }

    public function getAlias(): string
    {
        return 'liondeer_framework';
    }
}