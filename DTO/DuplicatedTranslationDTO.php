<?php

namespace Afe\TranslationToolBundle\DTO;

/**
 * Created by PhpStorm.
 * User: amady
 * Date: 06/09/2015
 * Time: 15:56
 */
class DuplicatedTranslationDTO
{
    public $duplicatedCodes;
    public $duplicatedCodesNumber;
    public $analyzedCodesNumber;

    public static function buildDTO($duplicatedCodes, $analyzedCodesNumber)
    {
        $dto = new DuplicatedTranslationDTO();
        $dto->analyzedCodesNumber = $analyzedCodesNumber;
        $dto->duplicatedCodes = $duplicatedCodes;
        $dto->duplicatedCodesNumber = count($duplicatedCodes);
        return $dto;

    }
}