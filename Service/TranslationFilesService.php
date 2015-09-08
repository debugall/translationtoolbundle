<?php
/**
 * Created by PhpStorm.
 * User: amady
 * Date: 02/06/15
 * Time: 21:42
 */

namespace Afe\TranslationToolBundle\Service;


use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Yaml;

class TranslationFilesService  {

    /**
     * @var
     */
    private $srcDirPath;//injected by setter from bundle definition class
    private $translationFilesDirPath;//injected by setter from bundle definition class
    private $format;
    private $locale;
    private $excludeVendorDirectory;
    private $formatToLookInto;
    private $excludedTranslationFileMask;
    private $excludedFileMask;
    private $excludedDirectories;

    public function getAllTranslationCode()
    {
        $translationsFilesPath = $this->getTranslationFilesPath();

        //get an array of array (one array for each file)
        $translationsFilesArray = $this->filesToArray($translationsFilesPath);

        //get translations code (one array of translations code for each file)
        $translationsCode = $this->getTranslationsCodesArray($translationsFilesArray);
        return $translationsCode;
    }

    /**
     * Concat all keys in the given array
     * @param $code
     * @param $values
     * @param $result
     * @return string
     */
    public function concatKeys($code, $values, &$result)
    {
        if (is_array($values) == false) {
            $result[] = $code;
        } else {
            foreach ($values as $code2 => $values2) {
                $this->concatKeys($code.'.'.$code2, $values2, $result);
            }
        }
    }

    /**
     * For each file we inlines the tree structure
     * @param $translationsFilesArray
     * @return array
     */
    public function getTranslationsCodesArray($translationsFilesArray)
    {
        $result = [];
        foreach ($translationsFilesArray as $translationFileArray) {
            if(is_array($translationFileArray)) {
                foreach ($translationFileArray as $code => $values) {
                    $this->concatKeys($code, $values, $result);
                }
            }
        }
        return $result;
    }

    /**
     * @return Finder
     */
    public function getSrcDirFinder()
    {
        $finder = new Finder();
        $finder = $finder->in($this->srcDirPath)->exclude("cache")->exclude("logs");
        foreach ($this->formatToLookInto as $fileFormat) {
            $finder->name("*.".$fileFormat);
        }
        foreach ($this->excludedDirectories as $dir) {
            $finder->exclude($dir);
        }
        foreach ($this->excludedFileMask as $mask) {
            $finder->notName($mask);
        }
        $finder->files();
        return $finder;
    }


    /**
     * Return translation files path located inside src path
     * @return array of absolute path
     * array(2) {
        0 => "C:\Users\john\test\app\Resources\translations\messages.fr.yml"
        1 => "C:\Users\john\test\app\Resources\translations\messages2.fr.yml"
        }
     */
    public function getTranslationFilesPath()
    {
        $result = [];
        $resourcesDirFinder = new Finder();
        $resourcesDirFinder->directories()->name('translations')->in($this->translationFilesDirPath)
            ->exclude("cache")->exclude("logs")
        ;
        if ($this->excludeVendorDirectory) {
            $resourcesDirFinder->exclude("vendor");
        }

        foreach ($resourcesDirFinder as $dir) {

            $finder = new Finder();
            $finder->name("*." . $this->locale. "." .$this->format)->in($dir->getRealpath())->files();
            foreach ($this->excludedTranslationFileMask as $mask) {
                $finder->notName($mask);
            }
            foreach ($finder as $file) {
                $result[] = $file->getRealpath();
            }
        }
        return $result;
    }

    /**
     * Get yml files content inside an array
     * @param $translationsFilesPath
     * @return an array of array
     */
    public function filesToArray($translationsFilesPath)
    {
        $result = [];
        foreach ($translationsFilesPath as $filePath) {
            //every node in yml files correspond to a key in the returned array
            $array = $this->fileToArray($filePath);
            $result[] = $array;
        }
        return $result;
    }

    /**
     * Get yml file content inside an array
     * @param $filePath
     * @return mixed
     */
    public function fileToArray($filePath)
    {
        $yaml = new Parser();
        $array = $yaml->parse(file_get_contents($filePath));
        return $array;
    }

    /**
     * This function is called from bundle definition class
     * @param $dirPath
     */
    public function setTranslationFilesDirPath($translationFilesDirPath)
    {
        $this->translationFilesDirPath = $translationFilesDirPath;
    }

    /**
     * This function is called from bundle definition class
     * @param $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * This function is called from bundle definition class
     * @param $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * This function is called from bundle definition class
     * @param $excludeVendorDirectory
     */
    public function setExcludeVendor($excludeVendorDirectory)
    {
        $this->excludeVendorDirectory = $excludeVendorDirectory;
    }

    public function setSrcDirPath($srcDirPath)
    {
        $this->srcDirPath = $srcDirPath;
    }
    public function setFormatToLookInto($formatToLookInto)
    {
        $this->formatToLookInto = $formatToLookInto;
    }
    public function setExcludedTranslationFileMask($excludedTranslationFileMask)
    {
        $this->excludedTranslationFileMask = $excludedTranslationFileMask;
    }
    public function setExcludedFileMask($excludedFileMask)
    {
        $this->excludedFileMask = $excludedFileMask;
    }
    public function setExcludedDirectories($excludedDirectories)
    {
        $this->excludedDirectories = $excludedDirectories;
    }



}
