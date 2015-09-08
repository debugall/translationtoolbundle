<?php

namespace Afe\TranslationToolBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AfeTranslationToolExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $format                 = $config['translation_files_format'];
        $locale                 = $config['translation_files_locale'];
        $translationFilesDirPath             = $config['translation_files_dir_path'];
        $srcDirPath             = $config['src_dir_path'];
        $excludeVendorDirectory = $config['excluded_translation_directories'];
        $formatToLookInto = $config['format_to_look_into'];
        $excludedTranslationFileMask = $config['excluded_translation_file_mask'];
        $excludedFileMask = $config['excluded_file_mask'];
        $excludedDirectories = $config['excluded_directories'];

        if ($format == 'yml') {
            // Once the services definition are read, get your service and add a method call to setConfig()
            $serviceDefintion = $container->getDefinition('translation_files_service');
            $serviceDefintion->addMethodCall('setTranslationFilesDirPath', array($translationFilesDirPath));
            $serviceDefintion->addMethodCall('setFormat', array($format));
            $serviceDefintion->addMethodCall('setLocale', array($locale));
            $serviceDefintion->addMethodCall('setExcludeVendor', array($excludeVendorDirectory));
            $serviceDefintion->addMethodCall('setSrcDirPath', array($srcDirPath));
            $serviceDefintion->addMethodCall('setFormatToLookInto', array($formatToLookInto));
            $serviceDefintion->addMethodCall('setExcludedTranslationFileMask', array($excludedTranslationFileMask));
            $serviceDefintion->addMethodCall('setExcludedFileMask', array($excludedFileMask));
            $serviceDefintion->addMethodCall('setExcludedDirectories', array($excludedDirectories));
        } else {
            throw new \Exception('unknown format ' . $format);
        }

        // This is the KEY TO YOUR ANSWER
//        $container->setParameter( 'afe_translation_tool.translation_files_format', $config[ 'translation_files_format' ]);
//        $container->setParameter( 'afe_translation_tool.src_dir_name', $config[ 'src_dir_name' ]);

    }
}
