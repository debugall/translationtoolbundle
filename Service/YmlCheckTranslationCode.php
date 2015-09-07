<?php
/**
 * Created by PhpStorm.
 * User: amady
 * Date: 02/06/15
 * Time: 21:42
 */

namespace Afe\TranslationToolBundle\Service;


use Afe\TranslationToolBundle\DTO\DuplicatedTranslationDTO;
use Afe\TranslationToolBundle\DTO\UnusedTranslationDTO;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Yaml;

class YmlCheckTranslationCode implements CheckTranslationCodeInterface {

    /**
     * @var
     */
    private $dirPath;//injected by setter from bundle definition class
    private $format;
    private $locale;


    public function __construct(TranslationFilesService $translationFilesService)
    {
        $this->translationFilesService = $translationFilesService;
    }

    /**
     * @return DuplicatedTranslationDTO
     */
    public function runCheckDuplicatedTranslationsCode()
    {
        //retrieve array of array of translation code
        $translationsCode = $this->translationFilesService->getAllTranslationCode();
        $duplicatedTranslationCodes = $this->getNotUniqueElements($translationsCode);
        $uniqueDuplicatedCodes =  array_unique($duplicatedTranslationCodes);
        return DuplicatedTranslationDTO::buildDTO($uniqueDuplicatedCodes, count($translationsCode));
    }

    /**
     *
     * @return UnusedTranslationDTO
     */
    public function runCheckUnusedTranslationsCode()
    {
        //retrieve array of array of translation code
        $translationsCodes = $this->translationFilesService->getAllTranslationCode();
        $translationsCodesNumber = count($translationsCodes);
        $result = $translationsCodes;

        $finder = $this->translationFilesService->getSrcDirFinder();
        foreach ($finder as $file) {
            $content = file_get_contents($file->getRealpath());
            foreach ($translationsCodes as $index => $translationCode) {
                if (strpos($content ,$translationCode) != false) {
                    unset($result[$index]);
                }
            }
        }
        return UnusedTranslationDTO::buildDTO($result, $translationsCodesNumber);
    }

    /**
     * Return duplicated keys
     * @param $rawArray
     * @return array
     */
    public function getNotUniqueElements($rawArray) {
        $dupes = array();
        natcasesort($rawArray);
        reset($rawArray);

        $old_key   = NULL;
        $old_value = NULL;
        foreach ($rawArray as $key => $value) {
            if ($value === NULL) { continue; }
            if (strcasecmp($old_value, $value) === 0) {
                $dupes[$old_key] = $old_value;
                $dupes[$key]     = $value;
            }
            $old_value = $value;
            $old_key   = $key;
        }
        return $dupes;
    }

}