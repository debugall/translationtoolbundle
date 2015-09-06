This bundle provide a set of tool to :
- Find unused translations code
- Find duplicated translations code

Installation :

    composer require afe/translation-tool-bundle:dev-master

Configuration :

```
\# config.yml
afe_translation_tool:
    translation_files_dir_path: "%kernel.root_dir%/.." # translation files root directory
    src_dir_path: "%kernel.root_dir%/.." # src root directory
    format_to_look_into: ["twig", "php"] # look for unused translation in those given files
    translation_files_locale: fr #
    translation_files_format: yml # translation file format (only yml is currently supported)
    exclude_vendor_directory: true # exclude vendor translation files default false
```

Usage :

```
\# display duplicated translations code
php app/console afe:translation:check:codes

\# display unused translations code
php app/console afe:translation:unused:codes
```