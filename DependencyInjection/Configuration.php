<?php

namespace Afe\TranslationToolBundle\DependencyInjection;

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
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('afe_translation_tool');
        $rootNode
            ->children()
                ->arrayNode("excluded_file_mask")
                    ->prototype('scalar')
                    ->end()
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode("excluded_directories")
                    ->prototype('scalar')
                    ->end()
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode("format_to_look_into")
                    ->prototype('scalar')
                    ->end()
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode("excluded_translation_file_mask")
                    ->prototype('scalar')
                    ->end()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('src_dir_path')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('translation_files_dir_path')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('translation_files_format')
                    ->validate()
                        ->ifNotInArray(['yml'])
                        ->thenInvalid("translation_files_format should be yml. Only this format is implemented")
                    ->end()
                ->end()
                ->scalarNode('translation_files_locale')
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('excluded_translation_directories')
                    ->prototype('scalar')
                    ->end()
                    ->cannotBeEmpty()
                ->end()
        ;

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
