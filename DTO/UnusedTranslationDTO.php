<?php

namespace Afe\TranslationToolBundle\DTO;

/**
 * Created by PhpStorm.
 * User: amady
 * Date: 06/09/2015
 * Time: 15:56
 */
class UnusedTranslationDTO
{
    /**
     * @var TranslationCodeElement[]
     */
    public $unusedCodes;
    public $unusedCodesNumber;
    public $analyzedCodesNumber;

    /**
     * @param TranslationCodeElement[] $unusedCodes
     * @param $analyzedCodesNumber
     * @return DuplicatedTranslationDTO
     */
    public static function buildDTO(array $unusedCodes, $analyzedCodesNumber, $unusedCodesNumber)
    {
        $dto = new DuplicatedTranslationDTO();
        $dto->analyzedCodesNumber = $analyzedCodesNumber;
        $dto->unusedCodes = $unusedCodes;
        $dto->unusedCodesNumber = $unusedCodesNumber;
        return $dto;

    }
}
