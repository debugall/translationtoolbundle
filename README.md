This bundle provide a set of tool to :
- Find unused translations code
- Find duplicated translations code

## Installation :

```
composer require afe/translation-tool-bundle:dev-master
```
 
```
// AppKernel.php
public function registerBundles()
{
    ...
    $bundles = array(
        ...
        new Afe\TranslationToolBundle\AfeTranslationToolBundle(),
        ...
    );
    ...
}
```

## Configuration :

```
# config.yml
afe_translation_tool:
    # translation files configuration
    translation_files_dir_path: "%kernel.root_dir%/.." # translation files root directory
    translation_files_locale: fr # locale of translations files to process
    translation_files_format: yml # translation files format to process (only yml is currently supported)
    excluded_translation_file_mask: ["dtc_*"] # excluded translations files from process
    exclude_vendor_directory: true # exclude vendor translation files. Default true

    # processed directory configuration
    src_dir_path: "%kernel.root_dir%/.." # src root directory
    format_to_look_into: ["twig", "html", "php", "js"] # look for unused translation in those given files
    excluded_file_mask: ["fr.json", "fr.js"] # file to exclude from the process
    excluded_directories: ["node_modules", "vendor", "data", "compiled", "bootstrap", "assets"] # file to exclude from the process
```

## Usage :

```
# display duplicated translations code
php app/console afe:translation:check:codes

# display unused translations code
php app/console afe:translation:unused:codes
```