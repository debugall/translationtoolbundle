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
    public $unusedCodes;
    public $unusedCodesNumber;
    public $analyzedCodesNumber;

    public static function buildDTO($unusedCodes, $analyzedCodesNumber)
    {
        $dto = new DuplicatedTranslationDTO();
        $dto->analyzedCodesNumber = $analyzedCodesNumber;
        $dto->unusedCodes = $unusedCodes;
        $dto->unusedCodesNumber = count($unusedCodes);
        return $dto;

    }
}